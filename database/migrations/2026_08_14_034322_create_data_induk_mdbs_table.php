<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_induk_mdbs', function (Blueprint $table) {
            $table->id();
            $table->string('idpel')->unique();
            $table->string('nama')->nullable();
            $table->string('namapnj')->nullable(); // Alamat/Jalan
            $table->string('tarif')->nullable();
            $table->integer('daya')->nullable();
            $table->string('nomor_meter_kwh')->nullable();
            $table->string('nomor_meter_prepaid')->nullable();
            $table->string('nomor_gardu')->nullable();
            $table->string('nama_gardu')->nullable();
            $table->string('nomor_jurusan_tiang')->nullable();
            $table->string('koordinat_x')->nullable(); // Latitude
            $table->string('koordinat_y')->nullable(); // Longitude
            $table->string('nama_kecamatan')->nullable();
            $table->string('nama_kelurahan')->nullable();
            $table->string('status_dil')->nullable();
            $table->timestamps();
            
            // Indeks untuk pencarian cepat
            $table->index('nomor_gardu');
            $table->index('nomor_jurusan_tiang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_induk_mdbs');
    }
};
