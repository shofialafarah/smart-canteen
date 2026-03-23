<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang belanja kamu masih kosong!');
        }

        $total = 0;
        foreach($cart as $item) { 
            $total += $item['price'] * $item['quantity']; 
        }

        // Ambil data user yang sedang login sebagai Model User agar bisa pakai decrement
        $user = User::find(Auth::id());

        // Cek apakah saldo cukup
        if ($user->balance < $total) {
            return redirect()->back()->with('error', 'Saldo tidak cukup untuk melakukan pembayaran!');
        }

        try {
            DB::transaction(function () use ($cart, $total, $user) {
                // 1. Kurangi Saldo Pembeli
                $user->decrement('balance', $total);

                // 2. Buat Data Order Utama
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $total,
                    'status' => 'pending'
                ]);

                // 3. Masukkan Detail & Kurangi Stok Menu
                foreach ($cart as $id => $details) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'menu_id' => $id,
                        'quantity' => $details['quantity'],
                        'price' => $details['price']
                    ]);

                    // Mengurangi stok menu
                    Menu::where('id', $id)->decrement('stok', $details['quantity']);
                }

                // 4. Kosongkan Keranjang
                session()->forget('cart');
            });

            return redirect()->route('pembeli.dashboard')->with('success', 'Pesanan berhasil dibuat! Silakan ambil di kantin.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}