<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Bisnis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form action="{{ route('laporan.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai" :value="$inputTanggalMulai" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_akhir" :value="__('Tanggal Akhir')" />
                                <x-text-input id="tanggal_akhir" class="block mt-1 w-full" type="date" name="tanggal_akhir" :value="$inputTanggalAkhir" required />
                            </div>
                            <div>
                                <x-input-label for="filter_jenis" :value="__('Jenis Laporan')" />
                                <select name="filter_jenis" id="filter_jenis" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="semua" @if($filterJenisAktif == 'semua') selected @endif>Pemasukan & Pengeluaran</option>
                                    <option value="pemasukan" @if($filterJenisAktif == 'pemasukan') selected @endif>Pemasukan</option>
                                    <option value="pengeluaran" @if($filterJenisAktif == 'pengeluaran') selected @endif>Pengeluaran</option>
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <x-primary-button type="submit">{{ __('Filter') }}</x-primary-button>
                                <x-secondary-button type="submit"
                                                    formaction="{{ route('laporan.pdf') }}"
                                                    formmethod="GET"
                                                    formtarget="_blank">
                                    Download PDF
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Card Total Pemasukan --}}
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-green-600">Total Pemasukan</h3>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                @endif

                {{-- Card Total Pengeluaran --}}
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pengeluaran')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-red-600">Total Pengeluaran</h3>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
                @endif

                {{-- Card Laba / Rugi --}}
                @if($filterJenisAktif == 'semua') {{-- Hanya tampil jika 'semua' --}}
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 {{ $labaRugi >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                        {{ $labaRugi >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                    </h3>
                    <p class="text-3xl font-bold {{ $labaRugi >= 0 ? 'text-gray-800' : 'text-red-600' }}">
                        Rp {{ number_format(abs($labaRugi ?? 0), 0, ',', '.') }}
                    </p>
                </div>
                @endif

                {{-- Card Total Transaksi --}}
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Total Transaksi</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
                </div>
                @endif

                {{-- Card Menu Terlaris (Qty) --}}
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Menu Terlaris (Qty)</h3>
                    <div class="space-y-2">
                        @forelse ($menuTerlaris as $item)
                            <div class="flex justify-between text-sm"><span class="font-medium">{{ $item->menu->nama_menu }}</span><span class="font-bold">{{ $item->total_terjual }} porsi</span></div>
                        @empty
                            <p class="text-sm text-gray-500">N/A</p>
                        @endforelse
                    </div>
                </div>
                @endif

                {{-- Card Pendapatan per Menu (Rp) --}}
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pendapatan per Menu (Rp)</h3>
                    <div class="space-y-2">
                        @forelse ($pendapatanPerMenu as $item)
                            <div class="flex justify-between text-sm"><span class="font-medium">{{ $item->menu->nama_menu }}</span><span class="font-bold">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</span></div>
                        @empty
                            <p class="text-sm text-gray-500">N/A</p>
                        @endforelse
                    </div>
                </div>
                @endif

            </div> <div class="grid grid-cols-1 {{ ($filterJenisAktif == 'semua') ? 'lg:grid-cols-2' : '' }} gap-6">

                {{-- Detail Pemasukan (Transaksi Kasir) --}}
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Pemasukan (Transaksi Kasir)</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border"><thead class="bg-gray-50"><tr><th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Transaksi</th><th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dicatat Oleh</th><th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Pesanan</th><th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th></tr></thead><tbody class="bg-white divide-y divide-gray-200">@forelse ($daftarPemasukan as $pemasukan)<tr><td class="px-6 py-4 whitespace-nowrap">{{ $pemasukan->created_at->format('d M Y, H:i') }}</td><td class="px-6 py-4 whitespace-nowrap">{{ $pemasukan->user->name }}</td><td class="px-6 py-4 whitespace-nowrap"><ul class="list-disc list-inside">@foreach ($pemasukan->transaksiDetails as $detail)<li>{{ $detail->jumlah }}x {{ $detail->menu->nama_menu }}</li>@endforeach</ul></td><td class="px-6 py-4 whitespace-nowrap text-right font-medium">Rp {{ number_format($pemasukan->total_harga, 0, ',', '.') }}</td></tr>@empty<tr><td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Tidak ada transaksi pada rentang tanggal ini.</td></tr>@endforelse</tbody></table>
                        </div>
                        @if ($daftarPemasukan instanceof \Illuminate\Pagination\LengthAwarePaginator)
                         {{-- Hanya tampilkan pagination jika pemasukan ditampilkan & berupa Paginator --}}
                        <div class="mt-4">
                           {{ $daftarPemasukan->links() }}
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Detail Pengeluaran (Pembelian Stok) --}}
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pengeluaran')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Pengeluaran (Pembelian Stok)</h3>
                            <div class="overflow-x-auto max-h-[450px] overflow-y-auto"> <table class="min-w-full divide-y divide-gray-200 border text-sm"><thead class="bg-gray-50 sticky top-0"><tr><th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl</th><th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th><th scope="col" class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th></tr></thead><tbody class="bg-white divide-y divide-gray-200">@forelse ($daftarPengeluaran as $pengeluaran)<tr><td class="px-4 py-2 whitespace-nowrap">{{ $pengeluaran->tanggal_pengeluaran->format('d/m/y') }}</td><td class="px-4 py-2 whitespace-normal">{{ $pengeluaran->deskripsi }}</td><td class="px-4 py-2 whitespace-nowrap text-right font-medium">Rp {{ number_format($pengeluaran->jumlah_pengeluaran, 0, ',', '.') }}</td></tr>@empty<tr><td colspan="3" class="px-4 py-2 text-center text-gray-500">Tidak ada pengeluaran.</td></tr>@endforelse</tbody></table>
                            </div>
                        </div>
                    </div>
                 @endif

            </div> </div>
    </div>
</x-app-layout>