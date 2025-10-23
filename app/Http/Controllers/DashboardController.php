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
    public function index(Request $request)
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

        // --- [PERBAIKAN] 4. WIDGET: GRAFIK TREN PENJUALAN ---
        $filterGrafik = $request->input('filter_grafik', 'harian'); // Ambil filter, default 'harian'
        $chartData = $this->generateChartData($filterGrafik); // Kirim filter ke method

        // --- 5. WIDGET: OMZET DENGAN FILTER ---
        $filterOmzet = $request->input('filter_omzet', 'harian');
        $queryOmzet = Transaksi::query();
        $judulOmzet = "Omzet Hari Ini"; 

        if ($filterOmzet == 'harian') {
            $queryOmzet->whereDate('created_at', Carbon::today());
            $judulOmzet = "Omzet Hari Ini";
        } elseif ($filterOmzet == 'mingguan') {
            $queryOmzet->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            $judulOmzet = "Omzet Minggu Ini";
        } elseif ($filterOmzet == 'bulanan') {
            $queryOmzet->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            $judulOmzet = "Omzet Bulan Ini";
        }
        $omzetWidget = $queryOmzet->sum('total_harga');


        // Kirim semua data ke view
        return view('dashboard', [
            'stokKritis' => $stokKritis,
            'prediksiHariIni' => $prediksiHariIni,
            'rekomendasiPemesanan' => $rekomendasiPemesanan,
            'chartLabels' => json_encode($chartData['labels']),
            'chartData' => json_encode($chartData['data']),
            'omzetWidget' => $omzetWidget,
            'judulOmzet' => $judulOmzet,
            'filterOmzet' => $filterOmzet,
            'filterGrafik' => $filterGrafik, // <-- Kirim filter grafik aktif ke view
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
        
        $kebutuhanBahan = [];
        foreach ($prediksiHariIni as $prediksi) {
            if ($prediksi->menu && $prediksi->menu->reseps) {
                foreach ($prediksi->menu->reseps as $resep) {
                    $bahan_id = $resep->bahan_baku_id;
                    $dibutuhkan = $resep->jumlah_dibutuhkan * $prediksi->jumlah_prediksi;
                    if (!isset($kebutuhanBahan[$bahan_id])) { $kebutuhanBahan[$bahan_id] = 0; }
                    $kebutuhanBahan[$bahan_id] += $dibutuhkan;
                }
            }
        }

        $bahanIds = array_keys($kebutuhanBahan);
        $stokBahanSaatIni = BahanBaku::whereIn('id', $bahanIds)->get()->keyBy('id');

        $rekomendasi = [];
        foreach ($kebutuhanBahan as $bahan_id => $totalDibutuhkan) {
            if (isset($stokBahanSaatIni[$bahan_id])) {
                $bahan = $stokBahanSaatIni[$bahan_id];
                $rekomendasiBeli = $totalDibutuhkan - $bahan->stok_saat_ini;
                if ($rekomendasiBeli > 0) {
                    $rekomendasi[] = [
                        'nama_bahan' => $bahan->nama_bahan,
                        'satuan' => $bahan->satuan,
                        'rekomendasi_beli' => ceil($rekomendasiBeli)
                    ];
                }
            }
        }
        return $rekomendasi;
    }

    /**
     * [PERBAIKAN] Logika untuk menghasilkan data grafik dengan filter.
     */
    private function generateChartData($filter)
    {
        $labels = [];
        $data = [];
        
        if ($filter == 'harian') {
            // Ambil data 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::today()->subDays($i);
                $labels[] = $tanggal->format('d M'); // Format: "23 Okt"
                $omzetHarian = Transaksi::whereDate('created_at', $tanggal)->sum('total_harga');
                $data[] = $omzetHarian;
            }
        } elseif ($filter == 'mingguan') {
            // Ambil data 4 minggu terakhir
            for ($i = 3; $i >= 0; $i--) {
                $mingguMulai = Carbon::now()->subWeeks($i)->startOfWeek();
                $mingguSelesai = Carbon::now()->subWeeks($i)->endOfWeek();
                // Label e.g., "Minggu 20 Okt"
                $labels[] = "Minggu " . $mingguMulai->format('d M'); 
                $omzetMingguan = Transaksi::whereBetween('created_at', [$mingguMulai, $mingguSelesai])->sum('total_harga');
                $data[] = $omzetMingguan;
            }
        } elseif ($filter == 'bulanan') {
            // Ambil data 6 bulan terakhir
            for ($i = 5; $i >= 0; $i--) {
                $bulan = Carbon::now()->subMonths($i);
                $labels[] = $bulan->format('M Y'); // Label e.g., "Okt 2025"
                $omzetBulanan = Transaksi::whereMonth('created_at', $bulan->month)
                                        ->whereYear('created_at', $bulan->year)
                                        ->sum('total_harga');
                $data[] = $omzetBulanan;
            }
        }

        return ['labels' => $labels, 'data' => $data];
    }
}