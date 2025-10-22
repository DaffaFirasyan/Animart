<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_harga',
    ];

    /**
     * Satu Transaksi dimiliki oleh satu User (Pemilik).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu Transaksi memiliki banyak item (Detail).
     */
    public function transaksiDetails(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}