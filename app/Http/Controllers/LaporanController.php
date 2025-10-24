<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Filter
        $tanggalMulaiCarbon = Carbon::parse($request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString()))->startOfDay();
        $tanggalAkhirCarbon = Carbon::parse($request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString()))->endOfDay();
        $filterJenis = $request->input('filter_jenis', 'semua'); // Default 'semua'

        $inputTanggalMulai = $tanggalMulaiCarbon->toDateString();
        $inputTanggalAkhir = $tanggalAkhirCarbon->toDateString();

        // Inisialisasi variabel data
        $totalPemasukan = 0;
        $totalTransaksi = 0;
        $menuTerlaris = collect(); // Gunakan collection kosong
        $pendapatanPerMenu = collect();
        $daftarPemasukan = collect(); // Gunakan collection kosong
        $totalPengeluaran = 0;
        $daftarPengeluaran = collect();
        $labaRugi = null; // Default null

        // 2. Ambil Data Pemasukan (jika filter 'semua' atau 'pemasukan')
        if ($filterJenis == 'semua' || $filterJenis == 'pemasukan') {
            $queryPemasukan = Transaksi::whereBetween('created_at', [$tanggalMulaiCarbon, $tanggalAkhirCarbon]);
            $totalPemasukan = $queryPemasukan->sum('total_harga');
            $totalTransaksi = $queryPemasukan->count();
            $transaksiPemasukanIds = $queryPemasukan->clone()->pluck('id');

            $menuTerlaris = TransaksiDetail::whereIn('transaksi_id', $transaksiPemasukanIds)
                                         ->with('menu')
                                         ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
                                         ->groupBy('menu_id')->orderBy('total_terjual', 'desc')->take(5)->get();
            $pendapatanPerMenu = TransaksiDetail::whereIn('transaksi_id', $transaksiPemasukanIds)
                                         ->with('menu')
                                         ->select('menu_id', DB::raw('SUM(jumlah * harga_saat_transaksi) as total_pendapatan'))
                                         ->groupBy('menu_id')->orderBy('total_pendapatan', 'desc')->take(5)->get();
            // Ambil data paginasi hanya jika diperlukan
            if ($filterJenis == 'semua' || $filterJenis == 'pemasukan'){
                 $daftarPemasukan = $queryPemasukan->clone()->with(['user', 'transaksiDetails.menu'])
                                    ->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
            }
        }

        // 3. Ambil Data Pengeluaran (jika filter 'semua' atau 'pengeluaran')
        if ($filterJenis == 'semua' || $filterJenis == 'pengeluaran') {
            $queryPengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$tanggalMulaiCarbon, $tanggalAkhirCarbon]);
            $totalPengeluaran = $queryPengeluaran->sum('jumlah_pengeluaran');
             // Ambil data list hanya jika diperlukan
            if ($filterJenis == 'semua' || $filterJenis == 'pengeluaran'){
                $daftarPengeluaran = $queryPengeluaran->clone()->with('bahanBaku')
                                                    ->orderBy('tanggal_pengeluaran', 'desc')->limit(50)->get();
            }
        }

        // 4. Hitung Laba/Rugi (HANYA jika filter 'semua')
        if ($filterJenis == 'semua') {
            $labaRugi = $totalPemasukan - $totalPengeluaran;
        }

        // 5. Kirim semua data ke view
        return view('laporan.index', [
            'daftarPemasukan' => $daftarPemasukan,
            'totalPemasukan' => $totalPemasukan,
            'totalTransaksi' => $totalTransaksi,
            'menuTerlaris' => $menuTerlaris,
            'pendapatanPerMenu' => $pendapatanPerMenu,
            'totalPengeluaran' => $totalPengeluaran,
            'daftarPengeluaran' => $daftarPengeluaran,
            'labaRugi' => $labaRugi,
            'inputTanggalMulai' => $inputTanggalMulai,
            'inputTanggalAkhir' => $inputTanggalAkhir,
            'filterJenisAktif' => $filterJenis, // Kirim filter aktif
        ]);
    }

    public function downloadPDF(Request $request)
    {
        // 1. Ambil Filter
        $tanggalMulaiCarbon = Carbon::parse($request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString()))->startOfDay();
        $tanggalAkhirCarbon = Carbon::parse($request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString()))->endOfDay();
        $filterJenis = $request->input('filter_jenis', 'semua'); // Ambil filter jenis juga

        // Inisialisasi
        $totalPemasukan = 0; $totalTransaksi = 0; $menuTerlaris = collect(); $daftarPemasukan = collect();
        $totalPengeluaran = 0; $daftarPengeluaran = collect(); $labaRugi = null;

        // 2. Ambil Data Pemasukan (jika perlu) - TANPA PAGINASI
        if ($filterJenis == 'semua' || $filterJenis == 'pemasukan') {
            $queryPemasukan = Transaksi::whereBetween('created_at', [$tanggalMulaiCarbon, $tanggalAkhirCarbon]);
            $totalPemasukan = $queryPemasukan->sum('total_harga');
            $totalTransaksi = $queryPemasukan->count();
            $transaksiPemasukanIds = $queryPemasukan->clone()->pluck('id');
            $menuTerlaris = TransaksiDetail::whereIn('transaksi_id', $transaksiPemasukanIds)->with('menu')
                                         ->select('menu_id', DB::raw('SUM(jumlah) as total_terjual'))
                                         ->groupBy('menu_id')->orderBy('total_terjual', 'desc')->take(5)->get();
            $daftarPemasukan = $queryPemasukan->clone()->with(['user', 'transaksiDetails.menu'])
                                ->orderBy('created_at', 'asc')->get();
        }

        // 3. Ambil Data Pengeluaran (jika perlu) - TANPA PAGINASI
        if ($filterJenis == 'semua' || $filterJenis == 'pengeluaran') {
             $queryPengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$tanggalMulaiCarbon, $tanggalAkhirCarbon]);
             $totalPengeluaran = $queryPengeluaran->sum('jumlah_pengeluaran');
             $daftarPengeluaran = $queryPengeluaran->clone()->with('bahanBaku')
                                                 ->orderBy('tanggal_pengeluaran', 'asc')->get();
        }

        // 4. Hitung Laba Rugi (jika perlu)
        if ($filterJenis == 'semua') {
            $labaRugi = $totalPemasukan - $totalPengeluaran;
        }

        // 5. Kumpulkan data untuk view PDF
        $data = [
            'daftarPemasukan' => $daftarPemasukan,
            'totalPemasukan' => $totalPemasukan,
            'totalTransaksi' => $totalTransaksi,
            'menuTerlaris' => $menuTerlaris,
            'totalPengeluaran' => $totalPengeluaran,
            'daftarPengeluaran' => $daftarPengeluaran,
            'labaRugi' => $labaRugi,
            'inputTanggalMulai' => $tanggalMulaiCarbon->format('d M Y'),
            'inputTanggalAkhir' => $tanggalAkhirCarbon->format('d M Y'),
            'filterJenis' => $filterJenis, // Kirim filter jenis ke PDF
        ];

        // 6. Buat PDF
        $pdf = Pdf::loadView('laporan.pdf_bisnis', $data); // Tetap pakai view yang sama

        // 7. Download PDF
        $jenisLaporan = ucfirst($filterJenis); // "Semua", "Pemasukan", "Pengeluaran"
        $namaFile = "Laporan_{$jenisLaporan}_Animart_" . $tanggalMulaiCarbon->format('Y-m-d') . '_sd_' . $tanggalAkhirCarbon->format('Y-m-d') . '.pdf';
        return $pdf->download($namaFile);
    }
}