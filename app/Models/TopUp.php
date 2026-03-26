<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nominal',
        'status',
    ];

    /**
     * Relasi ke User (Satu data TopUp dimiliki oleh satu User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}