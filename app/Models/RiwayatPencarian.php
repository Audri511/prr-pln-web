<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPencarian extends Model
{
    /** @use HasFactory<\Database\Factories\RiwayatPencarianFactory> */
    use HasFactory;

    protected $fillable = [
        'petugas_id',
        'kategori_pencarian',
        'kata_kunci',
        'ditemukan',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
