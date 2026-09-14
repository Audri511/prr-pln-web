<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKetidaksesuaian extends Model
{
    use HasFactory;

    protected $table = 'laporan_ketidaksesuaian';

    protected $fillable = [
        'petugas_id',
        'idpel_terkait',
        'judul',
        'deskripsi',
        'status',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }
}
