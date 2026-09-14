<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petugas::create([
            'username' => 'audri',
            'nama_petugas' => 'Audri Melina Muthi Katidjan',
            'password' => Hash::make('password123'),
        ]);

        Petugas::factory(5)->create();
    }
}
