<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form action="{{ route('laporan.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai" :value="$inputTanggalMulai" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_akhir" :value="__('Tanggal Akhir')" />
                                <x-text-input id="tanggal_akhir" class="block mt-1 w-full" type="date" name="tanggal_akhir" :value="$inputTanggalAkhir" required />
                            </div>
                            <div class="self-end">
                                <x-primary-button type="submit">{{ __('Filter') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Total Omzet</h3>
                    <p class="text-3xl font-bold text-gray-800">
                        Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Total Transaksi</h3>
                    <p class="text-3xl font-bold text-gray-800">
                        {{ number_format($totalTransaksi, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Menu Terlaris</h3>
                    <div class="space-y-2">
                        @forelse ($menuTerlaris as $item)
                            <div class="flex justify-between text-sm">
                                <span class="font-medium">{{ $item->menu->nama_menu }}</span>
                                <span class="font-bold">{{ $item->total_terjual }} porsi</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Tidak ada data penjualan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Transaksi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dicatat Oleh</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Pesanan</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transaksis as $transaksi)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <ul class="list-disc list-inside">
                                                @foreach ($transaksi->transaksiDetails as $detail)
                                                    <li>{{ $detail->jumlah }}x {{ $detail->menu->nama_menu }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-medium">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada transaksi pada rentang tanggal ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $transaksis->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>