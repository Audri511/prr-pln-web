<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanKetidaksesuaian;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $laporan = LaporanKetidaksesuaian::where('petugas_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view(Auth::user()->role === 'manager' ? 'manager.pengaturan' : 'teknisi.pengaturan', compact('user', 'laporan'));
    }

    public function storeLaporan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'idpel_terkait' => 'nullable|string|max:50',
        ]);

        LaporanKetidaksesuaian::create([
            'petugas_id' => Auth::id(),
            'idpel_terkait' => $request->idpel_terkait,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim. Terima kasih atas masukan Anda!');
    }
}
