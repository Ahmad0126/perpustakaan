<?php

namespace Database\Seeders;

use App\Models\Buku as ModelsBuku;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Buku extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::factory(3)->create();
        ModelsBuku::factory(12)->create();
    }
}
