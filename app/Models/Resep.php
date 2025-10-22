<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resep extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'bahan_baku_id',
        'jumlah_dibutuhkan',
    ];

    /**
     * Satu Resep milik satu Menu.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Satu Resep milik satu BahanBaku.
     */
    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class);
    }
}