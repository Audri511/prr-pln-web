<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AsetPrr>
 */
class AsetPrrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status_prr = fake()->boolean(40); // 40% chance of having PRR
        return [
            'id_bangunan' => 'BGN-' . fake()->unique()->numerify('#####') . '-' . fake()->lexify('??'),
            'no_tiang' => 'TG-' . fake()->numerify('###') . '-' . fake()->lexify('?'),
            'id_gardu' => 'GD-' . fake()->lexify('???') . '-' . fake()->numerify('##'),
            'alamat_lengkap' => fake()->address(),
            'id_pelanggan_terakhir' => $status_prr ? '53' . fake()->numerify('########') : null,
            'nama_pelanggan_terakhir' => $status_prr ? fake()->name() : null,
            'tgl_tunggakan' => $status_prr ? fake()->dateTimeBetween('-2 years', 'now') : null,
            'jumlah_tunggakan' => $status_prr ? fake()->numberBetween(100000, 5000000) : 0,
            'status_prr' => $status_prr,
            'latitude' => fake()->randomFloat(6, -6.940000, -6.910000), // Sukabumi lat range
            'longitude' => fake()->randomFloat(6, 106.900000, 106.940000), // Sukabumi lng range
        ];
    }
}
