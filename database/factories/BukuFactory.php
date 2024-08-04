<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Buku::class;
    public function definition(): array
    {
        return [
            'judul' => fake()->realText(40),
            'penulis' => fake()->name(),
            'penerbit' => fake()->company(),
            'nomor_buku' => Arr::random([800, 500, 100]).'-'.fake()->randomNumber(4, true),
            'jumlah' => fake()->randomDigitNotNull(),
            'tanggal_rilis' => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
        ];
    }
}
