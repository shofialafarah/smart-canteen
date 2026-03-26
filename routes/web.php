<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CanteenController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

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
    
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/topup', [AdminController::class, 'topupIndex'])->name('topup.index');
    Route::patch('/topup/{id}/approve', [AdminController::class, 'approveTopUp'])->name('topup.approve');
});

// Halaman Khusus Penjual (Warung)
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');

    Route::get('/seller/orders', [OrderController::class, 'sellerOrders'])->name('seller.orders.index');
    Route::patch('/seller/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('seller.orders.update');
    // Create & Store
    Route::get('/seller/menu/create', [MenuController::class, 'create'])->name('menu.create'); 
    Route::post('/seller/menu/store', [SellerController::class, 'storeMenu'])->name('menu.store');

    // Edit & Update
    Route::get('/seller/menu/{id}/edit', [SellerController::class, 'edit'])->name('menu.edit');
    Route::put('/seller/menu/{id}', [SellerController::class, 'updateMenu'])->name('menu.update'); 

    // Delete
    Route::delete('/seller/menu/{id}', [SellerController::class, 'deleteMenu'])->name('menu.destroy'); 
    Route::get('/seller/orders/update-by-qr/{kode}', [OrderController::class, 'updateByQR'])->name('seller.orders.qr_update');

    Route::patch('/seller/shop/update', [SellerController::class, 'updateShop'])->name('seller.shop.update');
});

// Halaman Khusus Pembeli (Siswa/Guru)
Route::middleware(['auth', 'role:pembeli'])->group(function () {
// Dashboard utama (Daftar Warung)
Route::get('/canteen', [CanteenController::class, 'index'])->name('pembeli.dashboard');

// Detail Warung (Daftar Menu dari warung tersebut)
Route::get('/canteen/shop/{id}', [CanteenController::class, 'showShop'])->name('pembeli.shop.detail');
    // Rute Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update-cart', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    Route::get('/history', [OrderController::class, 'index'])->name('pembeli.history');
});

require __DIR__ . '/auth.php';
