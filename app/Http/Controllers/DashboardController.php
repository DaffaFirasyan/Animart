<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Prediksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. WIDGET: STOK KRITIS ---
        $stokKritis = BahanBaku::whereColumn('stok_saat_ini', '<=', 'stok_minimum')
                             ->orderBy('nama_bahan', 'asc')
                             ->get();

        // --- 2. WIDGET: PREDIKSI HARI INI ---
        $prediksiHariIni = Prediksi::with('menu')
                                ->whereDate('tanggal_prediksi', Carbon::today())
                                ->orderBy('jumlah_prediksi', 'desc')
                                ->get();

        // --- 3. WIDGET: REKOMENDASI PEMESANAN ---
        $rekomendasiPemesanan = $this->generateRekomendasi($prediksiHariIni);

        // --- 4. WIDGET: GRAFIK TREN PENJUALAN (7 Hari Terakhir) ---
        $chartData = $this->generateChartData();


        // Kirim semua data ke view
        return view('dashboard', [
            'stokKritis' => $stokKritis,
            'prediksiHariIni' => $prediksiHariIni,
            'rekomendasiPemesanan' => $rekomendasiPemesanan,
            'chartLabels' => json_encode($chartData['labels']),
            'chartData' => json_encode($chartData['data']),
        ]);
    }

    /**
     * Logika untuk menghasilkan rekomendasi pemesanan.
     */
    private function generateRekomendasi($prediksiHariIni)
    {
        if ($prediksiHariIni->isEmpty()) {
            return [];
        }

        // 1. Hitung total kebutuhan bahan baku berdasarkan semua prediksi
        $kebutuhanBahan = [];
        foreach ($prediksiHariIni as $prediksi) {
            // Pastikan menu memiliki resep
            if ($prediksi->menu && $prediksi->menu->reseps) {
                foreach ($prediksi->menu->reseps as $resep) {
                    $bahan_id = $resep->bahan_baku_id;
                    $dibutuhkan = $resep->jumlah_dibutuhkan * $prediksi->jumlah_prediksi;

                    if (!isset($kebutuhanBahan[$bahan_id])) {
                        $kebutuhanBahan[$bahan_id] = 0;
                    }
                    $kebutuhanBahan[$bahan_id] += $dibutuhkan;
                }
            }
        }

        // 2. Ambil data stok saat ini
        $bahanIds = array_keys($kebutuhanBahan);
        $stokBahanSaatIni = BahanBaku::whereIn('id', $bahanIds)->get()->keyBy('id');

        // 3. Hitung rekomendasi (Kebutuhan - Stok Saat Ini)
        $rekomendasi = [];
        foreach ($kebutuhanBahan as $bahan_id => $totalDibutuhkan) {
            if (isset($stokBahanSaatIni[$bahan_id])) {
                $bahan = $stokBahanSaatIni[$bahan_id];
                $rekomendasiBeli = $totalDibutuhkan - $bahan->stok_saat_ini;

                // Hanya rekomendasikan jika kita perlu beli (hasilnya positif)
                if ($rekomendasiBeli > 0) {
                    $rekomendasi[] = [
                        'nama_bahan' => $bahan->nama_bahan,
                        'satuan' => $bahan->satuan,
                        'rekomendasi_beli' => ceil($rekomendasiBeli) // Bulatkan ke atas
                    ];
                }
            }
        }

        return $rekomendasi;
    }

    /**
     * Logika untuk menghasilkan data grafik.
     */
    private function generateChartData()
    {
        $labels = [];
        $data = [];

        // Ambil data 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $labels[] = $tanggal->format('d M'); // Format: "17 Okt"

            $omzetHarian = Transaksi::whereDate('created_at', $tanggal)
                                    ->sum('total_harga');

            $data[] = $omzetHarian;
        }

        return ['labels' => $labels, 'data' => $data];
    }
}