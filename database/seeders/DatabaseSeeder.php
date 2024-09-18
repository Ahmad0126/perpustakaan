<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(Buku::class);
        // $this->call(Member::class);
        // $this->call(Pinjaman::class);
        // \App\Models\Denda::factory(5)->create();
        \App\Models\Koleksi::factory(30)->create();
        \App\Models\Ulasan::factory(50)->create();
    }
}
