<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
public function index(Request $request)
    {
        // 1. Tentukan rentang tanggal
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // 2. [PERBAIKAN] Buat query dasar untuk SEMUA transaksi dalam rentang
        $baseQuery = Transaksi::whereBetween(DB::raw('DATE(created_at)'), [$tanggalMulai, $tanggalAkhir]);

        // 3. [PERBAIKAN] Hitung Total Omzet dari query dasar (SEBELUM paginate)
        $totalOmzet = $baseQuery->sum('total_harga');

        // 4. [PERBAIKAN] Hitung Total Transaksi dari query dasar (SEBELUM paginate)
        $totalTransaksi = $baseQuery->count();

        // 5. [PERBAIKAN] Ambil ID transaksi dari query dasar untuk filter detail
        $transaksiIds = $baseQuery->pluck('id');

        // 6. [PERBAIKAN] Ambil Menu Terlaris dari detail yang terfilter
        $menuTerlaris = TransaksiDetail::whereIn('transaksi_id', $transaksiIds)
                                     ->with('menu')
                                     ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
                                     ->groupBy('menu_id')
                                     ->orderBy('total_terjual', 'desc')
                                     ->take(5)
                                     ->get();

        // 7. [PERBAIKAN] Lakukan paginasi HANYA untuk daftar riwayat
        $transaksis = $baseQuery->with(['user', 'transaksiDetails.menu'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(15)
                                ->withQueryString();

        // 8. [FITUR BARU] Ambil Pendapatan per Menu
        $pendapatanPerMenu = TransaksiDetail::whereIn('transaksi_id', $transaksiIds)
                                     ->with('menu')
                                     ->select('menu_id', DB::raw('SUM(jumlah * harga_saat_transaksi) as total_pendapatan'))
                                     ->groupBy('menu_id')
                                     ->orderBy('total_pendapatan', 'desc')
                                     ->take(5)
                                     ->get();

        // 9. Kirim semua data ke view
        return view('laporan.index', [
            'transaksis' => $transaksis,
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'menuTerlaris' => $menuTerlaris,
            'inputTanggalMulai' => $tanggalMulai,
            'inputTanggalAkhir' => $tanggalAkhir,
            'pendapatanPerMenu' => $pendapatanPerMenu,
        ]);
    }

    public function downloadPDF(Request $request)
    {
        // 1. Ambil data (Logika yang SAMA PERSIS dengan method index, tapi TANPA PAGINASI)
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        $baseQuery = Transaksi::whereBetween(DB::raw('DATE(created_at)'), [$tanggalMulai, $tanggalAkhir]);

        $totalOmzet = $baseQuery->sum('total_harga');
        $totalTransaksi = $baseQuery->count();
        $transaksiIds = $baseQuery->pluck('id');

        $menuTerlaris = TransaksiDetail::whereIn('transaksi_id', $transaksiIds)
                                     ->with('menu')
                                     ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
                                     ->groupBy('menu_id')
                                     ->orderBy('total_terjual', 'desc')
                                     ->take(5)
                                     ->get();

        // Ambil SEMUA transaksi, BUKAN paginasi
        $transaksis = $baseQuery->with(['user', 'transaksiDetails.menu'])
                                ->orderBy('created_at', 'asc') // Urutkan dari lama ke baru untuk PDF
                                ->get();

        // 2. Kumpulkan data untuk dikirim ke view PDF
        $data = [
            'transaksis' => $transaksis,
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'menuTerlaris' => $menuTerlaris,
            'inputTanggalMulai' => Carbon::parse($tanggalMulai)->format('d M Y'),
            'inputTanggalAkhir' => Carbon::parse($tanggalAkhir)->format('d M Y'),
        ];
        
        // 3. Buat PDF
        $pdf = Pdf::loadView('laporan.pdf', $data);
        
        // 4. Download PDF
        $namaFile = 'Laporan_Animart_' . $tanggalMulai . '_sd_' . $tanggalAkhir . '.pdf';
        return $pdf->download($namaFile);
    }
}