<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'jumlah',
        'harga_saat_transaksi',
    ];

    /**
     * Satu Detail milik satu Transaksi.
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Satu Detail merujuk ke satu Menu.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}