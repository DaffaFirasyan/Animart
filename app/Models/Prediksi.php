<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prediksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'tanggal_prediksi',
        'jumlah_prediksi',
    ];

    /**
     * Satu data Prediksi milik satu Menu.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}