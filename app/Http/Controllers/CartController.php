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
    public function add($id)
    {
        $menu = Menu::with('shop')->findOrFail($id);
        $cart = session()->get('cart', []);

        // Jika menu sudah ada di keranjang, tambah jumlahnya saja
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, tambahkan data baru
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
        return redirect()->back()->with('success', 'Menu berhasil ditambah!');
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
