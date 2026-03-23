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
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pembeli.history', compact('orders'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang belanja kamu masih kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $user = User::find(Auth::id());

        if ($user->balance < $total) {
            return redirect()->back()->with('error', 'Saldo tidak cukup untuk melakukan pembayaran!');
        }

        try {
            DB::transaction(function () use ($cart, $total, $user) {
                // 1. Kurangi Saldo Pembeli
                $user->decrement('balance', $total);

                // 2. Buat Data Order Utama (Sesuaikan dengan kolom database kamu)
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_harga' => $total, 
                    'status_pembayaran' => 'paid',
                    'kode_ambil' => strtoupper(\Illuminate\Support\Str::random(6)) 
                ]);

                // 3. Masukkan Detail & Kurangi Stok Menu
                foreach ($cart as $id => $details) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'menu_id'  => $id,
                        'shop_id'  => $details['shop_id'] ?? 1,
                        'quantity' => $details['quantity'],
                        'subtotal' => $details['price'] * $details['quantity'] // Di database kamu 'subtotal'
                    ]);

                    // Mengurangi stok menu
                    Menu::where('id', $id)->decrement('stok', $details['quantity']);
                }

                // 4. Kosongkan Keranjang
                session()->forget('cart');
            });

            // Pastikan route ini ada di web.php kamu
            return redirect()->route('pembeli.dashboard')->with('success', 'Pembayaran Berhasil! Silakan cek riwayat pesanan.');
        } catch (\Exception $e) {
            // Jika ada kolom yang salah, errornya akan muncul di pop-up merah
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
