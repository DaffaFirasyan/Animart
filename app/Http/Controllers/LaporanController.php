<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon; // <-- Pastikan ini ada
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Pastikan ini ada

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan rentang tanggal & konversi ke Carbon
        // [PERBAIKAN UTAMA] Gunakan ->startOfDay() dan ->endOfDay()
        $tanggalMulaiCarbon = Carbon::parse($request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString()))->startOfDay();
        $tanggalAkhirCarbon = Carbon::parse($request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString()))->endOfDay();

        // Format kembali ke string HANYA untuk ditampilkan di input form
        $inputTanggalMulai = $tanggalMulaiCarbon->toDateString();
        $inputTanggalAkhir = $tanggalAkhirCarbon->toDateString();

        // 2. [PERBAIKAN UTAMA] Buat query dasar menggunakan whereBetween pada timestamp
        // BUKAN DB::raw('DATE(created_at)')
        $baseQuery = Transaksi::whereBetween('created_at', [$tanggalMulaiCarbon, $tanggalAkhirCarbon]);

        // 3. Hitung Total Omzet dari query dasar (SEBELUM paginate)
        $totalOmzet = $baseQuery->sum('total_harga');

        // 4. Hitung Total Transaksi dari query dasar (SEBELUM paginate)
        $totalTransaksi = $baseQuery->count();

        // 5. Ambil ID transaksi dari query dasar untuk filter detail
        // Kloning query agar perhitungan total tidak terpengaruh oleh pluck
        $transaksiIds = $baseQuery->clone()->pluck('id');

        // 6. Ambil Menu Terlaris (Qty) dari detail yang terfilter
        $menuTerlaris = TransaksiDetail::whereIn('transaksi_id', $transaksiIds)
                                     ->with('menu')
                                     ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
                                     ->groupBy('menu_id')
                                     ->orderBy('total_terjual', 'desc')
                                     ->take(5)
                                     ->get();

        // 7. Ambil Pendapatan per Menu (Rp)
        $pendapatanPerMenu = TransaksiDetail::whereIn('transaksi_id', $transaksiIds)
                                     ->with('menu')
                                     ->select('menu_id', DB::raw('SUM(jumlah * harga_saat_transaksi) as total_pendapatan'))
                                     ->groupBy('menu_id')
                                     ->orderBy('total_pendapatan', 'desc')
                                     ->take(5)
                                     ->get();

        // 8. Lakukan paginasi HANYA untuk daftar riwayat
        // Kloning query lagi agar tidak terpengaruh perhitungan sebelumnya
        $transaksis = $baseQuery->clone()->with(['user', 'transaksiDetails.menu'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(15)
                                ->withQueryString(); // Agar pagination tetap membawa filter tanggal

        // 9. Kirim semua data ke view
        return view('laporan.index', [
            'transaksis' => $transaksis,
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'menuTerlaris' => $menuTerlaris,
            'pendapatanPerMenu' => $pendapatanPerMenu,
            'inputTanggalMulai' => $inputTanggalMulai, // Kirim string untuk form
            'inputTanggalAkhir' => $inputTanggalAkhir,  // Kirim string untuk form
        ]);
    }

    public function downloadPDF(Request $request)
    {
        // 1. Ambil data (Logika SAMA dengan index, TANPA PAGINASI)
        // [PERBAIKAN UTAMA] Gunakan ->startOfDay() dan ->endOfDay()
        $tanggalMulaiCarbon = Carbon::parse($request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString()))->startOfDay();
        $tanggalAkhirCarbon = Carbon::parse($request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString()))->endOfDay();

        // [PERBAIKAN UTAMA] Buat query dasar menggunakan whereBetween pada timestamp
        $baseQuery = Transaksi::whereBetween('created_at', [$tanggalMulaiCarbon, $tanggalAkhirCarbon]);

        // Hitung total dari query dasar
        $totalOmzet = $baseQuery->sum('total_harga');
        $totalTransaksi = $baseQuery->count();
        $transaksiIds = $baseQuery->clone()->pluck('id'); // Clone

        $menuTerlaris = TransaksiDetail::whereIn('transaksi_id', $transaksiIds)
                                     ->with('menu')
                                     ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
                                     ->groupBy('menu_id')
                                     ->orderBy('total_terjual', 'desc')
                                     ->take(5)
                                     ->get();

        // Ambil SEMUA transaksi
        $transaksis = $baseQuery->clone()->with(['user', 'transaksiDetails.menu']) // Clone
                                ->orderBy('created_at', 'asc') // Urutkan dari lama ke baru untuk PDF
                                ->get();

        // 2. Kumpulkan data untuk view PDF
        $data = [
            'transaksis' => $transaksis,
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'menuTerlaris' => $menuTerlaris,
            'inputTanggalMulai' => $tanggalMulaiCarbon->format('d M Y'), // Format tanggal untuk PDF
            'inputTanggalAkhir' => $tanggalAkhirCarbon->format('d M Y'),  // Format tanggal untuk PDF
        ];

        // 3. Buat PDF
        $pdf = Pdf::loadView('laporan.pdf', $data);

        // 4. Download PDF
        $namaFile = 'Laporan_Animart_' . $tanggalMulaiCarbon->format('Y-m-d') . '_sd_' . $tanggalAkhirCarbon->format('Y-m-d') . '.pdf';
        return $pdf->download($namaFile);
    }
}