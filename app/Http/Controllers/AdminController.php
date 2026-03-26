<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Dashboard Admin
    public function index()
    {
        $totalSaldo = User::where('role', 'pembeli')->sum('balance');
        $pendingTopUpCount = TopUp::where('status', 'pending')->count();
        $totalWarung = Shop::count();
        $orderHariIni = Order::whereDate('created_at', today())->count();

        return view('admin.dashboard', compact('totalSaldo', 'pendingTopUpCount', 'totalWarung', 'orderHariIni'));
    }

    // 2. Halaman Daftar Permintaan Top Up
    public function topupIndex()
    {
        $pendingTopUps = TopUp::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.topup.index', compact('pendingTopUps'));
    }

    // 3. Proses Approval Top Up
    public function approveTopUp($id)
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

    // 4. Halaman Kelola User (Biar nanti gak error lagi pas diklik)
    public function manageUsers()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // 5. Verifikasi Warung (Biar gak error juga)
    public function verifyShop()
    {
        $shops = Shop::where('status', 'pending')->get();
        return view('admin.shops.verify', compact('shops'));
    }
}