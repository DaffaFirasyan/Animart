<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 text-red-600">
                        ⚠️ Stok Kritis
                    </h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @forelse ($stokKritis as $bahan)
                            <div class="flex justify-between text-sm">
                                <span class="font-medium">{{ $bahan->nama_bahan }}</span>
                                <span class="text-red-600 font-bold">{{ $bahan->stok_saat_ini }} {{ $bahan->satuan }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">👍 Semua stok aman.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 text-blue-600">
                        📊 Prediksi Penjualan Hari Ini
                    </h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @forelse ($prediksiHariIni as $prediksi)
                            <div class="flex justify-between text-sm">
                                <span class="font-medium">{{ $prediksi->menu->nama_menu }}</span>
                                <span class="text-blue-600 font-bold">~{{ $prediksi->jumlah_prediksi }} porsi</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data prediksi.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 text-green-600">
                        🛒 Rekomendasi Pembelian Bahan Baku
                    </h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @forelse ($rekomendasiPemesanan as $rekomendasi)
                            <div class="flex justify-between text-sm">
                                <span class="font-medium">{{ $rekomendasi['nama_bahan'] }}</span>
                                <span class="text-green-600 font-bold">Beli {{ $rekomendasi['rekomendasi_beli'] }} {{ $rekomendasi['satuan'] }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Tidak ada rekomendasi pembelian.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form action="{{ route('dashboard') }}" method="GET" class="mb-2">
                        <select name="filter_omzet" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm p-2" 
                                onchange="this.form.submit()">
                            
                            <option value="harian" @if($filterOmzet == 'harian') selected @endif>Omzet Hari Ini</option>
                            <option value="mingguan" @if($filterOmzet == 'mingguan') selected @endif>Omzet Minggu Ini</option>
                            <option value="bulanan" @if($filterOmzet == 'bulanan') selected @endif>Omzet Bulan Ini</option>

                        </select>
                    </form>
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-2 mt-2">
                        {{ $judulOmzet }}
                    </h3>
                    
                    <p class="text-3xl font-bold text-gray-800">
                        Rp {{ number_format($omzetWidget, 0, ',', '.') }}
                    </p>
                </div>
            </div> <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Grafik Tren Omzet
                    </h3>
                    
                    <form action="{{ route('dashboard') }}" method="GET">
                        <select name="filter_grafik" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm p-2" 
                                onchange="this.form.submit()">
                            <option value="harian" @if($filterGrafik == 'harian') selected @endif>7 Hari Terakhir</option>
                            <option value="mingguan" @if($filterGrafik == 'mingguan') selected @endif>4 Minggu Terakhir</option>
                            <option value="bulanan" @if($filterGrafik == 'bulanan') selected @endif>6 Bulan Terakhir</option>
                        </select>
                    </form>
                </div>

                <div>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $chartLabels !!}, // Data dari Controller
                    datasets: [{
                        label: 'Omzet (Rp)',
                        data: {!! $chartData !!}, // Data dari Controller
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

</x-app-layout>