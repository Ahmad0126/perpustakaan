<?php

namespace Database\Seeders;

use App\Models\Member as ModelsMember;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Member extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(4)->recycle(ModelsMember::factory(4)->create())->make([
            'username' => fake()->email(),
            'level' => 'Member',
        ]);
    }
}
