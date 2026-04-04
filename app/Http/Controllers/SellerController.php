<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // Ambil data warung milik user
    public function index()
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return view('seller.dashboard', ['menus' => collect()]);
        }

        $menus = Menu::with('category')->where('shop_id', $shop->id)->get();

        return view('seller.dashboard', compact('menus'));
    }

    // 1. Simpan Data Warung (Pertama kali daftar)
    public function storeShop(Request $request)
    {
        $request->validate([
            'nama_warung' => 'required|string|max:255',
            'foto_warung' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('foto_warung')->store('shops', 'supabase');

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
            $path = $request->file('foto_warung')->store('shops', 'supabase');
            $shop->foto_warung = $path;
        }

        $shop->save();

        return back()->with('success', 'Informasi warung berhasil diperbarui!');
    }
}
