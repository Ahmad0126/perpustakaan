<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Pinjaman;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pinjaman>
 */
class PinjamanFactory extends Factory
{
    protected $model = Pinjaman::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $buku = Buku::inRandomOrder()->first();
        $tanggal = fake()->dateTimeBetween('-2 years');
        return [
            'id_buku' => $buku->id,
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 day', $tanggal->getTimestamp())),
            'tanggal_dipinjam' => $tanggal->format('Y-m-d'),
            'status' => Arr::random(['dipinjam', 'dikembalikan']),
        ];
    }
}
