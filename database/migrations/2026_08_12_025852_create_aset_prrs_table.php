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
        Schema::create('aset_prrs', function (Blueprint $table) {
            $table->id();
            $table->string('id_bangunan')->unique();
            $table->string('no_tiang')->index();
            $table->string('id_gardu')->index();
            $table->text('alamat_lengkap');
            $table->string('id_pelanggan_terakhir')->nullable();
            $table->string('nama_pelanggan_terakhir')->nullable();
            $table->date('tgl_tunggakan')->nullable();
            $table->decimal('jumlah_tunggakan', 15, 2)->default(0);
            $table->boolean('status_prr')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_prrs');
    }
};
