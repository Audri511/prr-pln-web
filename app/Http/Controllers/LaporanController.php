<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPasangBaru;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        if (Auth::user()->role !== 'manager') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // --- 1. TABLE QUERY LOGIC ---
        $query = LaporanPasangBaru::with('petugas')->latest();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id_pelanggan_baru', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('petugas', function($q2) use ($searchTerm) {
                      $q2->where('nama_petugas', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        
        // Auto-swap dates if user inputs them backwards
        if ($start_date && $end_date && $start_date > $end_date) {
            $temp = $start_date;
            $start_date = $end_date;
            $end_date = $temp;
        }

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [
                \Carbon\Carbon::parse($start_date)->startOfDay(),
                \Carbon\Carbon::parse($end_date)->endOfDay()
            ]);
        } elseif ($start_date) {
            $query->whereDate('created_at', '>=', \Carbon\Carbon::parse($start_date)->startOfDay());
        } elseif ($end_date) {
            $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($end_date)->endOfDay());
        }

        $laporans = $query->get();

        // --- 2. CARDS WIDGET LOGIC (Global Filter) ---
        // Instead of querying month, we use the EXACT SAME date filter for the cards
        $cardQuery = LaporanPasangBaru::query();
        
        if ($start_date && $end_date) {
            $cardQuery->whereBetween('created_at', [
                \Carbon\Carbon::parse($start_date)->startOfDay(),
                \Carbon\Carbon::parse($end_date)->endOfDay()
            ]);
        } elseif ($start_date) {
            $cardQuery->whereDate('created_at', '>=', \Carbon\Carbon::parse($start_date)->startOfDay());
        } elseif ($end_date) {
            $cardQuery->whereDate('created_at', '<=', \Carbon\Carbon::parse($end_date)->endOfDay());
        }

        // Keep variable names same for backward compatibility in view, but meaning is now "Filtered"
        $monthCount = $cardQuery->count();
        $teknisiAktif = clone $cardQuery;
        $teknisiAktif = $teknisiAktif->distinct('petugas_id')->count('petugas_id');
        
        // "Hari ini" still shows purely today for quick reference, unaffected by filter
        $todayCount = LaporanPasangBaru::whereDate('created_at', \Carbon\Carbon::today())->count();
        
        return view('manager.dashboard', compact(
            'laporans', 
            'todayCount', 
            'monthCount', 
            'teknisiAktif', 
            'start_date',
            'end_date'
        ));
    }

    public function create(Request $request)
    {
        if (Auth::user()->role !== 'teknisi') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        return view('teknisi.lapor-pasang');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'teknisi') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'id_pelanggan_baru' => 'required|string|size:12',
        ], [
            'id_pelanggan_baru.required' => 'ID Pelanggan wajib diisi.',
            'id_pelanggan_baru.size' => 'ID Pelanggan Baru WAJIB 12 angka.',
        ]);

        $laporan = LaporanPasangBaru::create([
            'petugas_id' => Auth::id(),
            'id_tiang_gardu' => '-', // Dummy value to satisfy database constraint
            'status_pemasangan' => 'berhasil',
            'id_pelanggan_baru' => $request->id_pelanggan_baru,
            'keterangan_kendala' => null,
        ]);

        // Send Notification to the Technician
        $user = Auth::user();
        $user->notify(new \App\Notifications\LaporanBerhasilNotification($laporan));

        // Send Notification to ALL Managers
        $managers = \App\Models\Petugas::where('role', 'manager')->get();
        foreach ($managers as $manager) {
            $manager->notify(new \App\Notifications\LaporanBaruManagerNotification($laporan));
        }

        return redirect()->route('laporan.create')->with('success', 'Laporan Pemasangan berhasil disubmit!');
    }
}