<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;

class ResepController extends Controller
{
    /**
     * Menyimpan resep baru (bahan baku) ke sebuah menu.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'jumlah_dibutuhkan' => 'required|numeric|min:0.01',
        ]);

        // Cek apakah bahan baku ini sudah ada di resep menu ini
        $existing = Resep::where('menu_id', $request->menu_id)
                         ->where('bahan_baku_id', $request->bahan_baku_id)
                         ->first();
        
        if ($existing) {
            // Jika sudah ada, update saja jumlahnya
            $existing->update(['jumlah_dibutuhkan' => $request->jumlah_dibutuhkan]);
        } else {
            // Jika belum ada, buat baru
            Resep::create($request->all());
        }

        // Kembali ke halaman edit menu
        return redirect()->route('menu.edit', $request->menu_id)
                         ->with('success', 'Resep berhasil ditambahkan/diperbarui.');
    }

    /**
     * Menghapus sebuah resep (bahan baku) dari sebuah menu.
     */
    public function destroy(Resep $resep)
    {
        $menu_id = $resep->menu_id;
        $resep->delete();

        return redirect()->route('menu.edit', $menu_id)
                         ->with('success', 'Bahan dari resep berhasil dihapus.');
    }
}