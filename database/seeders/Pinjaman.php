<?php

namespace Database\Seeders;

use App\Models\DetailPinjaman;
use App\Models\Pinjaman as ModelsPinjaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Pinjaman extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsPinjaman::factory(7)->create();
        DetailPinjaman::factory(28)->create();
    }
}
