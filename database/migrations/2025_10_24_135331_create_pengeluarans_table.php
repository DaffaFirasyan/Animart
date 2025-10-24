<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Siapa yang mencatat
            $table->foreignId('bahan_baku_id')->nullable()->constrained('bahan_bakus')->onDelete('set null'); // Bahan apa yg dibeli (opsional, bisa null jika dihapus)
            $table->string('deskripsi'); // Deskripsi pengeluaran (misal: "Beli Ayam 5kg")
            $table->decimal('jumlah_pengeluaran', 12, 2); // Berapa biayanya
            $table->integer('kuantitas')->nullable(); // Jumlah barang yg dibeli (opsional)
            $table->string('satuan')->nullable(); // Satuan barang (opsional)
            $table->timestamp('tanggal_pengeluaran'); // Kapan pengeluaran terjadi
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};