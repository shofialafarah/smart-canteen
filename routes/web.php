<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CanteenController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\TopUpController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/debug-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return "Migration Berhasil!";
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [CanteenController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Halaman Khusus Admin Sekolah
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/verifikasi-warung', [AdminController::class, 'verifyShop'])->name('verify-shop');

    Route::post('/users', [ProfileController::class, 'store'])->name('users.store'); 
    Route::put('/users/update/{id}', [ProfileController::class, 'updateUser'])->name('users.update');
    
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    // ------------------------------

    Route::get('/topup', [TopUpController::class, 'adminIndex'])->name('topup.index');
    Route::patch('/topup/{id}/approve', [TopUpController::class, 'approve'])->name('topup.approve');
});

// Halaman Khusus Penjual (Warung)
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    Route::patch('/seller/shop/update', [SellerController::class, 'updateShop'])->name('seller.shop.update');
    Route::post('/seller/shop/store', [SellerController::class, 'storeShop'])->name('seller.shop.store');

    // Pesanan & QR
    Route::get('/seller/orders', [OrderController::class, 'sellerOrders'])->name('seller.orders.index');
    Route::patch('/seller/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('seller.orders.update');
    Route::get('/seller/orders/update-by-qr/{kode}', [OrderController::class, 'updateByQR'])->name('seller.orders.qr_update');

    // Rute Menu (Sekarang Menggunakan MenuController)
    Route::prefix('seller/menu')->name('menu.')->group(function () {
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/store', [MenuController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{id}', [MenuController::class, 'destroy'])->name('destroy');
    });
});

// Halaman Khusus Pembeli (Siswa/Guru)
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    // Dashboard utama (Daftar Warung)
    Route::get('/canteen', [CanteenController::class, 'index'])->name('pembeli.dashboard');

    // Detail Warung (Daftar Menu dari warung tersebut)
    Route::get('/canteen/shop/{id}', [CanteenController::class, 'showShop'])->name('pembeli.shop.detail');
    // Rute Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update-cart', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/order-store', [OrderController::class, 'store'])->name('order.store');

    Route::get('/history', [TopUpController::class, 'index'])->name('pembeli.history');

    Route::get('/topup', [TopUpController::class, 'create'])->name('pembeli.topup');
    Route::post('/topup', [TopUpController::class, 'store'])->name('pembeli.topup.store');
});

require __DIR__ . '/auth.php';
