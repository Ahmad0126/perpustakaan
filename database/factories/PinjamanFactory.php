<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Member;
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
        $member = Member::inRandomOrder()->first();
        return [
            'id_member' => $member->id,
            'status' => Arr::random(['dipinjam', 'dikembalikan']),
            'tanggal_dipinjam' => fake()->dateTimeBetween('-2 years')->format('Y-m-d')
        ];
    }
}
