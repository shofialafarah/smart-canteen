<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; 
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data menu yang hanya dimiliki oleh warung user ini
        $menus = \App\Models\Menu::where('shop_id', $user->shop->id)->get();

        return view('seller.dashboard', compact('menus'));
    }
}
