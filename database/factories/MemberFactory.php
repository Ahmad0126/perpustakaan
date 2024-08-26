<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_member' => fake()->randomNumber(7, true),
            'tanggal_lahir' => fake()->date(max: '-4 years'),
            'alamat' => fake()->address(),
            'pendidikan' => Arr::random(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2']),
            'pekerjaan' => Arr::random(['Pelajar', 'Pegawai Negeri', 'Karyawan Swasta', 'Wirausaha']),
            'id_user' => User::factory()
        ];
    }
}
