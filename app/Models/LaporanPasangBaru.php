<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPasangBaru extends Model
{
    use HasFactory;

    protected $fillable = [
        'petugas_id',
        'id_tiang_gardu',
        'status_pemasangan',
        'id_pelanggan_baru',
        'keterangan_kendala',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }
}
