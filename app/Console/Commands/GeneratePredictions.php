<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Menu;
use App\Models\TransaksiDetail;
use App\Models\Prediksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GeneratePredictions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-predictions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghasilkan prediksi penjualan harian menggunakan Simple Moving Average (SMA)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai kalkulasi prediksi SMA...');

        $menus = Menu::all();
        $n_days = 7; // Kita akan menggunakan 7-Day Moving Average

        // Kita menghitung prediksi untuk HARI INI
        $tanggalPrediksi = Carbon::today();

        foreach ($menus as $menu) {
            $totalPenjualan = 0;

            // Ambil data penjualan 7 hari ke belakang (dari kemarin)
            for ($i = 1; $i <= $n_days; $i++) {
                $tanggal = Carbon::today()->subDays($i);

                $penjualanHarian = TransaksiDetail::where('menu_id', $menu->id)
                                    ->whereDate('created_at', $tanggal)
                                    ->sum('jumlah');

                $totalPenjualan += $penjualanHarian;
            }

            // Hitung rata-rata (SMA)
            $prediksiSMA = $totalPenjualan / $n_days;

            // Simpan atau perbarui prediksi di database
            // Ini akan mencari prediksi untuk menu ini di tanggal ini,
            // jika ada, akan di-update. Jika tidak, akan dibuat baru.
            Prediksi::updateOrCreate(
                [
                    'menu_id' => $menu->id,
                    'tanggal_prediksi' => $tanggalPrediksi,
                ],
                [
                    'jumlah_prediksi' => round($prediksiSMA) // Dibulatkan
                ]
            );
        }

        $this->info('Kalkulasi prediksi SMA selesai.');
        Log::info('Prediksi SMA berhasil dijalankan.'); // Catat di log
        return 0;
    }
}