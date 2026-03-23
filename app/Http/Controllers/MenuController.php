<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // Fungsi untuk menampilkan halaman form tambah menu
    public function create()
    {
        return view('seller.menu.create');
    }

    // Fungsi untuk menyimpan data menu ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga'     => 'required|numeric',
            'stok'      => 'required|integer',
            'foto_menu' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Simpan foto jika ada
        $path = null;
        if ($request->hasFile('foto_menu')) {
            $path = $request->file('foto_menu')->store('menu-images', 'public');
        }

        // Simpan ke database
        Menu::create([
            'shop_id'   => Auth::user()->shop->id, 
            'category_id'  => 1,
            'nama_menu' => $request->nama_menu,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'foto_menu' => $path,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Men berhasil ditambahkan!');
    }
}
