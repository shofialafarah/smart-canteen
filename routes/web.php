<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CanteenController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Halaman Khusus Admin Sekolah
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/verifikasi-warung', [AdminController::class, 'verifyShop']);
});

// Halaman Khusus Penjual (Warung)
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    Route::get('/seller/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/seller/menu/store', [MenuController::class, 'store'])->name('menu.store');
});

// Halaman Khusus Pembeli (Siswa/Guru)
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/canteen', [CanteenController::class, 'index'])->name('pembeli.dashboard');
    Route::post('/checkout', [OrderController::class, 'store']);
});

require __DIR__ . '/auth.php';
