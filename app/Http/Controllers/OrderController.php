<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
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

        $firstItem = reset($cart);
        $shopId = $firstItem['shop_id'] ?? 1;
        $shop = \App\Models\Shop::find($shopId);

        if ($shop) {
            $sekarang = \Carbon\Carbon::now('Asia/Makassar')->format('H:i');
            $jamBuka = \Carbon\Carbon::parse($shop->jam_buka)->format('H:i');
            $jamTutup = \Carbon\Carbon::parse($shop->jam_tutup)->format('H:i');

            if ($sekarang < $jamBuka || $sekarang > $jamTutup) {
                return redirect()->back()->with('error', "Maaf, {$shop->nama_warung} sudah tutup. Jam operasional: {$jamBuka} - {$jamTutup}. (Waktu sistem: {$sekarang})");
            }
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $user = User::find(Auth::id());
        $metode = $request->input('metode_pembayaran');

        // Validasi Saldo
        if ($metode === 'cashless' && $user->balance < $total) {
            return redirect()->back()->with('error', 'Saldo E-Wallet tidak cukup!');
        }

        try {
            DB::transaction(function () use ($cart, $total, $user, $metode) {
                if ($metode === 'cashless') {
                    $user->decrement('balance', $total);
                }

                // Simpan Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_harga' => $total,
                    'metode_pembayaran' => $metode,
                    // Status otomatis paid jika cashless, unpaid jika tunai
                    'status_pembayaran' => ($metode === 'cashless' ? 'paid' : 'unpaid'),
                    'status_pesanan' => 'pending',
                    'kode_ambil' => strtoupper(\Illuminate\Support\Str::random(6))
                ]);

                foreach ($cart as $id => $details) {
                    OrderDetail::create([
                        'order_id' => $order->id, // Gunakan $order->id yang baru dibuat
                        'menu_id'  => $id,
                        'shop_id'  => $details['shop_id'] ?? 1,
                        'quantity' => $details['quantity'],
                        'subtotal' => $details['price'] * $details['quantity']
                    ]);

                    Menu::where('id', $id)->decrement('stok', $details['quantity']);
                }

                session()->forget('cart');
            });

            return redirect()->route('pembeli.dashboard')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function sellerOrders()
    {
        $shop = Auth::user()->shop;

        $orders = \App\Models\Order::whereHas('details', function ($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })->with(['user', 'details.menu'])->latest()->get();

        return view('seller.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status_pesanan == 'pending') {
            $order->status_pesanan = 'diproses';
        } elseif ($order->status_pesanan == 'diproses') {
            $order->status_pesanan = 'siap_diambil';
        } elseif ($order->status_pesanan == 'siap_diambil') {
            $order->status_pesanan = 'selesai';
        }

        $order->save();
        return back()->with('success', 'Status pesanan: ' . strtoupper($order->status_pesanan));
    }

    public function updateByQR($kode)
    {
        $order = Order::where('kode_ambil', $kode)->firstOrFail();

        if ($order->status_pesanan == 'siap_diambil') {
            $order->status_pembayaran = 'paid';

            $order->status_pesanan = 'selesai';
            $order->save();

            return redirect()->route('seller.orders.index')->with('success', 'Pesanan Berhasil Diambil!');
        }

        return redirect()->route('seller.orders.index')->with('error', 'Status pesanan tidak sesuai.');
    }
}
