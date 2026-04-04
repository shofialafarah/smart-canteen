<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Form Tambah Menu
    public function create()
    {
        $categories = Category::all();
        return view('seller.menu.create', compact('categories'));
    }

    // Proses Simpan Menu Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga'     => 'required|numeric',
            'stok'      => 'required|integer',
            'foto_menu' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $path = $request->file('foto_menu')->store('menus', 'supabase');

        Menu::create([
            'shop_id'   => Auth::user()->shop->id,
            'category_id' => $request->category_id,
            'nama_menu' => $request->nama_menu,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'foto_menu' => $path,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Form Edit Menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();

        if ($menu->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('seller.menu.edit', compact('menu', 'categories'));
    }

    // Proses Update Menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto_menu' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_menu', 'category_id', 'harga', 'stok']);

        if ($request->hasFile('foto_menu')) {
            if ($menu->foto_menu) {
                Storage::disk('supabase')->delete($menu->foto_menu);
            }
            $data['foto_menu'] = $request->file('foto_menu')->store('menus', 'supabase');
        }

        $menu->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Menu berhasil diperbarui!');
    }

    // Proses Hapus Menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->shop_id !== Auth::user()->shop->id) {
            abort(403);
        }

        if ($menu->foto_menu) {
            Storage::disk('supabase')->delete($menu->foto_menu);
        }

        $menu->delete();

        return back()->with('success', 'Menu telah dihapus.');
    }
}
