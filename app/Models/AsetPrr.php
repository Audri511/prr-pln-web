<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetPrr extends Model
{
    /** @use HasFactory<\Database\Factories\AsetPrrFactory> */
    use HasFactory;

    protected $fillable = [
        'id_bangunan',
        'no_tiang',
        'id_gardu',
        'alamat_lengkap',
        'id_pelanggan_terakhir',
        'nama_pelanggan_terakhir',
        'tgl_tunggakan',
        'jumlah_tunggakan',
        'status_prr',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'status_prr' => 'boolean',
        'tgl_tunggakan' => 'date',
    ];
}
