<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        h1 { font-size: 20px; text-align: center; }
        h2 { font-size: 16px; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
        .summary { margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <div class="summary">
        <p><strong>Periode:</strong> {{ $inputTanggalMulai }} s/d {{ $inputTanggalAkhir }}</p>
        <p><strong>Total Omzet:</strong> Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
        <p><strong>Total Transaksi:</strong> {{ $totalTransaksi }}</p>
    </div>

    <h2>Ringkasan Menu Terlaris (Qty)</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Total Terjual</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($menuTerlaris as $item)
                <tr>
                    <td>{{ $item->menu->nama_menu }}</td>
                    <td>{{ $item->total_terjual }} porsi</td>
                </tr>
            @empty
                <tr><td colspan="2">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
    
    <h2>Riwayat Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Detail Pesanan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->created_at->format('d/m/y H:i') }}</td>
                    <td>
                        <ul>
                        @foreach ($transaksi->transaksiDetails as $detail)
                            <li>{{ $detail->jumlah }}x {{ $detail->menu->nama_menu }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>