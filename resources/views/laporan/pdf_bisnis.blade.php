<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bisnis - {{ ucfirst($filterJenis) }}</title> <style>
        body { font-family: sans-serif; margin: 20px; font-size: 10px; }
        h1, h2, h3 { margin: 0 0 10px 0; padding: 0; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 5px; }
        .sub-header { text-align: center; font-size: 14px; margin-bottom: 20px;}
        h2 { font-size: 14px; margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; vertical-align: top;}
        th { background-color: #f2f2f2; font-weight: bold;}
        .summary-container { margin-bottom: 20px; }
        .summary-box { border: 1px solid #eee; padding: 10px; text-align: center; margin-bottom: 10px;}
        .summary-label { font-size: 11px; margin-bottom: 5px; color: #555; }
        .summary-value { font-size: 16px; font-weight: bold; }
        .text-green { color: green; } .text-red { color: red; } .text-blue { color: blue; }
        ul { margin: 0; padding-left: 15px;}
        .col-tanggal { width: 15%; } .col-deskripsi { width: 55%; } .col-jumlah { width: 30%; text-align: right; }
        .col-waktu { width: 20%; } .col-detail { width: 50%; } .col-total { width: 30%; text-align: right; }
        .no-border td { border: none; } /* Untuk summary table */
    </style>
</head>
<body>
    <h1>Laporan Bisnis Animart</h1>
    <div class="sub-header">Jenis Laporan: {{ ucfirst($filterJenis) }}</div> <div class="summary-container">
        <p style="text-align: center; font-size: 12px; margin-bottom: 15px;">
            <strong>Periode:</strong> {{ $inputTanggalMulai }} s/d {{ $inputTanggalAkhir }}
        </p>

        {{-- Tabel Ringkasan (tampilkan sesuai filter) --}}
        <table class="no-border">
            <tr>
                @if($filterJenis == 'semua' || $filterJenis == 'pemasukan')
                <td class="summary-box">
                    <div class="summary-label text-green">Total Pemasukan</div>
                    <div class="summary-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                </td>
                @endif

                @if($filterJenis == 'semua' || $filterJenis == 'pengeluaran')
                <td class="summary-box">
                    <div class="summary-label text-red">Total Pengeluaran</div>
                    <div class="summary-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                </td>
                @endif

                @if($filterJenis == 'semua') {{-- Laba/Rugi hanya jika 'semua' --}}
                 <td class="summary-box">
                    <div class="summary-label {{ $labaRugi >= 0 ? 'text-blue' : 'text-red' }}">
                        {{ $labaRugi >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                    </div>
                    <div class="summary-value {{ $labaRugi >= 0 ? '' : 'text-red' }}">
                        Rp {{ number_format(abs($labaRugi ?? 0), 0, ',', '.') }}
                    </div>
                </td>
                @endif
            </tr>
            {{-- Baris kedua summary jika ada data pemasukan --}}
            @if($filterJenis == 'semua' || $filterJenis == 'pemasukan')
             <tr>
                 <td class="summary-box">
                    <div class="summary-label">Total Transaksi</div>
                    <div class="summary-value">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
                </td>
                <td colspan="{{ ($filterJenis == 'semua') ? 2 : 1 }}" class="summary-box"> {{-- Sesuaikan colspan --}}
                    <div class="summary-label">Menu Terlaris (Qty)</div>
                    @forelse ($menuTerlaris as $item)
                        <div style="font-size: 11px;">{{ $item->menu->nama_menu }}: <strong>{{ $item->total_terjual }}</strong> porsi</div>
                    @empty
                        <div style="font-size: 11px;">N/A</div>
                    @endforelse
                </td>
            </tr>
            @endif
        </table>
    </div>

    {{-- Detail Pemasukan (jika perlu) --}}
    @if($filterJenis == 'semua' || $filterJenis == 'pemasukan')
    <h2>Detail Pemasukan (Transaksi Kasir)</h2>
    <table>
        <thead><tr><th class="col-waktu">Waktu</th><th class="col-detail">Detail Pesanan</th><th class="col-total">Total Harga</th></tr></thead>
        <tbody>
            @forelse ($daftarPemasukan as $pemasukan)
                <tr><td>{{ $pemasukan->created_at->format('d/m/y H:i') }}</td><td><ul>@foreach ($pemasukan->transaksiDetails as $detail)<li>{{ $detail->jumlah }}x {{ $detail->menu->nama_menu }}</li>@endforeach</ul></td><td style="text-align: right;">Rp {{ number_format($pemasukan->total_harga, 0, ',', '.') }}</td></tr>
            @empty
                <tr><td colspan="3" style="text-align: center;">Tidak ada pemasukan.</td></tr>
            @endforelse
        </tbody>
    </table>
    @endif

    {{-- Detail Pengeluaran (jika perlu) --}}
    @if($filterJenis == 'semua' || $filterJenis == 'pengeluaran')
    <h2>Detail Pengeluaran (Pembelian Stok)</h2>
    <table>
        <thead><tr><th class="col-tanggal">Tanggal</th><th class="col-deskripsi">Deskripsi</th><th class="col-jumlah">Jumlah</th></tr></thead>
        <tbody>
            @forelse ($daftarPengeluaran as $pengeluaran)
                <tr><td>{{ $pengeluaran->tanggal_pengeluaran->format('d/m/y') }}</td><td>{{ $pengeluaran->deskripsi }}</td><td style="text-align: right;">Rp {{ number_format($pengeluaran->jumlah_pengeluaran, 0, ',', '.') }}</td></tr>
            @empty
                 <tr><td colspan="3" style="text-align: center;">Tidak ada pengeluaran.</td></tr>
            @endforelse
        </tbody>
    </table>
    @endif

</body>
</html>