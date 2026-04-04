<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => env('ADMIN_NAME', 'Default Admin'),
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'role' => 'admin',
        ]);

        // 2. Penjual
        $penjual = User::create([
            'name' => env('PENJUAL_NAME', 'Penjual'),
            'email' => env('PENJUAL_EMAIL'),
            'password' => Hash::make(env('PENJUAL_PASSWORD')),
            'role' => 'penjual',
        ]);

        Shop::create([
            'user_id' => $penjual->id,
            'nama_warung' => 'Warung Berkah',
            'deskripsi' => 'Menyediakan makanan sehat dan bergizi',
        ]);

        // 3. Siswa
        User::create([
            'name' => env('SISWA_NAME'),
            'nisn' => env('SISWA_NISN'),
            'email' => null,
            'password' => Hash::make(env('SISWA_PASSWORD')),
            'role' => 'pembeli',
            'balance' => 50000,
        ]);

        // 4. Guru
        User::create([
            'name' => env('GURU_NAME'),
            'email' => env('GURU_EMAIL'),
            'password' => Hash::make(env('GURU_PASSWORD')),
            'role' => 'pembeli',
            'balance' => 100000,
        ]);
    }
}
