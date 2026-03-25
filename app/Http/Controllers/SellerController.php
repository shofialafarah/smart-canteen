<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index()
    {
        // Ambil data warung milik user
        $shop = Auth::user()->shop;

        // Jika belum punya warung, arahkan ke halaman buat warung atau dashboard dengan pesan
        if (!$shop) {
            return view('seller.dashboard', ['menus' => collect()]);
        }

        $menus = Menu::where('shop_id', $shop->id)->get();

        return view('seller.dashboard', compact('menus'));
    }

    // 1. Simpan Data Warung (Pertama kali daftar)
    public function storeShop(Request $request)
    {
        $request->validate([
            'nama_warung' => 'required|string|max:255',
            'foto_warung' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('foto_warung')->store('shops', 'public');

        Shop::create([
            'user_id' => Auth::id(),
            'nama_warung' => $request->nama_warung,
            'foto_warung' => $path,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Warung berhasil didaftarkan!');
    }

    public function updateShop(Request $request)
    {
        $request->validate([
            'nama_warung' => 'required|string|max:255',
            'jam_buka' => 'required',
        'jam_tutup' => 'required',
            'foto_warung' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $shop = Auth::user()->shop;
        $shop->nama_warung = $request->nama_warung;
        $shop->jam_buka = $request->jam_buka;
    $shop->jam_tutup = $request->jam_tutup;

        if ($request->hasFile('foto_warung')) {
            // Hapus foto lama jika ada
            if ($shop->foto_warung) {
                Storage::delete('public/' . $shop->foto_warung);
            }
            $path = $request->file('foto_warung')->store('shops', 'public');
            $shop->foto_warung = $path;
        }

        $shop->save();

        return back()->with('success', 'Informasi warung berhasil diperbarui!');
    }

    // 2. Simpan Menu Jajanan
    public function storeMenu(Request $request)
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return back()->with('error', 'Kamu harus mendaftarkan warung dulu sebelum tambah menu!');
        }

        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto_menu' => 'required|image|max:2048',
        ]);

        $shop = Auth::user()->shop; // Mengambil warung milik user yang login
        $path = $request->file('foto_menu')->store('menus', 'public');

        Menu::create([
            'shop_id' => $shop->id,
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto_menu' => $path,
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    // 1. Tampilkan Halaman Edit
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        // Keamanan: Cek apakah menu ini benar milik warung si penjual
        if ($menu->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Kamu tidak punya akses ke menu ini.');
        }

        return view('seller.menu.edit', compact('menu'));
    }

    // 2. Proses Update Data
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        // Proteksi akses
        if ($menu->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto_menu' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_menu', 'harga', 'stok']);

        // Jika ada upload foto baru
        if ($request->hasFile('foto_menu')) {
            // Hapus foto lama dari storage agar tidak penuh
            if ($menu->foto_menu) {
                Storage::disk('public')->delete($menu->foto_menu);
            }
            $data['foto_menu'] = $request->file('foto_menu')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Menu berhasil diperbarui!');
    }

    // 3. Proses Hapus Menu
    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        // Hapus file foto dari folder storage
        if ($menu->foto_menu) {
            Storage::disk('public')->delete($menu->foto_menu);
        }

        $menu->delete();

        return back()->with('success', 'Menu telah dihapus dari daftar.');
    }
}
