<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

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
     * (Logika tetap sama, redirect ke edit)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus',
            'harga' => 'required|numeric|min:0',
        ]);

        $menu = Menu::create($request->all());

        return redirect()->route('menu.edit', $menu->id)
                         ->with('success', 'Menu berhasil ditambahkan. Silakan tambahkan resepnya.');
    }

    /**
     * Menampilkan form untuk mengedit menu DAN resepnya.
     * [PERUBAHAN] Mengirim resep dalam format array sederhana
     */
    public function edit(Menu $menu)
    {
        $bahanBakus = BahanBaku::orderBy('nama_bahan')->get();
        
        // Ambil resep yang sudah ada & format untuk Alpine.js
        $currentRecipe = $menu->reseps()->with('bahanBaku')->get()->map(function ($resep) {
            return [
                'bahan_baku_id' => $resep->bahan_baku_id,
                'nama_bahan' => $resep->bahanBaku->nama_bahan . ' (' . $resep->bahanBaku->satuan . ')', // Tampilkan nama+satuan
                'jumlah_dibutuhkan' => $resep->jumlah_dibutuhkan
            ];
        })->toArray();

        return view('menu.edit', [
            'menu' => $menu,
            'bahanBakus' => $bahanBakus,
            'currentRecipe' => $currentRecipe // Kirim resep terformat
        ]);
    }

    /**
     * [PERUBAHAN TOTAL] Mengupdate data menu DAN resepnya secara bersamaan.
     */
    public function update(Request $request, Menu $menu)
    {
        // 1. Validasi data menu
        $validatedMenu = $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus,nama_menu,'.$menu->id,
            'harga' => 'required|numeric|min:0',
        ]);

        // 2. Validasi data resep (yang sekarang dikirim sebagai array)
        // 'reseps' adalah nama array input yang akan kita buat di view
        $validatedResep = $request->validate([
            'reseps' => 'nullable|array', // Resep boleh kosong
            'reseps.*.bahan_baku_id' => 'required_with:reseps|exists:bahan_bakus,id',
            'reseps.*.jumlah_dibutuhkan' => 'required_with:reseps|numeric|min:0.01',
        ]);

        // 3. Gunakan Database Transaction untuk keamanan
        try {
            DB::beginTransaction();

            // 4. Update detail menu
            $menu->update($validatedMenu);

            // 5. Siapkan data resep untuk di-sync
            $resepsToSync = [];
            if (isset($validatedResep['reseps'])) {
                foreach ($validatedResep['reseps'] as $index => $resepData) {
                    // Pastikan tidak ada duplikat bahan baku dalam satu resep
                    if (isset($resepsToSync[$resepData['bahan_baku_id']])) {
                        // Jika ada duplikat, batalkan dan beri error
                         throw new \Exception("Bahan baku tidak boleh duplikat dalam satu resep.");
                    }
                    // Format data untuk sync: [bahan_baku_id => ['jumlah_dibutuhkan' => ...]]
                    $resepsToSync[$resepData['bahan_baku_id']] = ['jumlah_dibutuhkan' => $resepData['jumlah_dibutuhkan']];
                }
            }

            // 6. Sync resep
            // Sync akan otomatis menambah, mengupdate, atau menghapus resep di tabel pivot
            // berdasarkan data $resepsToSync
            $menu->bahanBakuResep()->sync($resepsToSync); // Pastikan relasi 'bahanBakuResep' ada di model Menu

            // 7. Commit jika semua berhasil
            DB::commit();

            return redirect()->route('menu.edit', $menu->id)
                             ->with('success', 'Menu dan resep berhasil diperbarui.');

        } catch (\Exception $e) {
            // 8. Rollback jika ada error
            DB::rollBack();
            return redirect()->back()
                             ->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()])
                             ->withInput(); // Kembalikan input agar tidak hilang
        }
    }


    /**
     * Menghapus menu dari database.
     * (Logika tetap sama)
     */
    public function destroy(Menu $menu)
    {
        if ($menu->transaksiDetails()->exists()) {
             return redirect()->route('menu.index')
                             ->with('error', 'Menu tidak bisa dihapus karena sudah ada di riwayat transaksi.');
        }

        // Relasi resep akan terhapus otomatis karena sync di update ATAU cascade jika langsung delete
        $menu->delete();
        return redirect()->route('menu.index')
                         ->with('success', 'Menu berhasil dihapus.');
    }

    // [TAMBAHAN] Definisikan relasi Many-to-Many di Model Menu jika belum ada
    // Buka App\Models\Menu.php dan tambahkan method ini:
    public function bahanBakuResep()
    {
        return $this->belongsToMany(BahanBaku::class, 'reseps') // 'reseps' adalah nama tabel pivot
                    ->withPivot('jumlah_dibutuhkan') // Ambil kolom tambahan di pivot
                    ->withTimestamps(); // Jika tabel pivot punya timestamps
    }
}