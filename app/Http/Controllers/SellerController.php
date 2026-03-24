<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
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

    // 2. Simpan Menu Jajanan
    public function storeMenu(Request $request)
    {
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
    public function update(Request $request, $id)
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

        return redirect()->route('dashboard')->with('success', 'Menu berhasil diperbarui!');
    }

    // 3. Proses Hapus Menu
    public function destroy($id)
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
