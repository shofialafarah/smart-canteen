<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // 1. Admin (Login pakai Email)
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'shofia.lafarah74@gmail.com',
            'password' => Hash::make('smart-canteen.shofialafarah'),
            'role' => 'admin',
        ]);

        // 2. Penjual (Login pakai Email)
        $penjual = User::create([
            'name' => 'Ibu Kantin',
            'email' => 'penjual@gmail.com',
            'password' => Hash::make('123123123'),
            'role' => 'penjual',
        ]);

        Shop::create([
            'user_id' => $penjual->id,
            'nama_warung' => 'Warung Berkah',
            'deskripsi' => 'Menyediakan makanan sehat dan bergizi',
        ]);

        // 3. Siswa (LOGIN PAKAI NISN)
        User::create([
            'name' => 'Siswa Teladan',
            'nisn' => '12345678', // NISN diisi
            'email' => null,      // Email dikosongkan (Siswa gak perlu email)
            'password' => Hash::make('123123123'), // Password SAMA dengan NISN
            'role' => 'pembeli',
            'balance' => 50000,
        ]);

        // 4. Guru (LOGIN PAKAI EMAIL)
        User::create([
            'name' => 'Pak Guru Budi',
            'nisn' => null,       // Guru gak punya NISN
            'email' => 'budi@guru.com',
            'password' => Hash::make('123123123'),
            'role' => 'pembeli',
            'balance' => 100000,
        ]);
    }
}
