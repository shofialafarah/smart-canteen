<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'shop_id',
        'category_id',
        'nama_menu',
        'harga',
        'stok',
        'foto_menu',
        'is_available'
    ];
}
