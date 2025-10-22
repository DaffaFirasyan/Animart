<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\BahanBaku;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua menu.
     */
    public function index()
    {
        $menus = Menu::withCount('reseps')->latest()->paginate(10);
        return view('menu.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk membuat menu baru.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Menyimpan menu baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus',
            'harga' => 'required|numeric|min:0',
        ]);

        $menu = Menu::create($request->all());

        // Setelah membuat menu, langsung arahkan ke halaman edit
        // agar pengguna bisa menambahkan resep.
        return redirect()->route('menu.edit', $menu->id)
                         ->with('success', 'Menu berhasil ditambahkan. Silakan tambahkan resepnya.');
    }

    /**
     * Menampilkan form untuk mengedit menu DAN resepnya.
     */
    public function edit(Menu $menu)
    {
        // Ambil semua bahan baku untuk dropdown
        $bahanBakus = BahanBaku::orderBy('nama_bahan')->get();
        
        // Ambil resep yang sudah ada untuk menu ini
        $menu->load('reseps.bahanBaku');

        return view('menu.edit', compact('menu', 'bahanBakus'));
    }

    /**
     * Mengupdate data menu (nama dan harga) di database.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus,nama_menu,'.$menu->id,
            'harga' => 'required|numeric|min:0',
        ]);

        $menu->update($request->all());

        return redirect()->route('menu.edit', $menu->id)
                         ->with('success', 'Detail menu berhasil diperbarui.');
    }

    /**
     * Menghapus menu dari database.
     */
    public function destroy(Menu $menu)
    {
        // Relasi resep akan terhapus otomatis (onDelete('cascade'))
        // Tapi kita perlu cek apakah menu ada di transaksi_details
        if ($menu->transaksiDetails()->exists()) {
             return redirect()->route('menu.index')
                             ->with('error', 'Menu tidak bisa dihapus karena sudah ada di riwayat transaksi.');
        }

        $menu->delete();
        return redirect()->route('menu.index')
                         ->with('success', 'Menu berhasil dihapus.');
    }
}