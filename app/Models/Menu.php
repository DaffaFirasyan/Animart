<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_menu',
        'harga',
    ];

    /**
     * Satu Menu memiliki banyak Resep (bahan baku).
     */
    public function reseps(): HasMany
    {
        return $this->hasMany(Resep::class);
    }

    /**
     * Satu Menu bisa ada di banyak Transaksi Detail.
     */
    public function transaksiDetails(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
    
    /**
     * Satu Menu memiliki banyak data Prediksi.
     */
    public function prediksis(): HasMany
    {
        return $this->hasMany(Prediksi::class);
    }
}