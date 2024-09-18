<?php

namespace Database\Factories;

use App\Models\Denda;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Denda>
 */
class DendaFactory extends Factory
{
    protected $model = Denda::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $member = Member::inRandomOrder()->first();
        $bayar = fake()->boolean(70);
        $tanggal = fake()->dateTimeBetween('-4 years', 'now')->format('Y-m-d');
        return [
            'id_member' => $member->id,
            'nominal' => fake()->randomNumber(2).'000',
            'tanggal' => $tanggal,
            'tanggal_dibayar' => $bayar ? fake()->dateTimeBetween($tanggal, 'now')->format('Y-m-d') : null,
            'status' => $bayar ? 'dibayar' : 'belum dibayar',
            'kode_verifikasi' => fake()->regexify('[A-Z]{5}[0-9]{3}'),
        ];
    }
}
