<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPencarian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $recentSearches = RiwayatPencarian::where('petugas_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get()
            ->unique('kata_kunci')
            ->take(3);

        return view('teknisi.dashboard', compact('recentSearches'));
    }
}
