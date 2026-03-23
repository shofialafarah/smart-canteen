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
        // Buat kategori default agar ID 1 tersedia
        \App\Models\Category::create([
            'nama_kategori' => 'Makanan & Minuman'
        ]);

        $this->call([
            UserSeeder::class,
        ]);
    }
}
