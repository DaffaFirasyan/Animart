<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\BahanBaku;
use App\Models\Resep;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasirController extends Controller
{
    /**
     * Menampilkan halaman kasir.
     */
    public function index()
    {
        // Ambil SEMUA menu
        $allMenus = Menu::with('reseps.bahanBaku')->get();

        // Filter menu
        $menus = $allMenus->filter(function ($menu) {
            
            // [PERBAIKAN] Jika menu tidak punya resep, JANGAN TAMPILKAN
            if ($menu->reseps->isEmpty()) {
                return false;
            }

            // Cek setiap bahan di resep
            foreach ($menu->reseps as $resep) {
                // Jika ada 1 saja bahan yang stoknya kurang dari resep, menu tidak bisa dijual
                if ($resep->bahanBaku->stok_saat_ini < $resep->jumlah_dibutuhkan) {
                    return false;
                }
            }
            // Jika semua bahan cukup, menu bisa dijual
            return true;
        });

        return view('kasir.index', compact('menus'));
    }

/**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'cart_data' => 'required|json',
        ]);

        $cart = json_decode($request->cart_data, true);

        if (empty($cart)) {
            return redirect()->route('kasir.index')->with('error', 'Keranjang tidak boleh kosong.');
        }

        // ---------------- [LOGIKA PERBAIKAN DIMULAI] ----------------
        
        $totalHarga = 0;
        $kebutuhanBahan = []; // Array untuk agregasi kebutuhan bahan
        $detailUntukSimpan = [];

        // Loop 1: Agregasi kebutuhan dan validasi awal
        foreach ($cart as $item) {
            $menu = Menu::with('reseps')->findOrFail($item['id']);

            // (Perbaikan No. 7) Cek apakah menu punya resep
            if ($menu->reseps->isEmpty()) {
                throw new \Exception("Menu '{$menu->nama_menu}' tidak memiliki resep dan tidak dapat ditransaksikan.");
            }

            $totalHarga += $item['harga'] * $item['quantity'];

            // Simpan detail untuk nanti
            $detailUntukSimpan[] = [
                'menu_id' => $menu->id,
                'jumlah' => $item['quantity'],
                'harga_saat_transaksi' => $item['harga'],
            ];

            // Agregasi kebutuhan bahan
            foreach ($menu->reseps as $resep) {
                $bahan_id = $resep->bahan_baku_id;
                $total_dibutuhkan = $resep->jumlah_dibutuhkan * $item['quantity'];

                if (!isset($kebutuhanBahan[$bahan_id])) {
                    $kebutuhanBahan[$bahan_id] = 0;
                }
                $kebutuhanBahan[$bahan_id] += $total_dibutuhkan;
            }
        }

        // 3. Mulai Database Transaction
        try {
            DB::beginTransaction();

            // 4. (Sangat Penting) Cek Stok dengan Lock
            // Ambil semua bahan baku yang dibutuhkan dalam satu query dan kunci barisnya
            $bahanBakuDibutuhkan = BahanBaku::whereIn('id', array_keys($kebutuhanBahan))
                                          ->lockForUpdate() // Ini adalah kunci agar tidak ada race condition
                                          ->get()
                                          ->keyBy('id');

            foreach ($kebutuhanBahan as $bahan_id => $total_dibutuhkan) {
                if (!isset($bahanBakuDibutuhkan[$bahan_id])) {
                    throw new \Exception("Bahan baku dengan ID {$bahan_id} tidak ditemukan.");
                }

                $bahan = $bahanBakuDibutuhkan[$bahan_id];

                if ($bahan->stok_saat_ini < $total_dibutuhkan) {
                    throw new \Exception('Stok ' . $bahan->nama_bahan . ' tidak mencukupi. (Dibutuhkan: ' . $total_dibutuhkan . ' ' . $bahan->satuan . ', Tersisa: ' . $bahan->stok_saat_ini . ' ' . $bahan->satuan . ')');
                }
            }

            // 5. Jika semua stok aman, simpan header transaksi
            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'total_harga' => $totalHarga,
            ]);

            // 6. Simpan detail dan kurangi stok
            $transaksi->transaksiDetails()->createMany($detailUntukSimpan);
            
            foreach ($kebutuhanBahan as $bahan_id => $total_dikurangi) {
                // Kita gunakan data yang sudah di-lock
                $bahan = $bahanBakuDibutuhkan[$bahan_id];
                $bahan->decrement('stok_saat_ini', $total_dikurangi);
            }

            // 7. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            // 8. Jika terjadi error, batalkan semua (rollback)
            DB::rollBack();
            Log::error('Error Transaksi: ' . $e->getMessage());
            
            return redirect()->route('kasir.index')->with('error', $e->getMessage());
        }
    }
}