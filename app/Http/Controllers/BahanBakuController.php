<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

/**
     * Menampilkan form untuk menambah stok.
     */
    public function showTambahStokForm(BahanBaku $bahanBaku)
    {
        return view('bahan_baku.tambah-stok', compact('bahanBaku'));
    }

    /**
     * [PERUBAHAN] Menyimpan penambahan stok DAN mencatat pengeluaran.
     */
    public function storeTambahStok(Request $request)
    {
        // 1. Validasi input (termasuk input baru)
        $validated = $request->validate([
            'bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'jumlah_tambah' => 'required|numeric|min:0.01',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_beli' => 'required|date',
        ]);

        // Gunakan transaction untuk memastikan keduanya berhasil atau gagal bersama
        DB::beginTransaction();
        try {
            // 2. Cari bahan baku
            $bahanBaku = BahanBaku::findOrFail($validated['bahan_baku_id']);

            // 3. Tambah stok
            $bahanBaku->increment('stok_saat_ini', $validated['jumlah_tambah']);

            // 4. Buat deskripsi pengeluaran otomatis
            $deskripsi = 'Pembelian ' . $bahanBaku->nama_bahan . ' (' . $validated['jumlah_tambah'] . ' ' . $bahanBaku->satuan . ')';

            // 5. Catat pengeluaran
            Pengeluaran::create([
                'user_id' => Auth::id(), // ID user yang login
                'bahan_baku_id' => $bahanBaku->id,
                'deskripsi' => $deskripsi,
                'jumlah_pengeluaran' => $validated['harga_beli'],
                'kuantitas' => $validated['jumlah_tambah'],
                'satuan' => $bahanBaku->satuan,
                // Pastikan tanggal disimpan dengan waktu (misal awal hari)
                'tanggal_pengeluaran' => Carbon::parse($validated['tanggal_beli'])->startOfDay(),
            ]);

            // 6. Commit transaction
            DB::commit();

            // 7. Redirect dengan pesan sukses
            return redirect()->route('bahan-baku.index')
                            ->with('success', 'Stok ' . $bahanBaku->nama_bahan . ' berhasil ditambahkan & pengeluaran dicatat.');

        } catch (\Exception $e) {
            // 8. Rollback jika ada error
            DB::rollBack();
            Log::error('Error Tambah Stok & Pengeluaran: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                             ->withInput();
        }
    }
}