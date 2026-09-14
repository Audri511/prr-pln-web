<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PetugasFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'nama_petugas',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
