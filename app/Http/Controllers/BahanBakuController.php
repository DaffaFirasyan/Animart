<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    /**
     * Menampilkan daftar semua bahan baku.
     */
    public function index()
    {
        $bahanBakus = BahanBaku::latest()->paginate(10);
        return view('bahan_baku.index', compact('bahanBakus'));
    }

    /**
     * Menampilkan form untuk membuat bahan baku baru.
     */
    public function create()
    {
        return view('bahan_baku.create');
    }

    /**
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_bahan' => 'required|string|max:255|unique:bahan_bakus',
            'stok_saat_ini' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'required|numeric|min:0',
        ]);

        // Buat data baru
        BahanBaku::create($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('bahan-baku.index')
                         ->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit bahan baku.
     */
    public function edit(BahanBaku $bahanBaku)
    {
        return view('bahan_baku.edit', compact('bahanBaku'));
    }

    /**
     * Mengupdate data bahan baku di database.
     */
    public function update(Request $request, BahanBaku $bahanBaku)
    {
        // Validasi input
        $request->validate([
            'nama_bahan' => 'required|string|max:255|unique:bahan_bakus,nama_bahan,'.$bahanBaku->id,
            'stok_saat_ini' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'stok_minimum' => 'required|numeric|min:0',
        ]);

        // Update data
        $bahanBaku->update($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('bahan-baku.index')
                         ->with('success', 'Bahan Baku berhasil diperbarui.');
    }

    /**
     * Menghapus bahan baku dari database.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        try {
            // Coba hapus
            $bahanBaku->delete();
            return redirect()->route('bahan-baku.index')
                             ->with('success', 'Bahan Baku berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error jika ada relasi (misal, bahan baku masih dipakai di resep)
            return redirect()->route('bahan-baku.index')
                             ->with('error', 'Bahan Baku tidak bisa dihapus karena masih digunakan di resep.');
        }
    }

    public function showTambahStokForm(BahanBaku $bahanBaku)
    {
        return view('bahan_baku.tambah-stok', compact('bahanBaku'));
    }

    public function storeTambahStok(Request $request)
    {
        // Validasi
        $request->validate([
            'bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'jumlah_tambah' => 'required|numeric|min:0.01',
        ]);

        // Cari bahan baku
        $bahanBaku = BahanBaku::findOrFail($request->bahan_baku_id);

        // Tambah stok menggunakan 'increment' (aman dari race condition)
        $bahanBaku->increment('stok_saat_ini', $request->jumlah_tambah);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('bahan-baku.index')
                         ->with('success', 'Stok ' . $bahanBaku->nama_bahan . ' berhasil ditambahkan.');
    }
}