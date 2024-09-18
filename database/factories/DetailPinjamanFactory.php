<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Support\Arr;
use App\Models\DetailPinjaman;
use App\Models\Pinjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailPinjaman>
 */
class DetailPinjamanFactory extends Factory
{
    protected $model = DetailPinjaman::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $buku = Buku::inRandomOrder()->first();
        $pinjaman = Pinjaman::inRandomOrder()->first();
        return [
            'id_buku' => $buku->id,
            'status' => Arr::random(['dipinjam', 'dikembalikan']),
            'id_pinjaman' => $pinjaman->id,
            'tanggal_kembali' => date('Y-m-d', strtotime('+2 week', strtotime($pinjaman->tanggal_dipinjam)))
        ];
    }
}
