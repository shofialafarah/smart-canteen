<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shop;
use App\Models\TopUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // 4. Halaman Kelola User (Biar nanti gak error lagi pas diklik)
    public function manageUsers(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('role', '!=', 'admin') // Sembunyikan Admin
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
    
    // 5. Verifikasi Warung (Biar gak error juga)
    public function verifyShop()
    {
        $shops = Shop::where('status', 'pending')->get();
        return view('admin.shops.verify', compact('shops'));
    }
}
