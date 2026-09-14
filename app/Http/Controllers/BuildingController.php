<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsetPrr;
use App\Models\DataIndukMdb;

use App\Models\RiwayatPencarian;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    public function show($id)
    {
        // Cek Data Induk
        $dataInduk = DataIndukMdb::where('idpel', $id)->first();
        
        // Cek daftar PRR
        $prr = AsetPrr::where('id_bangunan', $id)->first();
        
        if (!$dataInduk && !$prr) {
            // Hapus riwayat pencarian yang sudah usang ini
            RiwayatPencarian::where('petugas_id', Auth::id())
                ->where('kata_kunci', $id)
                ->delete();
                
            return redirect()->route('dashboard')->with('error', "Data aset '{$id}' tidak ditemukan di Excel PRR terbaru. Riwayat usang ini telah otomatis dihapus dari dashboard Anda.");
        }
        
        if ($dataInduk) {
            $bangunan = (object)[
                'id_bangunan' => $dataInduk->idpel,
                'no_tiang' => $dataInduk->nomor_jurusan_tiang,
                'id_gardu' => $dataInduk->nomor_gardu,
                'alamat_lengkap' => $dataInduk->namapnj . ' Kec. ' . $dataInduk->nama_kecamatan,
                'latitude' => $dataInduk->koordinat_x,
                'longitude' => $dataInduk->koordinat_y,
                'status_prr' => $prr ? true : false,
                'total_tunggakan' => $prr ? $prr->jumlah_tunggakan : 0,
            ];
        } else {
            // Fallback kalau cuma ada di AsetPrr (dummy lama / excel lama)
            $bangunan = (object)[
                'id_bangunan' => $prr->id_bangunan,
                'no_tiang' => $prr->no_tiang ?? '-',
                'id_gardu' => $prr->id_gardu ?? '-',
                'alamat_lengkap' => $prr->alamat_lengkap ?? $prr->alamat ?? 'Alamat tidak tersedia',
                'latitude' => $prr->latitude ?? null,
                'longitude' => $prr->longitude ?? null,
                'status_prr' => true,
                'total_tunggakan' => $prr->jumlah_tunggakan,
            ];
            
            // Bikin mock dataInduk biar UI nggak error/kosong melompong
            $dataInduk = (object)[
                'nama' => $prr->nama_pelanggan_terakhir ?? 'Data Lama (Dummy)',
                'tarif' => '-',
                'daya' => '-',
                'nomor_gardu' => $prr->id_gardu ?? '-',
                'status_dil' => 'DUMMY',
            ];
        }

        return view('teknisi.detail-bangunan', compact('bangunan', 'dataInduk', 'prr'));
    }
}