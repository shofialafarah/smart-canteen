<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $fillable = [
        'user_id',
        'nominal',
        'status_topup',
        'bukti_transfer'
    ];
}
