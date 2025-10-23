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

        // --- 4. WIDGET: GRAFIK TREN PENJUALAN ---
        $filterGrafik = $request->input('filter_grafik', 'harian');
        $chartData = $this->generateChartData($filterGrafik); // Method ini juga akan diperbaiki

        // --- 5. WIDGET: OMZET DENGAN FILTER ---
        $filterOmzet = $request->input('filter_omzet', 'harian');
        $queryOmzet = Transaksi::query();
        $judulOmzet = "Omzet Hari Ini";
        $startTime = Carbon::today()->startOfDay();
        $endTime = Carbon::today()->endOfDay();

        if ($filterOmzet == 'harian') {
            $startTime = Carbon::today()->startOfDay();
            $endTime = Carbon::today()->endOfDay();
            $judulOmzet = "Omzet Hari Ini";
        } elseif ($filterOmzet == 'mingguan') {
            // [PERBAIKAN] Gunakan $now yang sudah disetel startOfWeek(Carbon::MONDAY)
            $startTime = $now->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
            $endTime = $now->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();
            $judulOmzet = "Omzet Minggu Ini";
        } elseif ($filterOmzet == 'bulanan') {
            $startTime = Carbon::now()->startOfMonth()->startOfDay();
            $endTime = Carbon::now()->endOfMonth()->endOfDay();
            $judulOmzet = "Omzet Bulan Ini";
        }

        $omzetWidget = $queryOmzet->whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');

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
            'filterGrafik' => $filterGrafik,
        ]);
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
     * Logika untuk menghasilkan data grafik dengan filter (Final Fix Presisi Waktu & Start of Week).
     */
    private function generateChartData($filter)
    {
        $labels = [];
        $data = [];
        // Tetapkan Senin sebagai awal minggu HANYA untuk fungsi ini
        $now = Carbon::now()->startOfWeek(Carbon::MONDAY);

        if ($filter == 'harian') {
            // Ambil data 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::today()->subDays($i);
                $labels[] = $tanggal->format('d M');
                $startTime = $tanggal->copy()->startOfDay();
                $endTime = $tanggal->copy()->endOfDay();
                $omzetHarian = Transaksi::whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');
                $data[] = $omzetHarian;
            }
        } elseif ($filter == 'mingguan') {
            // Ambil data 4 minggu terakhir
            for ($i = 3; $i >= 0; $i--) {
                 // [PERBAIKAN] Gunakan $now yang sudah disetel startOfWeek(Carbon::MONDAY)
                $mingguMulai = $now->copy()->subWeeks($i)->startOfWeek(Carbon::MONDAY);
                $mingguSelesai = $now->copy()->subWeeks($i)->endOfWeek(Carbon::SUNDAY);
                $labels[] = "Minggu " . $mingguMulai->format('d M');
                $startTime = $mingguMulai->copy()->startOfDay();
                $endTime = $mingguSelesai->copy()->endOfDay();
                $omzetMingguan = Transaksi::whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');
                $data[] = $omzetMingguan;
            }
        } elseif ($filter == 'bulanan') {
            // Ambil data 6 bulan terakhir
            for ($i = 5; $i >= 0; $i--) {
                $bulan = Carbon::now()->subMonths($i);
                $labels[] = $bulan->format('M Y');
                $startTime = $bulan->copy()->startOfMonth()->startOfDay();
                $endTime = $bulan->copy()->endOfMonth()->endOfDay();
                $omzetBulanan = Transaksi::whereBetween('created_at', [$startTime, $endTime])->sum('total_harga');
                $data[] = $omzetBulanan;
            }
        }

        return ['labels' => $labels, 'data' => $data];
    }
}