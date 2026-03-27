<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat kategori
        \App\Models\Category::create(['nama_kategori' => 'Makanan']);
        \App\Models\Category::create(['nama_kategori' => 'Minuman']);
        \App\Models\Category::create(['nama_kategori' => 'Snack']);

        $this->call([
            UserSeeder::class,
        ]);
    }
}
