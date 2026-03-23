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
        // 1. Buat Akun Admin Sekolah
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'shofia.lafarah74@gmail.com',
            'password' => Hash::make('smart-canteen.shofialafarah'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Penjual
        $penjual = User::create([
            'name' => 'Ibu Kantin',
            'email' => 'penjual@gmail.com',
            'password' => Hash::make('123123123'),
            'role' => 'penjual',
        ]);

        // 3. Buat Tokonya otomatis untuk penjual ini
        Shop::create([
            'user_id' => $penjual->id,
            'nama_warung' => 'Warung Berkah',
            'deskripsi' => 'Menyediakan makanan sehat dan bergizi',
        ]);

        // 4. Buat akun pembeli (siswa/guru)
        User::create([
            'name' => 'Siswa Teladan',
            'email' => 'pembeli@gmail.com',
            'password' => Hash::make('123123123'),
            'role' => 'pembeli',
            'balance' => 50000, // Kasih saldo awal buat jajan Pop Ice
        ]);
    }
}
