<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanteenController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika dia Penjual
        if ($user->role === 'penjual') {
            // Cek apakah dia sudah punya warung?
            $shop = \App\Models\Shop::where('user_id', $user->id)->first();

            // Kalau belum punya warung, lempar ke form buat warung
            if (!$shop) {
                return view('seller.shop.create');
            }

            // Kalau sudah punya, tampilkan dashboard seller & daftar menu miliknya
            $menus = \App\Models\Menu::where('shop_id', $shop->id)->get();
            return view('seller.dashboard', compact('shop', 'menus'));
        }

        // Jika dia Pembeli (Default)
        $shops = \App\Models\Shop::all();
        return view('pembeli.dashboard', compact('shops'));
    }

    // CanteenController.php
    public function showShop($id)
    {
        // Cari warungnya
        $shop = Shop::findOrFail($id);

        // Ambil menu yang hanya milik warung tersebut
        $menus = Menu::where('shop_id', $id)->get();

        return view('pembeli.shop-detail', compact('shop', 'menus'));
    }
}
