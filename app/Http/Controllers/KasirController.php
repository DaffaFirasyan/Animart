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
        // Kita hanya mengambil menu yang bisa dibuat (stok bahan bakunya cukup)
        $menus = Menu::with('reseps.bahanBaku')->get()->filter(function ($menu) {
            // Jika menu tidak punya resep, anggap bisa dijual
            if ($menu->reseps->isEmpty()) {
                return true;
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

        // 2. Decode data JSON dari keranjang
        $cart = json_decode($request->cart_data, true);

        // Jangan proses jika keranjang kosong
        if (empty($cart)) {
            return redirect()->route('kasir.index')->with('error', 'Keranjang tidak boleh kosong.');
        }

        // 3. Mulai Database Transaction
        // Ini memastikan jika ada satu saja kegagalan (misal stok tidak cukup),
        // semua proses akan dibatalkan (rollback) dan data tetap aman.
        try {
            DB::beginTransaction();

            $totalHarga = 0;

            // 4. (Sangat Penting) Cek Stok terlebih dahulu sebelum menyimpan apapun
            foreach ($cart as $item) {
                $menu = Menu::with('reseps.bahanBaku')->findOrFail($item['id']);
                $totalHarga += $item['harga'] * $item['quantity'];

                foreach ($menu->reseps as $resep) {
                    $total_dibutuhkan = $resep->jumlah_dibutuhkan * $item['quantity'];
                    
                    if ($resep->bahanBaku->stok_saat_ini < $total_dibutuhkan) {
                        // Jika stok kurang, batalkan semua
                        throw new \Exception('Stok ' . $resep->bahanBaku->nama_bahan . ' tidak mencukupi untuk ' . $item['quantity'] . ' porsi ' . $menu->nama_menu . '.');
                    }
                }
            }

            // 5. Jika semua stok aman, simpan header transaksi
            $transaksi = Transaksi::create([
                'user_id' => auth()->id(), // User yang sedang login
                'total_harga' => $totalHarga,
            ]);

            // 6. Loop keranjang lagi untuk menyimpan detail dan mengurangi stok
            foreach ($cart as $item) {
                $menu = Menu::findOrFail($item['id']); // Cukup find, resep sudah dicek tadi

                // Simpan ke transaksi_details
                $transaksi->transaksiDetails()->create([
                    'menu_id' => $menu->id,
                    'jumlah' => $item['quantity'],
                    'harga_saat_transaksi' => $item['harga'],
                ]);

                // Kurangi stok bahan baku
                foreach ($menu->reseps as $resep) {
                    $total_dikurangi = $resep->jumlah_dibutuhkan * $item['quantity'];
                    
                    // Gunakan decrement untuk keamanan
                    $resep->bahanBaku->decrement('stok_saat_ini', $total_dikurangi);
                }
            }

            // 7. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            // 8. Jika terjadi error, batalkan semua (rollback)
            DB::rollBack();
            Log::error('Error Transaksi: ' . $e->getMessage()); // Catat error untuk developer
            
            // Kirim pesan error kembali ke halaman kasir
            return redirect()->route('kasir.index')->with('error', $e->getMessage());
        }
    }
}