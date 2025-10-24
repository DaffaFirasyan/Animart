<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuangan (Pemasukan & Pengeluaran)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan Keuangan</h3>
                    <form action="{{ route('laporan-keuangan.index') }}" method="GET">
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-green-600">Total Pemasukan</h3>
                    <p class="text-3xl font-bold text-gray-800">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-red-600">Total Pengeluaran</h3>
                    <p class="text-3xl font-bold text-gray-800">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 {{ $labaRugi >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                        {{ $labaRugi >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                    </h3>
                    <p class="text-3xl font-bold {{ $labaRugi >= 0 ? 'text-gray-800' : 'text-red-600' }}">
                        Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Pemasukan (Transaksi Kasir)</h3>
                        <div class="overflow-x-auto max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200 border text-sm">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                        <th scope="col" class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($daftarPemasukan as $pemasukan)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $pemasukan->created_at->format('d/m/y H:i') }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-right font-medium">Rp {{ number_format($pemasukan->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="px-4 py-2 text-center text-gray-500">Tidak ada pemasukan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Pengeluaran (Pembelian Stok)</h3>
                         <div class="overflow-x-auto max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200 border text-sm">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                        <th scope="col" class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($daftarPengeluaran as $pengeluaran)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $pengeluaran->tanggal_pengeluaran->format('d/m/y') }}</td>
                                            <td class="px-4 py-2 whitespace-normal">{{ $pengeluaran->deskripsi }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-right font-medium">Rp {{ number_format($pengeluaran->jumlah_pengeluaran, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                         <tr><td colspan="3" class="px-4 py-2 text-center text-gray-500">Tidak ada pengeluaran.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>