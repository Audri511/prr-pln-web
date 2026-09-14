<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BuildingController;
use App\Models\RiwayatPencarian;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route sementara untuk membersihkan riwayat bangunan yang nyangkut
Route::get('/clear-history', function () {
    \App\Models\RiwayatPencarian::where('kategori_pencarian', 'bangunan')->delete();
    return redirect()->route('dashboard')->with('success', 'Riwayat bangunan bodong berhasil dihapus! Silakan cek kembali.');
});

Route::get('/debug', function () {
    return [
        'auth_id' => Auth::id(),
        'petugas' => \App\Models\Petugas::first(),
    ];
});

Route::get('/debug-nama', function () {
    $data = \App\Models\DataIndukMdb::first();
    return response()->json(['nama_asli_di_db' => $data->nama]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout']);
    
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [SearchController::class, 'results'])->name('search.results');
    Route::get('/search-nearby', [SearchController::class, 'nearby'])->name('search.nearby');
    Route::get('/bangunan/{id}', [BuildingController::class, 'show'])->name('bangunan.detail');
    
        Route::post('/riwayat/clear', function () {
        \App\Models\RiwayatPencarian::where('petugas_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Riwayat pencarian berhasil dibersihkan!');
    })->name('riwayat.clear');
    Route::get('/riwayat', function () {
        $riwayat = RiwayatPencarian::where('petugas_id', Auth::id())->orderBy('updated_at', 'desc')->get()->unique('kata_kunci');
        $laporanPasang = \App\Models\LaporanPasangBaru::where('petugas_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view(Auth::user()->role === 'manager' ? 'manager.riwayat' : 'teknisi.riwayat', compact('riwayat', 'laporanPasang'));
    })->name('riwayat');
    
        
    Route::get('/scan', function () {
        return view('teknisi.scan');
    })->name('scan');

    // Laporan Pasang Baru Routes
    Route::get('/laporan/rekap', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    
    // Bookmark Routes
    Route::get('/bookmarks/data', [\App\Http\Controllers\BookmarkController::class, 'data'])->name('bookmark.data');
    Route::post('/bookmarks/toggle', [\App\Http\Controllers\BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::get('/laporan/baru', [\App\Http\Controllers\LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan/baru', [\App\Http\Controllers\LaporanController::class, 'store'])->name('laporan.simpan');

    // Profile & Settings
    Route::get('/profile', function () {
        $laporanCount = \App\Models\LaporanPasangBaru::where('petugas_id', Auth::id())->count();
        return view('profile.index', compact('laporanCount'));
    })->name('profile');
    
    Route::post('/profile', function (\Illuminate\Http\Request $request) {
        $request->validate(['nama_petugas' => 'required|string|max:255']);
        $user = Auth::user();
        $user->nama_petugas = $request->nama_petugas;
        $user->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    })->name('profile.update');
    
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');
});

Route::post('/notifications/mark-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->middleware('auth')->name('notifications.read');
