<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CanteenController extends Controller
{
    public function index()
    {
        // Gunakan with('shop') agar data warungnya ikut terbawa
        $menus = \App\Models\Menu::with('shop')->get();

        return view('pembeli.dashboard', compact('menus'));
    }
}
