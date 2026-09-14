<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Petugas::create([
            'username' => 'manager',
            'nama_petugas' => 'Manager',
            'role' => 'manager',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            PetugasSeeder::class,
            AsetPrrSeeder::class,
        ]);
    }
}
