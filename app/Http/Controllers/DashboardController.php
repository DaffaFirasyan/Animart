<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Prediksi;
use App\Models\Transaksi;
use Carbon\Carbon; // Pastikan ini ada
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Tetapkan Senin sebagai awal minggu HANYA untuk request ini
        $now = Carbon::now()->startOfWeek(Carbon::MONDAY);

        // --- FILTER TAHUN (Year-over-Year) ---
        $selectedYear = $request->input('filter_year', Carbon::now()->year);
        $availableYears = $this->getAvailableYears();
        $previousYear = $selectedYear - 1;

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

        // --- 4. WIDGET: GRAFIK TREN PENJUALAN dengan YoY ---
        $filterGrafik = $request->input('filter_grafik', 'harian');
        $chartData = $this->generateChartData($filterGrafik, $selectedYear);

        // --- 5. WIDGET: OMZET DENGAN FILTER dan YoY ---
        $filterOmzet = $request->input('filter_omzet', 'harian');
        $omzetData = $this->calculateOmzetWithYoY($filterOmzet, $selectedYear, $previousYear);

        // --- 6. WIDGET: STATISTIK YoY LENGKAP ---
        $yoyStats = $this->calculateYoYStatistics($selectedYear, $previousYear);

        // Kirim semua data ke view
        return view('dashboard', [
            'stokKritis' => $stokKritis,
            'prediksiHariIni' => $prediksiHariIni,
            'rekomendasiPemesanan' => $rekomendasiPemesanan,
            'chartLabels' => json_encode($chartData['labels']),
            'chartData' => json_encode($chartData['data']),
            'chartDataPreviousYear' => json_encode($chartData['dataPreviousYear'] ?? []),
            'omzetWidget' => $omzetData['current'],
            'omzetPreviousYear' => $omzetData['previous'],
            'omzetChange' => $omzetData['change'],
            'omzetChangePercentage' => $omzetData['changePercentage'],
            'judulOmzet' => $omzetData['title'],
            'filterOmzet' => $filterOmzet,
            'filterGrafik' => $filterGrafik,
            'selectedYear' => $selectedYear,
            'previousYear' => $previousYear,
            'availableYears' => $availableYears,
            'yoyStats' => $yoyStats,
        ]);
    }

    /**
     * Mendapatkan tahun-tahun yang tersedia dari data transaksi
     */
    private function getAvailableYears()
    {
        $years = Transaksi::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Jika tidak ada data, gunakan tahun sekarang
        if (empty($years)) {
            $years = [Carbon::now()->year];
        }

        return $years;
    }

    /**
     * Hitung omzet dengan perbandingan YoY
     */
    private function calculateOmzetWithYoY($filterOmzet, $selectedYear, $previousYear)
    {
        $now = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $judulOmzet = "Omzet Hari Ini";
        
        // Tentukan range waktu berdasarkan filter
        if ($filterOmzet == 'harian') {
            $startTime = Carbon::create($selectedYear)->today()->startOfDay();
            $endTime = Carbon::create($selectedYear)->today()->endOfDay();
            $startTimePrev = Carbon::create($previousYear)->today()->startOfDay();
            $endTimePrev = Carbon::create($previousYear)->today()->endOfDay();
            $judulOmzet = "Omzet Hari Ini";
        } elseif ($filterOmzet == 'mingguan') {
            $startTime = Carbon::create($selectedYear)->setISODate($selectedYear, Carbon::now()->weekOfYear)->startOfWeek(Carbon::MONDAY);
            $endTime = Carbon::create($selectedYear)->setISODate($selectedYear, Carbon::now()->weekOfYear)->endOfWeek(Carbon::SUNDAY);
            $startTimePrev = Carbon::create($previousYear)->setISODate($previousYear, Carbon::now()->weekOfYear)->startOfWeek(Carbon::MONDAY);
            $endTimePrev = Carbon::create($previousYear)->setISODate($previousYear, Carbon::now()->weekOfYear)->endOfWeek(Carbon::SUNDAY);
            $judulOmzet = "Omzet Minggu Ini";
        } elseif ($filterOmzet == 'bulanan') {
            $currentMonth = Carbon::now()->month;
            $startTime = Carbon::create($selectedYear, $currentMonth, 1)->startOfDay();
            $endTime = Carbon::create($selectedYear, $currentMonth, 1)->endOfMonth()->endOfDay();
            $startTimePrev = Carbon::create($previousYear, $currentMonth, 1)->startOfDay();
            $endTimePrev = Carbon::create($previousYear, $currentMonth, 1)->endOfMonth()->endOfDay();
            $judulOmzet = "Omzet Bulan Ini";
        } else {
            // Yearly
            $startTime = Carbon::create($selectedYear, 1, 1)->startOfDay();
            $endTime = Carbon::create($selectedYear, 12, 31)->endOfDay();
            $startTimePrev = Carbon::create($previousYear, 1, 1)->startOfDay();
            $endTimePrev = Carbon::create($previousYear, 12, 31)->endOfDay();
            $judulOmzet = "Omzet Tahun " . $selectedYear;
        }

        // Hitung omzet tahun sekarang dan tahun sebelumnya
        $currentOmzet = Transaksi::whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');
        $previousOmzet = Transaksi::whereBetween('created_at', [$startTimePrev, $endTimePrev])->sum('total_harga');

        // Hitung perubahan
        $change = $currentOmzet - $previousOmzet;
        $changePercentage = $previousOmzet > 0 ? (($change / $previousOmzet) * 100) : 0;

        return [
            'current' => $currentOmzet,
            'previous' => $previousOmzet,
            'change' => $change,
            'changePercentage' => round($changePercentage, 2),
            'title' => $judulOmzet,
        ];
    }

    /**
     * Hitung statistik YoY lengkap untuk widget tambahan
     */
    private function calculateYoYStatistics($selectedYear, $previousYear)
    {
        // Total Transaksi
        $totalTransaksiCurrent = Transaksi::whereYear('created_at', $selectedYear)->count();
        $totalTransaksiPrevious = Transaksi::whereYear('created_at', $previousYear)->count();
        $transaksiChange = $totalTransaksiPrevious > 0 
            ? ((($totalTransaksiCurrent - $totalTransaksiPrevious) / $totalTransaksiPrevious) * 100) 
            : 0;

        // Rata-rata Transaksi per Bulan
        $avgTransaksiCurrent = $totalTransaksiCurrent / 12;
        $avgTransaksiPrevious = $totalTransaksiPrevious / 12;

        // Total Omzet Tahunan
        $omzetTahunanCurrent = Transaksi::whereYear('created_at', $selectedYear)->sum('total_harga');
        $omzetTahunanPrevious = Transaksi::whereYear('created_at', $previousYear)->sum('total_harga');
        $omzetChange = $omzetTahunanPrevious > 0 
            ? ((($omzetTahunanCurrent - $omzetTahunanPrevious) / $omzetTahunanPrevious) * 100) 
            : 0;

        return [
            'totalTransaksiCurrent' => $totalTransaksiCurrent,
            'totalTransaksiPrevious' => $totalTransaksiPrevious,
            'transaksiChange' => round($transaksiChange, 2),
            'avgTransaksiCurrent' => round($avgTransaksiCurrent, 2),
            'avgTransaksiPrevious' => round($avgTransaksiPrevious, 2),
            'omzetTahunanCurrent' => $omzetTahunanCurrent,
            'omzetTahunanPrevious' => $omzetTahunanPrevious,
            'omzetChange' => round($omzetChange, 2),
        ];
    }

    /**
     * Logika untuk menghasilkan rekomendasi pemesanan.
     */
    private function generateRekomendasi($prediksiHariIni)
    {
        // ... (Kode ini tetap sama) ...
        if ($prediksiHariIni->isEmpty()) { return []; } $kebutuhanBahan = []; foreach ($prediksiHariIni as $prediksi) { if ($prediksi->menu && $prediksi->menu->reseps) { foreach ($prediksi->menu->reseps as $resep) { $bahan_id = $resep->bahan_baku_id; $dibutuhkan = $resep->jumlah_dibutuhkan * $prediksi->jumlah_prediksi; if (!isset($kebutuhanBahan[$bahan_id])) { $kebutuhanBahan[$bahan_id] = 0; } $kebutuhanBahan[$bahan_id] += $dibutuhkan; } } } $bahanIds = array_keys($kebutuhanBahan); $stokBahanSaatIni = BahanBaku::whereIn('id', $bahanIds)->get()->keyBy('id'); $rekomendasi = []; foreach ($kebutuhanBahan as $bahan_id => $totalDibutuhkan) { if (isset($stokBahanSaatIni[$bahan_id])) { $bahan = $stokBahanSaatIni[$bahan_id]; $rekomendasiBeli = $totalDibutuhkan - $bahan->stok_saat_ini; if ($rekomendasiBeli > 0) { $rekomendasi[] = ['nama_bahan' => $bahan->nama_bahan, 'satuan' => $bahan->satuan, 'rekomendasi_beli' => ceil($rekomendasiBeli)]; } } } return $rekomendasi;
    }


    /**
     * Logika untuk menghasilkan data grafik dengan filter dan YoY (Final Fix Presisi Waktu & Start of Week).
     */
    private function generateChartData($filter, $selectedYear = null)
    {
        $labels = [];
        $data = [];
        $dataPreviousYear = [];
        
        // Tetapkan Senin sebagai awal minggu HANYA untuk fungsi ini
        $now = Carbon::now()->startOfWeek(Carbon::MONDAY);
        
        // Jika tidak ada tahun yang dipilih, gunakan tahun sekarang
        if ($selectedYear === null) {
            $selectedYear = Carbon::now()->year;
        }
        $previousYear = $selectedYear - 1;

        if ($filter == 'harian') {
            // Ambil data 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::create($selectedYear)->today()->subDays($i);
                $tanggalPrev = Carbon::create($previousYear)->today()->subDays($i);
                
                $labels[] = $tanggal->format('d M');
                
                $startTime = $tanggal->copy()->startOfDay();
                $endTime = $tanggal->copy()->endOfDay();
                $startTimePrev = $tanggalPrev->copy()->startOfDay();
                $endTimePrev = $tanggalPrev->copy()->endOfDay();
                
                $omzetHarian = Transaksi::whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');
                $omzetHarianPrev = Transaksi::whereBetween('created_at', [$startTimePrev, $endTimePrev])->sum('total_harga');
                
                $data[] = $omzetHarian;
                $dataPreviousYear[] = $omzetHarianPrev;
            }
        } elseif ($filter == 'mingguan') {
            // Ambil data 4 minggu terakhir
            for ($i = 3; $i >= 0; $i--) {
                 // [PERBAIKAN] Gunakan $now yang sudah disetel startOfWeek(Carbon::MONDAY)
                $mingguMulai = Carbon::create($selectedYear)->setISODate($selectedYear, Carbon::now()->weekOfYear - $i)->startOfWeek(Carbon::MONDAY);
                $mingguSelesai = Carbon::create($selectedYear)->setISODate($selectedYear, Carbon::now()->weekOfYear - $i)->endOfWeek(Carbon::SUNDAY);
                
                $mingguMulaiPrev = Carbon::create($previousYear)->setISODate($previousYear, Carbon::now()->weekOfYear - $i)->startOfWeek(Carbon::MONDAY);
                $mingguSelesaiPrev = Carbon::create($previousYear)->setISODate($previousYear, Carbon::now()->weekOfYear - $i)->endOfWeek(Carbon::SUNDAY);
                
                $labels[] = "Minggu " . $mingguMulai->format('d M');
                
                $startTime = $mingguMulai->copy()->startOfDay();
                $endTime = $mingguSelesai->copy()->endOfDay();
                $startTimePrev = $mingguMulaiPrev->copy()->startOfDay();
                $endTimePrev = $mingguSelesaiPrev->copy()->endOfDay();
                
                $omzetMingguan = Transaksi::whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');
                $omzetMingguanPrev = Transaksi::whereBetween('created_at', [$startTimePrev, $endTimePrev])->sum('total_harga');
                
                $data[] = $omzetMingguan;
                $dataPreviousYear[] = $omzetMingguanPrev;
            }
        } elseif ($filter == 'bulanan') {
            // Ambil data 12 bulan dalam tahun yang dipilih
            for ($i = 1; $i <= 12; $i++) {
                $bulan = Carbon::create($selectedYear, $i, 1);
                $bulanPrev = Carbon::create($previousYear, $i, 1);
                
                $labels[] = $bulan->format('M Y');
                
                $startTime = $bulan->copy()->startOfMonth()->startOfDay();
                $endTime = $bulan->copy()->endOfMonth()->endOfDay();
                $startTimePrev = $bulanPrev->copy()->startOfMonth()->startOfDay();
                $endTimePrev = $bulanPrev->copy()->endOfMonth()->endOfDay();
                
                $omzetBulanan = Transaksi::whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');
                $omzetBulananPrev = Transaksi::whereBetween('created_at', [$startTimePrev, $endTimePrev])->sum('total_harga');
                
                $data[] = $omzetBulanan;
                $dataPreviousYear[] = $omzetBulananPrev;
            }
        }

        return [
            'labels' => $labels, 
            'data' => $data,
            'dataPreviousYear' => $dataPreviousYear
        ];
    }
}