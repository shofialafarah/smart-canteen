<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    // --- KHUSUS PEMBELI ---

    // 1. Fungsi khusus menampilkan FORM TOPUP (Tampilan input nominal)
    public function create()
    {
        return view('pembeli.topup'); // Pastikan nama file blade-nya benar
    }

    // 2. Fungsi khusus menampilkan RIWAYAT (Jajan & Topup)
    public function index()
    {
        $orders = \App\Models\Order::where('user_id', Auth::id())->latest()->get();
        $topups = \App\Models\TopUp::where('user_id', Auth::id())->latest()->get();

        return view('pembeli.history', compact('orders', 'topups'));
    }

    // Proses simpan request top up dari pembeli
    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
        ]);

        TopUp::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'status' => 'pending',
        ]);

        return redirect()->route('pembeli.dashboard')->with('success', 'Permintaan top up berhasil dikirim!');
    }


    // --- KHUSUS ADMIN ---

    // Tampilkan daftar permintaan (Pindahan dari AdminController)
    public function adminIndex()
    {
        $pendingTopUps = TopUp::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.topup.index', compact('pendingTopUps'));
    }

    // Proses konfirmasi saldo (Pindahan dari AdminController)
    public function approve($id)
    {
        $topup = TopUp::findOrFail($id);

        if ($topup->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        DB::transaction(function () use ($topup) {
            $topup->user->increment('balance', $topup->nominal);
            $topup->update(['status' => 'success']);
        });

        return back()->with('success', 'Saldo berhasil ditambahkan!');
    }
}
