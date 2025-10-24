<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bahan_baku_id',
        'deskripsi',
        'jumlah_pengeluaran',
        'kuantitas',
        'satuan',
        'tanggal_pengeluaran',
    ];

    // Tentukan tipe data untuk kolom tanggal
    protected $casts = [
        'tanggal_pengeluaran' => 'datetime',
        'jumlah_pengeluaran' => 'decimal:2',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Bahan Baku (bisa null)
    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class);
    }
}