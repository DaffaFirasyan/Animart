<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\Prediksi;
use App\Models\Resep;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class FunctionalTestSeeder extends Seeder
{
    /**
     * Seeder untuk testing fungsional semua fitur:
     * - Bahan Baku (CRUD + Tambah Stok)
     * - Menu (CRUD)
     * - Resep
     * - Kasir (Transaksi)
     * - Dashboard
     * - Laporan
     */
    public function run(): void
    {
        // Hapus data lama
        $this->command->info('Menghapus data lama...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        TransaksiDetail::truncate();
        Transaksi::truncate();
        if (class_exists(Prediksi::class)) {
            Prediksi::truncate();
        }
        Resep::truncate();
        Menu::truncate();
        BahanBaku::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Data lama berhasil dihapus.');

        DB::transaction(function () {

            // =====================================================
            // 1. BUAT USER ADMIN
            // =====================================================
            $admin = User::create([
                'name' => 'Admin Animart',
                'email' => 'admin@animart.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
            $this->command->info('Admin berhasil dibuat (email: admin@animart.com, pass: password)');

            // =====================================================
            // 2. BUAT BAHAN BAKU (Variasi lengkap untuk testing)
            // =====================================================
            $this->command->info('Membuat data bahan baku...');

            // Protein
            $ayam = BahanBaku::create([
                'nama_bahan' => 'Daging Ayam',
                'stok_saat_ini' => 10000,
                'satuan' => 'gram',
                'stok_minimum' => 2000,
            ]);

            $sapi = BahanBaku::create([
                'nama_bahan' => 'Daging Sapi',
                'stok_saat_ini' => 8000,
                'satuan' => 'gram',
                'stok_minimum' => 1500,
            ]);

            $udang = BahanBaku::create([
                'nama_bahan' => 'Udang',
                'stok_saat_ini' => 5000,
                'satuan' => 'gram',
                'stok_minimum' => 1000,
            ]);

            $telur = BahanBaku::create([
                'nama_bahan' => 'Telur Ayam',
                'stok_saat_ini' => 200,
                'satuan' => 'butir',
                'stok_minimum' => 50,
            ]);

            // Karbohidrat
            $beras = BahanBaku::create([
                'nama_bahan' => 'Beras Putih',
                'stok_saat_ini' => 20000,
                'satuan' => 'gram',
                'stok_minimum' => 5000,
            ]);

            $mie = BahanBaku::create([
                'nama_bahan' => 'Mie Instan',
                'stok_saat_ini' => 100,
                'satuan' => 'bungkus',
                'stok_minimum' => 30,
            ]);

            // Sayuran
            $wortel = BahanBaku::create([
                'nama_bahan' => 'Wortel',
                'stok_saat_ini' => 3000,
                'satuan' => 'gram',
                'stok_minimum' => 500,
            ]);

            $brokoli = BahanBaku::create([
                'nama_bahan' => 'Brokoli',
                'stok_saat_ini' => 2000,
                'satuan' => 'gram',
                'stok_minimum' => 400,
            ]);

            $kubis = BahanBaku::create([
                'nama_bahan' => 'Kubis',
                'stok_saat_ini' => 3000,
                'satuan' => 'gram',
                'stok_minimum' => 500,
            ]);

            // Saus & Bumbu
            $sausTeriyaki = BahanBaku::create([
                'nama_bahan' => 'Saus Teriyaki',
                'stok_saat_ini' => 5000,
                'satuan' => 'ml',
                'stok_minimum' => 1000,
            ]);

            $sausBlackpepper = BahanBaku::create([
                'nama_bahan' => 'Saus Blackpepper',
                'stok_saat_ini' => 4000,
                'satuan' => 'ml',
                'stok_minimum' => 800,
            ]);

            $kecapManis = BahanBaku::create([
                'nama_bahan' => 'Kecap Manis',
                'stok_saat_ini' => 3000,
                'satuan' => 'ml',
                'stok_minimum' => 600,
            ]);

            $minyakGoreng = BahanBaku::create([
                'nama_bahan' => 'Minyak Goreng',
                'stok_saat_ini' => 10000,
                'satuan' => 'ml',
                'stok_minimum' => 2000,
            ]);

            // Pelengkap
            $wijen = BahanBaku::create([
                'nama_bahan' => 'Biji Wijen',
                'stok_saat_ini' => 1000,
                'satuan' => 'gram',
                'stok_minimum' => 200,
            ]);

            $daun_bawang = BahanBaku::create([
                'nama_bahan' => 'Daun Bawang',
                'stok_saat_ini' => 500,
                'satuan' => 'gram',
                'stok_minimum' => 100,
            ]);

            $this->command->info('15 bahan baku berhasil dibuat.');

            // =====================================================
            // 3. BUAT MENU (Variasi lengkap)
            // =====================================================
            $this->command->info('Membuat data menu...');

            // Menu Ricebowl
            $menuAyamTeriyaki = Menu::create([
                'nama_menu' => 'Ricebowl Ayam Teriyaki',
                'harga' => 18000,
            ]);

            $menuAyamBlackpepper = Menu::create([
                'nama_menu' => 'Ricebowl Ayam Blackpepper',
                'harga' => 18000,
            ]);

            $menuSapiTeriyaki = Menu::create([
                'nama_menu' => 'Ricebowl Sapi Teriyaki',
                'harga' => 22000,
            ]);

            $menuSapiBlackpepper = Menu::create([
                'nama_menu' => 'Ricebowl Sapi Blackpepper',
                'harga' => 22000,
            ]);

            $menuUdangTeriyaki = Menu::create([
                'nama_menu' => 'Ricebowl Udang Teriyaki',
                'harga' => 25000,
            ]);

            // Menu Spesial
            $menuKombo = Menu::create([
                'nama_menu' => 'Ricebowl Kombo (Ayam + Sapi)',
                'harga' => 28000,
            ]);

            $menuVegetarian = Menu::create([
                'nama_menu' => 'Ricebowl Vegetarian',
                'harga' => 15000,
            ]);

            // Menu Tambahan
            $menuTelurMataapi = Menu::create([
                'nama_menu' => 'Telur Mata Sapi',
                'harga' => 5000,
            ]);

            $menuMieGoreng = Menu::create([
                'nama_menu' => 'Mie Goreng Spesial',
                'harga' => 12000,
            ]);

            $this->command->info('9 menu berhasil dibuat.');

            // =====================================================
            // 4. BUAT RESEP (Relasi Menu-Bahan Baku)
            // =====================================================
            $this->command->info('Membuat data resep...');

            // Resep Ayam Teriyaki
            Resep::create(['menu_id' => $menuAyamTeriyaki->id, 'bahan_baku_id' => $ayam->id, 'jumlah_dibutuhkan' => 100]);
            Resep::create(['menu_id' => $menuAyamTeriyaki->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 150]);
            Resep::create(['menu_id' => $menuAyamTeriyaki->id, 'bahan_baku_id' => $sausTeriyaki->id, 'jumlah_dibutuhkan' => 30]);
            Resep::create(['menu_id' => $menuAyamTeriyaki->id, 'bahan_baku_id' => $wortel->id, 'jumlah_dibutuhkan' => 20]);
            Resep::create(['menu_id' => $menuAyamTeriyaki->id, 'bahan_baku_id' => $wijen->id, 'jumlah_dibutuhkan' => 5]);

            // Resep Ayam Blackpepper
            Resep::create(['menu_id' => $menuAyamBlackpepper->id, 'bahan_baku_id' => $ayam->id, 'jumlah_dibutuhkan' => 100]);
            Resep::create(['menu_id' => $menuAyamBlackpepper->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 150]);
            Resep::create(['menu_id' => $menuAyamBlackpepper->id, 'bahan_baku_id' => $sausBlackpepper->id, 'jumlah_dibutuhkan' => 30]);
            Resep::create(['menu_id' => $menuAyamBlackpepper->id, 'bahan_baku_id' => $brokoli->id, 'jumlah_dibutuhkan' => 30]);

            // Resep Sapi Teriyaki
            Resep::create(['menu_id' => $menuSapiTeriyaki->id, 'bahan_baku_id' => $sapi->id, 'jumlah_dibutuhkan' => 100]);
            Resep::create(['menu_id' => $menuSapiTeriyaki->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 150]);
            Resep::create(['menu_id' => $menuSapiTeriyaki->id, 'bahan_baku_id' => $sausTeriyaki->id, 'jumlah_dibutuhkan' => 35]);
            Resep::create(['menu_id' => $menuSapiTeriyaki->id, 'bahan_baku_id' => $wortel->id, 'jumlah_dibutuhkan' => 25]);
            Resep::create(['menu_id' => $menuSapiTeriyaki->id, 'bahan_baku_id' => $wijen->id, 'jumlah_dibutuhkan' => 5]);

            // Resep Sapi Blackpepper
            Resep::create(['menu_id' => $menuSapiBlackpepper->id, 'bahan_baku_id' => $sapi->id, 'jumlah_dibutuhkan' => 100]);
            Resep::create(['menu_id' => $menuSapiBlackpepper->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 150]);
            Resep::create(['menu_id' => $menuSapiBlackpepper->id, 'bahan_baku_id' => $sausBlackpepper->id, 'jumlah_dibutuhkan' => 35]);
            Resep::create(['menu_id' => $menuSapiBlackpepper->id, 'bahan_baku_id' => $brokoli->id, 'jumlah_dibutuhkan' => 30]);

            // Resep Udang Teriyaki
            Resep::create(['menu_id' => $menuUdangTeriyaki->id, 'bahan_baku_id' => $udang->id, 'jumlah_dibutuhkan' => 80]);
            Resep::create(['menu_id' => $menuUdangTeriyaki->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 150]);
            Resep::create(['menu_id' => $menuUdangTeriyaki->id, 'bahan_baku_id' => $sausTeriyaki->id, 'jumlah_dibutuhkan' => 30]);
            Resep::create(['menu_id' => $menuUdangTeriyaki->id, 'bahan_baku_id' => $wortel->id, 'jumlah_dibutuhkan' => 20]);

            // Resep Kombo
            Resep::create(['menu_id' => $menuKombo->id, 'bahan_baku_id' => $ayam->id, 'jumlah_dibutuhkan' => 60]);
            Resep::create(['menu_id' => $menuKombo->id, 'bahan_baku_id' => $sapi->id, 'jumlah_dibutuhkan' => 60]);
            Resep::create(['menu_id' => $menuKombo->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 180]);
            Resep::create(['menu_id' => $menuKombo->id, 'bahan_baku_id' => $sausTeriyaki->id, 'jumlah_dibutuhkan' => 40]);
            Resep::create(['menu_id' => $menuKombo->id, 'bahan_baku_id' => $wijen->id, 'jumlah_dibutuhkan' => 5]);

            // Resep Vegetarian
            Resep::create(['menu_id' => $menuVegetarian->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 150]);
            Resep::create(['menu_id' => $menuVegetarian->id, 'bahan_baku_id' => $wortel->id, 'jumlah_dibutuhkan' => 40]);
            Resep::create(['menu_id' => $menuVegetarian->id, 'bahan_baku_id' => $brokoli->id, 'jumlah_dibutuhkan' => 40]);
            Resep::create(['menu_id' => $menuVegetarian->id, 'bahan_baku_id' => $kubis->id, 'jumlah_dibutuhkan' => 30]);
            Resep::create(['menu_id' => $menuVegetarian->id, 'bahan_baku_id' => $kecapManis->id, 'jumlah_dibutuhkan' => 20]);

            // Resep Telur Mata Sapi
            Resep::create(['menu_id' => $menuTelurMataapi->id, 'bahan_baku_id' => $telur->id, 'jumlah_dibutuhkan' => 1]);
            Resep::create(['menu_id' => $menuTelurMataapi->id, 'bahan_baku_id' => $minyakGoreng->id, 'jumlah_dibutuhkan' => 15]);

            // Resep Mie Goreng
            Resep::create(['menu_id' => $menuMieGoreng->id, 'bahan_baku_id' => $mie->id, 'jumlah_dibutuhkan' => 1]);
            Resep::create(['menu_id' => $menuMieGoreng->id, 'bahan_baku_id' => $telur->id, 'jumlah_dibutuhkan' => 1]);
            Resep::create(['menu_id' => $menuMieGoreng->id, 'bahan_baku_id' => $kubis->id, 'jumlah_dibutuhkan' => 30]);
            Resep::create(['menu_id' => $menuMieGoreng->id, 'bahan_baku_id' => $kecapManis->id, 'jumlah_dibutuhkan' => 20]);
            Resep::create(['menu_id' => $menuMieGoreng->id, 'bahan_baku_id' => $minyakGoreng->id, 'jumlah_dibutuhkan' => 20]);
            Resep::create(['menu_id' => $menuMieGoreng->id, 'bahan_baku_id' => $daun_bawang->id, 'jumlah_dibutuhkan' => 5]);

            $this->command->info('40 resep berhasil dibuat.');

            // =====================================================
            // 5. BUAT TRANSAKSI (30 hari terakhir untuk testing)
            // =====================================================
            $this->command->info('Membuat data transaksi 30 hari terakhir...');

            $menus = Menu::all();
            $progressBar = $this->command->getOutput()->createProgressBar(30);

            // Track pengurangan stok
            $stokChanges = [];

            for ($i = 30; $i >= 0; $i--) {
                $tanggal = Carbon::today()->subDays($i);

                // Buat 5-15 transaksi per hari
                $jumlahTransaksi = rand(5, 15);

                for ($j = 0; $j < $jumlahTransaksi; $j++) {
                    $totalHarga = 0;
                    $detailItems = [];

                    // Buat 1-4 detail per transaksi
                    $jumlahDetail = rand(1, 4);
                    $selectedMenus = $menus->random(min($jumlahDetail, $menus->count()));

                    foreach ($selectedMenus as $menu) {
                        $jumlahPorsi = rand(1, 3);
                        $harga = $menu->harga;
                        $totalHarga += $jumlahPorsi * $harga;

                        $detailItems[] = [
                            'menu_id' => $menu->id,
                            'jumlah' => $jumlahPorsi,
                            'harga_saat_transaksi' => $harga,
                            'created_at' => $tanggal,
                            'updated_at' => $tanggal,
                        ];

                        // Hitung pengurangan stok berdasarkan resep
                        $reseps = Resep::where('menu_id', $menu->id)->get();
                        foreach ($reseps as $resep) {
                            $bahanId = $resep->bahan_baku_id;
                            $pengurangan = $resep->jumlah_dibutuhkan * $jumlahPorsi;

                            if (!isset($stokChanges[$bahanId])) {
                                $stokChanges[$bahanId] = 0;
                            }
                            $stokChanges[$bahanId] += $pengurangan;
                        }
                    }

                    // Buat header transaksi
                    $transaksi = Transaksi::create([
                        'user_id' => $admin->id,
                        'total_harga' => $totalHarga,
                        'created_at' => $tanggal,
                        'updated_at' => $tanggal,
                    ]);

                    // Simpan detail transaksi
                    $transaksi->transaksiDetails()->createMany($detailItems);
                }

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->command->newLine();

            // Update stok bahan baku
            foreach ($stokChanges as $bahanId => $totalPengurangan) {
                $bahan = BahanBaku::find($bahanId);
                if ($bahan) {
                    $newStok = max(0, $bahan->stok_saat_ini - $totalPengurangan);
                    $bahan->update(['stok_saat_ini' => $newStok]);
                }
            }

            $totalTransaksi = Transaksi::count();
            $totalDetail = TransaksiDetail::count();

            $this->command->info("$totalTransaksi transaksi dengan $totalDetail detail berhasil dibuat.");
            $this->command->info('Stok bahan baku telah diperbarui sesuai transaksi.');

            // =====================================================
            // 6. RINGKASAN
            // =====================================================
            $this->command->newLine();
            $this->command->info('========================================');
            $this->command->info('SEEDER FUNCTIONAL TEST BERHASIL');
            $this->command->info('========================================');
            $this->command->info('');
            $this->command->info('Login Admin:');
            $this->command->info('  Email: admin@animart.com');
            $this->command->info('  Password: password');
            $this->command->info('');
            $this->command->info('Data yang dibuat:');
            $this->command->info('  - 1 Admin');
            $this->command->info('  - 15 Bahan Baku (dengan berbagai satuan)');
            $this->command->info('  - 9 Menu');
            $this->command->info('  - 40 Resep');
            $this->command->info("  - $totalTransaksi Transaksi (30 hari terakhir)");
            $this->command->info("  - $totalDetail Detail Transaksi");
            $this->command->info('');
            $this->command->info('Fitur yang dapat ditest:');
            $this->command->info('  1. Dashboard - lihat statistik & grafik');
            $this->command->info('  2. Bahan Baku - CRUD & tambah stok');
            $this->command->info('  3. Menu - CRUD dengan resep');
            $this->command->info('  4. Kasir - buat transaksi baru');
            $this->command->info('  5. Laporan - lihat & download PDF');
            $this->command->info('========================================');
        });
    }
}
