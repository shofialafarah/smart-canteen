# Smart Canteen App

## Tentang Projek
**Smart Canteen** adalah aplikasi berbasis web yang dirancang untuk mendigitalisasi proses pemesanan makanan di kantin. Aplikasi ini bertujuan untuk mengurangi antrean fisik, memudahkan pengelolaan stok bagi pedagang, dan memberikan transparansi transaksi bagi admin.

Projek ini dibangun menggunakan **Laravel 12** dengan fokus pada antarmuka yang modern (Dark Mode) dan pengalaman pengguna yang responsif.

## 🚀 Fitur Utama
* **Admin Dashboard:** Kelola data pengguna, verifikasi warung, dan pantau total dana.
* **Multi-User Role:** Akses berbeda untuk Admin, Penjual (Warung), dan Pembeli (Siswa/Guru).
* **Modern UI:** Tampilan Dark Mode dengan aksen Oranye yang konsisten.
* **Responsive Design:** Nyaman digunakan baik di perangkat desktop maupun smartphone.
* **Sistem Top-Up:** Pengelolaan saldo digital untuk transaksi non-tunai.

## 🛠️ Tech Stack
* **Framework:** <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" height="25" alt="Laravel">
* **Styling:** <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" height="25" alt="Tailwind">
* **Database:** <img src="https://img.shields.io/badge/Supabase-3ECF8E?style=for-the-badge&logo=supabase&logoColor=white" height="25" alt="Supabase">
* **Deployment:** <img src="https://img.shields.io/badge/Vercel-000000?style=for-the-badge&logo=vercel&logoColor=white" height="25" alt="Vercel">

## 📦 Instalasi
Jika ingin menjalankan projek ini secara lokal:

1. **Clone repository:**
   ```bash
   git clone https://github.com/shofialafarah/smart-canteen.git
2. **Instal dependency PHP:**
   ```bash
   composer install
   npm install
3. **Konfigurasi Environment:**
   * Copy file .env.example menjadi .env.
   * Sesuaikan koneksi database (Supabase/MySQL).
   ```bash
   php artisan key:generate
5. **Migrasi Database**
   ```bash
   php artisan migrate --seed
6. **Jalankan Aplikasi**
   ```bash
   # Terminal 1:
   php artisan serve
   # Terminal 2:
   npm run dev
