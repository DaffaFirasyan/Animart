<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan rentang tanggal default (bulan ini)
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // 2. Ambil data Transaksi (header) berdasarkan rentang tanggal
        // Kita juga ambil relasinya (user, dan details)
        $transaksis = Transaksi::with(['user', 'transaksiDetails.menu'])
                                ->whereBetween(DB::raw('DATE(created_at)'), [$tanggalMulai, $tanggalAkhir])
                                ->orderBy('created_at', 'desc')
                                ->paginate(15)
                                ->withQueryString(); // Agar pagination tetap membawa filter tanggal

        // 3. Hitung Total Omzet
        $totalOmzet = $transaksis->sum('total_harga');

        // 4. Hitung Total Transaksi
        $totalTransaksi = $transaksis->total(); // Ambil total dari pagination

        // 5. Ambil Menu Terlaris
        $menuTerlaris = TransaksiDetail::whereIn('transaksi_id', $transaksis->pluck('id'))
                                     ->with('menu')
                                     ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
                                     ->groupBy('menu_id')
                                     ->orderBy('total_terjual', 'desc')
                                     ->take(5) // Ambil 5 teratas
                                     ->get();

        // 6. Kirim semua data ke view
        return view('laporan.index', [
            'transaksis' => $transaksis,
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'menuTerlaris' => $menuTerlaris,
            'inputTanggalMulai' => $tanggalMulai,
            'inputTanggalAkhir' => $tanggalAkhir,
        ]);
    }
}