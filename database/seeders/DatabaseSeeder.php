<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\Prediksi; // Pastikan ini ada
use App\Models\Resep;
use App\Models\Transaksi;
use App\Models\TransaksiDetail; // Pastikan ini ada
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Hapus data lama (di LUAR transaksi)
        // Truncate adalah DDL, ia akan auto-commit, jadi tidak bisa di dalam transaction block.
        $this->command->info('Menghapus data lama...');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        TransaksiDetail::truncate();
        Transaksi::truncate();
        Prediksi::truncate();
        Resep::truncate();
        Menu::truncate();
        BahanBaku::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info('Data lama berhasil dihapus.');

        // 1. Mulai transaksi HANYA untuk membuat data baru
        DB::transaction(function () {
            
            // 1. Buat User (Pemilik)
            $owner = User::create([
                'name' => 'Pemilik Animart',
                'email' => 'owner@animart.com',
                'password' => Hash::make('password'), // password default: "password"
            ]);
            $this->command->info('User Pemilik berhasil dibuat (email: owner@animart.com, pass: password).');

            // 2. Buat Bahan Baku
            $ayam = BahanBaku::create(['nama_bahan' => 'Ayam', 'stok_saat_ini' => 5000, 'satuan' => 'gram', 'stok_minimum' => 1000]);
            $beras = BahanBaku::create(['nama_bahan' => 'Beras', 'stok_saat_ini' => 10000, 'satuan' => 'gram', 'stok_minimum' => 2000]);
            $saus = BahanBaku::create(['nama_bahan' => 'Saus Teriyaki', 'stok_saat_ini' => 2000, 'satuan' => 'ml', 'stok_minimum' => 500]);
            
            // 3. Buat Menu
            $menuAyam = Menu::create(['nama_menu' => 'Ricebowl Ayam Teriyaki', 'harga' => 15000]);
            $menuSapi = Menu::create(['nama_menu' => 'Ricebowl Sapi Teriyaki', 'harga' => 18000]);
            
            // 4. Buat Resep
            Resep::create(['menu_id' => $menuAyam->id, 'bahan_baku_id' => $ayam->id, 'jumlah_dibutuhkan' => 100]);
            Resep::create(['menu_id' => $menuAyam->id, 'bahan_baku_id' => $beras->id, 'jumlah_dibutuhkan' => 150]);
            Resep::create(['menu_id' => $menuAyam->id, 'bahan_baku_id' => $saus->id, 'jumlah_dibutuhkan' => 20]);
            // (Kita kurangi stok 99999 agar lebih realistis)

            $this->command->info('Data master (Bahan, Menu, Resep) berhasil dibuat.');

            // 5. Buat Transaksi Palsu (90 hari terakhir)
            $this->command->info('Membuat data transaksi palsu 90 hari terakhir...');
            $progressBar = $this->command->getOutput()->createProgressBar(90);

            $stokAyamSaatIni = $ayam->stok_saat_ini;
            $stokBerasSaatIni = $beras->stok_saat_ini;
            $stokSausSaatIni = $saus->stok_saat_ini;

            for ($i = 90; $i >= 0; $i--) {
                // Tentukan tanggal
                $tanggal = Carbon::today()->subDays($i);

                // Buat 10-25 transaksi per hari
                $jumlahTransaksiHariIni = rand(10, 25);

                for ($j = 0; $j < $jumlahTransaksiHariIni; $j++) {
                    $totalHarga = 0;
                    $detailItems = [];
                    $bahanUntukDikurangi = ['ayam' => 0, 'beras' => 0, 'saus' => 0];

                    // Buat 1-3 detail per transaksi
                    $jumlahDetail = rand(1, 3);
                    for ($k = 0; $k < $jumlahDetail; $k++) {
                        $jumlahPorsi = rand(1, 2);
                        $harga = $menuAyam->harga; // Kita pakai menu ayam saja
                        $totalHarga += $jumlahPorsi * $harga;

                        // Akumulasi bahan yang akan dikurangi
                        $bahanUntukDikurangi['ayam'] += 100 * $jumlahPorsi;
                        $bahanUntukDikurangi['beras'] += 150 * $jumlahPorsi;
                        $bahanUntukDikurangi['saus'] += 20 * $jumlahPorsi;

                        $detailItems[] = [
                            'menu_id' => $menuAyam->id,
                            'jumlah' => $jumlahPorsi,
                            'harga_saat_transaksi' => $harga,
                            'created_at' => $tanggal,
                            'updated_at' => $tanggal,
                        ];
                    }

                    // Buat header transaksi
                    $transaksi = Transaksi::create([
                        'user_id' => $owner->id,
                        'total_harga' => $totalHarga,
                        'created_at' => $tanggal,
                        'updated_at' => $tanggal,
                    ]);

                    // Simpan detailnya
                    $transaksi->transaksiDetails()->createMany($detailItems);

                    // Update stok internal
                    $stokAyamSaatIni -= $bahanUntukDikurangi['ayam'];
                    $stokBerasSaatIni -= $bahanUntukDikurangi['beras'];
                    $stokSausSaatIni -= $bahanUntukDikurangi['saus'];
                }
                $progressBar->advance();
            }

            // 6. Update stok akhir di database
            $ayam->update(['stok_saat_ini' => $stokAyamSaatIni]);
            $beras->update(['stok_saat_ini' => $stokBerasSaatIni]);
            $saus->update(['stok_saat_ini' => $stokSausSaatIni]);

            $progressBar->finish();
            $this->command->info("\nData transaksi palsu berhasil dibuat. Stok bahan baku telah diperbarui.");
        });
    }
}