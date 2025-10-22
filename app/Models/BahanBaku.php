<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bahan',
        'stok_saat_ini',
        'satuan',
        'stok_minimum',
    ];

    /**
     * Satu Bahan Baku bisa ada di banyak Resep.
     */
    public function reseps(): HasMany
    {
        return $this->hasMany(Resep::class);
    }
}