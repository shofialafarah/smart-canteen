<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('pembeli.cart', compact('cart'));
    }

    // Menambah menu ke keranjang
    public function add(Request $request, $id) // Tambahkan Request $request
    {
        $menu = Menu::with('shop')->findOrFail($id);
        $cart = session()->get('cart', []);
        $shop = $menu->shop;

        // Paksa ambil waktu WITA agar sinkron dengan jam buka warung
        $sekarang = \Carbon\Carbon::now('Asia/Makassar')->format('H:i');

        // Cek apakah warung buka
        if ($sekarang < $shop->jam_buka || $sekarang > $shop->jam_tutup) {
            return redirect()->back()->with('error', 'Waduh! Warung ini sudah tutup, nggak bisa jajan dulu ya.');
        }

        // Pengecekan stok (Tambahan agar lebih aman)
        if ($menu->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok menu ini sudah habis!');
        }

        // Logika tambah ke keranjang
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $menu->nama_menu,
                "quantity" => 1,
                "price" => $menu->harga,
                "photo" => $menu->foto_menu,
                "shop" => $menu->shop->nama_warung,
                "shop_id" => $menu->shop->id
            ];
        }

        session()->put('cart', $cart);

        // Gunakan session()->flash untuk memastikan notifikasi muncul
        return redirect()->back()->with('success', 'Nyam! ' . $menu->nama_menu . ' berhasil ditambah ke keranjang.');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Keranjang berhasil diperbarui!');
        }
    }
    // Menghapus satu item
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Item dihapus');
        }
    }
}
