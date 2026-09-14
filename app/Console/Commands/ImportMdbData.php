<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\DataIndukMdb;
use App\Models\AsetPrr;

class ImportMdbData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mdb:import {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import MDB file to database and setup dummy PRR targets for demo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename') ?? 'DIL_SALDO_MASK_UP_202606_53611.mdb';
        $path = base_path($filename);

        if (!file_exists($path)) {
            $this->error("File MDB tidak ditemukan di: " . $path);
            return;
        }

        $this->info("1. Mengekspor MDB ke CSV sementara (bisa memakan waktu beberapa menit)...");
        $csvPath = storage_path('app/temp_dil.csv');
        exec("mdb-export " . escapeshellarg($path) . " DIL_SALDO_MASK_UP_202606_53611 > " . escapeshellarg($csvPath));

        if (!file_exists($csvPath)) {
            $this->error("Gagal mengekspor MDB ke CSV!");
            return;
        }

        $this->info("2. Mengosongkan tabel data_induk_mdbs...");
        DataIndukMdb::truncate();

        $this->info("3. Membaca dan mengimpor CSV...");
        
        $handle = fopen($csvPath, "r");
        if ($handle !== FALSE) {
            $headers = fgetcsv($handle, 0, ","); // Skip header
            
            // Map header indexes to what we need
            $colMap = [];
            foreach ($headers as $i => $col) {
                $colMap[strtoupper(trim($col))] = $i;
            }
            
            $chunk = [];
            $count = 0;
            
            // Tampilkan progress bar (karena ada sekitar 207000 data)
            $bar = $this->output->createProgressBar(207144);
            $bar->start();
            
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                // Pastikan ada IDPEL
                if (!isset($colMap['IDPEL']) || !isset($data[$colMap['IDPEL']]) || empty(trim($data[$colMap['IDPEL']]))) {
                    continue;
                }

                $chunk[] = [
                    'idpel' => $data[$colMap['IDPEL']] ?? null,
                    'nama' => $data[$colMap['NAMA']] ?? null,
                    'namapnj' => $data[$colMap['NAMAPNJ']] ?? null,
                    'tarif' => $data[$colMap['TARIF']] ?? null,
                    'daya' => (int) ($data[$colMap['DAYA']] ?? 0),
                    'nomor_meter_kwh' => $data[$colMap['NOMOR_METER_KWH']] ?? null,
                    'nomor_meter_prepaid' => $data[$colMap['NOMOR_METER_PREPAID']] ?? null,
                    'nomor_gardu' => $data[$colMap['NOMOR_GARDU']] ?? null,
                    'nama_gardu' => $data[$colMap['NAMA_GARDU']] ?? null,
                    'nomor_jurusan_tiang' => $data[$colMap['NOMOR_JURUSAN_TIANG']] ?? null,
                    'koordinat_x' => $data[$colMap['KOORDINAT_X']] ?? null,
                    'koordinat_y' => $data[$colMap['KOORDINAT_Y']] ?? null,
                    'nama_kecamatan' => $data[$colMap['NAMA_KECAMATAN']] ?? null,
                    'nama_kelurahan' => $data[$colMap['NAMA_KELURAHAN']] ?? null,
                    'status_dil' => $data[$colMap['STATUS_DIL']] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $count++;
                
                if (count($chunk) >= 1000) {
                    // Pakai try-catch untuk skip duplicate IDPEL
                    try {
                        DataIndukMdb::insertOrIgnore($chunk);
                    } catch (\Exception $e) {}
                    $chunk = [];
                    $bar->advance(1000);
                }
            }
            
            // Insert sisa chunk
            if (!empty($chunk)) {
                try {
                    DataIndukMdb::insertOrIgnore($chunk);
                } catch (\Exception $e) {}
            }
            
            fclose($handle);
            $bar->finish();
            $this->newLine();
        }
        
        // Bersihkan file CSV
        @unlink($csvPath);
        
        $this->info("✅ Berhasil mengimpor $count data Induk!");
        
        $this->info("4. Membangun ulang Dummy Target PRR dari Data Asli...");
        
        AsetPrr::truncate();
        
        // Ambil 30 data acak dari Data Induk untuk dijadikan target PRR (Merah)
        $targets = DataIndukMdb::inRandomOrder()->limit(30)->get();
        
        foreach ($targets as $target) {
            AsetPrr::create([
                'id_bangunan' => $target->idpel,
                'no_tiang' => current(explode(',', $target->nomor_jurusan_tiang ?? 'A1')),
                'id_gardu' => current(explode(',', $target->nomor_gardu ?? 'GD1')),
                'alamat_lengkap' => $target->namapnj . ' Kec. ' . $target->nama_kecamatan,
                'latitude' => is_numeric($target->koordinat_x) ? $target->koordinat_x : '-6.920',
                'longitude' => is_numeric($target->koordinat_y) ? $target->koordinat_y : '106.920',
                'status_prr' => true,
                'jumlah_tunggakan' => rand(1, 10) * 1000000, // Rp 1jt - 10jt
                'tgl_tunggakan' => now()->subMonths(rand(1, 12))->format('Y-m-d'),
                'id_pelanggan_terakhir' => $target->idpel,
                'nama_pelanggan_terakhir' => $target->nama
            ]);
        }
        
        $this->info("✅ Berhasil membuat 30 Target PRR dari data MDB asli!");
        
        // Tampilkan 2 contoh Merah dan 2 contoh Hijau
        $this->newLine();
        $this->info("🌟 CONTOH DATA UNTUK DEMO APLIKASI 🌟");
        $this->info("========================================");
        
        // Merah (PRR)
        $this->warn("🔴 CONTOH DATA MERAH (PRR / TARGET TUNGGAKAN):");
        $merahs = AsetPrr::limit(3)->get();
        foreach ($merahs as $m) {
            $this->line("- ID PELANGGAN: " . $m->id_bangunan . " (Atas Nama: " . $m->nama_pelanggan_terakhir . ")");
        }
        
        $this->newLine();
        
        // Hijau (Aman)
        $this->info("🟢 CONTOH DATA HIJAU (LANCAR / AMAN):");
        // Cari ID yang tidak ada di aset_prrs
        $hijauses = DataIndukMdb::whereNotIn('idpel', $merahs->pluck('id_bangunan'))->limit(3)->get();
        foreach ($hijauses as $h) {
            $this->line("- ID PELANGGAN: " . $h->idpel . " (Atas Nama: " . $h->nama . ")");
        }
        
        $this->newLine();
        $this->info("Semua persiapan data selesai! Aplikasi siap didemokan.");
    }
}
