<?php

namespace App\Http\Controllers;

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

    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $user = User::find(Auth::id());

    $metode = $request->input('metode_pembayaran');

    if ($metode === 'cashless' && $user->balance < $total) {
        return redirect()->back()->with('error', 'Saldo E-Wallet tidak cukup!');
    }

    try {
        DB::transaction(function () use ($cart, $total, $user, $metode) {
            
            // 1. Kurangi Saldo HANYA jika bayar pakai E-Wallet (cashless)
            if ($metode === 'cashless') {
                $user->decrement('balance', $total);
            }

            // 2. Buat Data Order Utama
            Order::create([
                'user_id' => $user->id,
                'total_harga' => $total,
                'metode_pembayaran' => $metode, 
                'status_pembayaran' => ($metode === 'cashless' ? 'paid' : 'unpaid'), 
                'status_pesanan' => 'pending',
                'kode_ambil' => strtoupper(\Illuminate\Support\Str::random(6))
            ]);

            foreach ($cart as $id => $details) {
                OrderDetail::create([
                    'order_id' => DB::getPdo()->lastInsertId(),
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
        $order->status_pesanan = 'selesai';
        $order->save();
        return redirect()->route('seller.orders.index')->with('success', 'Pesanan ' . $kode . ' BERHASIL DIAMBIL!');
    }

    return redirect()->route('seller.orders.index')->with('error', 'Status pesanan tidak sesuai.');
}
}
