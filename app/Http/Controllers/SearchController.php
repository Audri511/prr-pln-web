<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsetPrr;
use App\Models\DataIndukMdb;
use App\Models\RiwayatPencarian;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $query = $request->query('query');
        $kategori = $request->query('kategori', 'semua');
        $status = $request->query('status', 'semua');


        // Mulai query ke DataIndukMdb sebagai basis, Join ke PRR agar bisa memprioritaskan aset bermasalah
        $dbQuery = DataIndukMdb::query()
                    ->leftJoin('aset_prrs', 'data_induk_mdbs.idpel', '=', 'aset_prrs.id_bangunan')
                    ->select('data_induk_mdbs.*')
                    ->orderByRaw('CASE WHEN aset_prrs.id_bangunan IS NOT NULL THEN 1 ELSE 2 END');

        if ($query) {
            $cleanQuery = preg_replace('/[^a-zA-Z0-9]/', '', $query);
            
            if ($kategori === 'tiang') {
                $dbQuery->whereRaw("REPLACE(REPLACE(REPLACE(nomor_jurusan_tiang, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"]);
            } elseif ($kategori === 'gardu') {
                $dbQuery->whereRaw("REPLACE(REPLACE(REPLACE(nomor_gardu, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"]);
            } elseif ($kategori === 'alamat') {
                $dbQuery->where('namapnj', 'like', "%{$query}%")
                        ->orWhere('nama_kecamatan', 'like', "%{$query}%")
                        ->orWhere('nama_kelurahan', 'like', "%{$query}%");
            } else {
                // Semua kategori
                $dbQuery->where(function ($q) use ($query, $cleanQuery) {
                    $q->whereRaw("REPLACE(REPLACE(REPLACE(nomor_jurusan_tiang, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"])
                      ->orWhereRaw("REPLACE(REPLACE(REPLACE(nomor_gardu, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"])
                      ->orWhere('namapnj', 'like', "%{$query}%")
                      ->orWhere('idpel', 'like', "%{$cleanQuery}%");
                });
            }
        }

        // Limit agar tidak lemot karena data > 200rb
        $hasil_induk = $dbQuery->limit(20)->get();
        
        // ---------------------------------------------------------
        // FALLBACK: Cari di tabel AsetPrr (Data Excel Lama)
        // Kalau belum mencapai 20 limit, kita cari sisanya di AsetPrr 
        // yang id-nya tidak ada di DataIndukMdb
        // ---------------------------------------------------------
        $sisa_limit = 20 - $hasil_induk->count();
        $hasil_prr_lama = collect();
        
        if ($query && $sisa_limit > 0) {
            $prrQuery = AsetPrr::query()
                ->whereNotIn('id_bangunan', $hasil_induk->pluck('idpel')->toArray());
                
            $cleanQuery = preg_replace('/[^a-zA-Z0-9]/', '', $query);
            
            if ($kategori === 'tiang') {
                $prrQuery->whereRaw("REPLACE(REPLACE(REPLACE(no_tiang, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"]);
            } elseif ($kategori === 'gardu') {
                $prrQuery->whereRaw("REPLACE(REPLACE(REPLACE(id_gardu, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"]);
            } elseif ($kategori === 'alamat') {
                $prrQuery->where('alamat_lengkap', 'like', "%{$query}%")
                        ->orWhere('nama_pelanggan_terakhir', 'like', "%{$query}%");
            } else {
                $prrQuery->where(function ($q) use ($query, $cleanQuery) {
                    $q->whereRaw("REPLACE(REPLACE(REPLACE(no_tiang, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"])
                      ->orWhereRaw("REPLACE(REPLACE(REPLACE(id_gardu, '-', ''), '#', ''), ' ', '') LIKE ?", ["%{$cleanQuery}%"])
                      ->orWhere('alamat_lengkap', 'like', "%{$query}%")
                      ->orWhere('id_bangunan', 'like', "%{$cleanQuery}%")
                      ->orWhere('nama_pelanggan_terakhir', 'like', "%{$query}%");
                });
            }
            
            $hasil_prr_lama = $prrQuery->limit($sisa_limit)->get();
        }

        // Map ke object yang mirip dengan AsetPrr yang lama agar view search-results tetap jalan
        $hasil1 = $hasil_induk->map(function($item) {
            // Cek apakah ID ini ada di tabel PRR
            $prr = AsetPrr::where('id_bangunan', $item->idpel)->first();
            
            $item->id = $item->idpel; // Untuk link detail
            $item->id_bangunan = $item->idpel;
            $item->no_tiang = $item->nomor_jurusan_tiang;
            $item->id_gardu = $item->nomor_gardu;
            $item->alamat_lengkap = $item->namapnj . ' Kec. ' . $item->nama_kecamatan;
            $item->status_prr = $prr ? true : false;
            $item->jumlah_tunggakan = $prr ? $prr->jumlah_tunggakan : 0;
            return $item;
        });
        
        // Map hasil fallback (dari excel lama)
        $hasil2 = $hasil_prr_lama->map(function($item) {
            $item->id = $item->id_bangunan; 
            $item->id_bangunan = $item->id_bangunan;
            $item->no_tiang = $item->no_tiang ?? '-';
            $item->id_gardu = $item->id_gardu ?? '-';
            $item->alamat_lengkap = $item->alamat_lengkap ?? $item->alamat ?? 'Alamat tidak tersedia';
            $item->status_prr = true; // Excel lama by default adalah tunggakan PRR
            $item->jumlah_tunggakan = $item->jumlah_tunggakan;
            return $item;
        });
        
        $hasil = $hasil1->concat($hasil2);

        // Filter status PRR setelah di map
        if ($status === 'prr') {
            $hasil = $hasil->filter(fn($i) => $i->status_prr == true);
        } elseif ($status === 'aman') {
            $hasil = $hasil->filter(fn($i) => $i->status_prr == false);
        }

        // Sorting
        $sort = $request->query('sort', 'default');
        if ($sort === 'tunggakan_desc') {
            $hasil = $hasil->sortByDesc('jumlah_tunggakan')->values();
        } elseif ($sort === 'tunggakan_asc') {
            $hasil = $hasil->sortBy('jumlah_tunggakan')->values();
        }

        // Deteksi cerdas kategori
        $detectedCategory = 'alamat';
        if ($query) {
            $queryUpper = strtoupper(trim($query));
            if (str_starts_with($queryUpper, 'T-')) {
                $detectedCategory = 'tiang';
            } elseif (str_starts_with($queryUpper, 'GD-')) {
                $detectedCategory = 'gardu';
            } elseif (str_starts_with($queryUpper, 'BGN-')) {
                $detectedCategory = 'bangunan';
            } elseif ($hasil->isNotEmpty()) {
                $first = $hasil->first();
                if (stripos($first->no_tiang, $query) !== false) {
                    $detectedCategory = 'tiang';
                } elseif (stripos($first->id_gardu, $query) !== false) {
                    $detectedCategory = 'gardu';
                } elseif (stripos($first->id_bangunan, $query) !== false) {
                    $detectedCategory = 'bangunan';
                }
            }
        }

        // Simpan riwayat pencarian jika ada query
        if ($query) {
            if ($hasil->isNotEmpty()) {
                RiwayatPencarian::updateOrCreate(
                    [
                        'petugas_id' => Auth::id(),
                        'kata_kunci' => $query,
                    ],
                    [
                        'kategori_pencarian' => $detectedCategory,
                        'ditemukan' => true,
                        'updated_at' => now(),
                    ]
                );
            } else {
                // Hapus riwayat jika ternyata zonk (biar tidak nyangkut di dashboard)
                RiwayatPencarian::where('petugas_id', Auth::id())
                    ->where('kata_kunci', $query)
                    ->delete();
            }
        }

        return view('teknisi.search-results', compact('query', 'kategori', 'hasil', 'status', 'sort'));
    }

    public function nearby(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (!$lat || !$lng) {
            return redirect()->route('dashboard')->with('error', 'Lokasi GPS tidak ditemukan.');
        }

        // Haversine formula to calculate distance in KM
        $hasil = AsetPrr::select('*', \Illuminate\Support\Facades\DB::raw("6371 * acos(cos(radians($lat))
            * cos(radians(latitude)) * cos(radians(longitude) - radians($lng))
            + sin(radians($lat)) * sin(radians(latitude))) AS distance"))
            ->whereNotNull('latitude')
            ->orderBy('distance')
            ->take(5)
            ->get();
            
        // Map ID so the view link works correctly
        $hasil = $hasil->map(function($item) {
            $item->id = $item->id_bangunan;
            return $item;
        });

        $query = "Lokasi Saya (Radius Terdekat)";
        $kategori = 'semua';
        $status = 'semua';
        $isNearby = true;
        
        $sort = $request->query('sort', 'default');
        if ($sort === 'tunggakan_desc') {
            $hasil = $hasil->sortByDesc('jumlah_tunggakan')->values();
        } elseif ($sort === 'tunggakan_asc') {
            $hasil = $hasil->sortBy('jumlah_tunggakan')->values();
        }

        return view('teknisi.search-results', compact('query', 'kategori', 'hasil', 'status', 'isNearby', 'sort'));
    }
}
