<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl leading-tight tracking-tight
                bg-gradient-to-r from-red-600 to-yellow-500 
                dark:from-red-400 dark:to-yellow-400 
                bg-clip-text text-transparent">
            {{ __('Laporan Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Enhanced Filter Section -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-white to-orange-50 dark:from-gray-800 dark:to-orange-900/10 shadow-2xl rounded-2xl border-2 border-orange-100 dark:border-orange-900/30">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                
                <div class="relative p-6 sm:p-8">
                    <!-- Header with Icon -->
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-yellow-500 rounded-xl blur-md opacity-50"></div>
                            <div class="relative w-12 h-12 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Filter Laporan</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Pilih rentang waktu dan jenis laporan</p>
                        </div>
                    </div>

                    <form action="{{ route('laporan.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                            <!-- Tanggal Mulai -->
                            <div class="space-y-2">
                                <label for="tanggal_mulai" class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                                    📅 Tanggal Mulai
                                </label>
                                <input id="tanggal_mulai" 
                                       type="date" 
                                       name="tanggal_mulai" 
                                       value="{{ $inputTanggalMulai }}" 
                                       required
                                       class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg" />
                            </div>

                            <!-- Tanggal Akhir -->
                            <div class="space-y-2">
                                <label for="tanggal_akhir" class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                                    📅 Tanggal Akhir
                                </label>
                                <input id="tanggal_akhir" 
                                       type="date" 
                                       name="tanggal_akhir" 
                                       value="{{ $inputTanggalAkhir }}" 
                                       required
                                       class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg" />
                            </div>

                            <!-- Jenis Laporan -->
                            <div class="space-y-2">
                                <label for="filter_jenis" class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                                    📊 Jenis Laporan
                                </label>
                                <select name="filter_jenis" 
                                        id="filter_jenis" 
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg cursor-pointer">
                                    <option value="semua" @if($filterJenisAktif == 'semua') selected @endif>Pemasukan & Pengeluaran</option>
                                    <option value="pemasukan" @if($filterJenisAktif == 'pemasukan') selected @endif>Pemasukan</option>
                                    <option value="pengeluaran" @if($filterJenisAktif == 'pengeluaran') selected @endif>Pengeluaran</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-2">
                                <button type="submit" 
                                        class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    <span>Filter</span>
                                </button>
                                
                                <button type="submit"
                                        formaction="{{ route('laporan.pdf') }}"
                                        formmethod="GET"
                                        formtarget="_blank"
                                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>PDF</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card Total Pemasukan -->
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 shadow-xl hover:shadow-2xl rounded-2xl border-2 border-green-200 dark:border-green-800 transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-400/20 to-transparent rounded-bl-full"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-green-500 rounded-xl blur-md opacity-50 group-hover:opacity-70"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-md">
                                INCOME
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-green-700 dark:text-green-400 mb-2">Total Pemasukan</h3>
                        <p class="text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                            Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Card Total Pengeluaran -->
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pengeluaran')
                <div class="group relative overflow-hidden bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 shadow-xl hover:shadow-2xl rounded-2xl border-2 border-red-200 dark:border-red-800 transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-orange-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-red-400/20 to-transparent rounded-bl-full"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-red-500 rounded-xl blur-md opacity-50 group-hover:opacity-70"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-md">
                                EXPENSE
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-red-700 dark:text-red-400 mb-2">Total Pengeluaran</h3>
                        <p class="text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Card Laba / Rugi -->
                @if($filterJenisAktif == 'semua')
                <div class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 shadow-xl hover:shadow-2xl rounded-2xl border-2 border-blue-200 dark:border-blue-800 transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-400/20 to-transparent rounded-bl-full"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-500 rounded-xl blur-md opacity-50 group-hover:opacity-70"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-500 to-{{ $labaRugi >= 0 ? 'cyan' : 'orange' }}-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="px-3 py-1 bg-{{ $labaRugi >= 0 ? 'blue' : 'red' }}-500 text-white text-xs font-bold rounded-full shadow-md">
                                {{ $labaRugi >= 0 ? 'PROFIT' : 'LOSS' }}
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold {{ $labaRugi >= 0 ? 'text-blue-700 dark:text-blue-400' : 'text-red-700 dark:text-red-400' }} mb-2">
                            {{ $labaRugi >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                        </h3>
                        <p class="text-3xl lg:text-4xl font-extrabold {{ $labaRugi >= 0 ? 'text-gray-900 dark:text-gray-100' : 'text-red-600 dark:text-red-400' }} tracking-tight">
                            Rp {{ number_format(abs($labaRugi ?? 0), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Card Total Transaksi -->
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="group relative overflow-hidden bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 shadow-xl hover:shadow-2xl rounded-2xl border-2 border-purple-200 dark:border-purple-800 transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-transparent rounded-bl-full"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-purple-500 rounded-xl blur-md opacity-50 group-hover:opacity-70"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </div>
                            </div>
                            <div class="px-3 py-1 bg-purple-500 text-white text-xs font-bold rounded-full shadow-md">
                                COUNT
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-purple-700 dark:text-purple-400 mb-2">Total Transaksi</h3>
                        <p class="text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                            {{ number_format($totalTransaksi, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Card Menu Terlaris -->
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="group relative overflow-hidden bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 shadow-xl hover:shadow-2xl rounded-2xl border-2 border-yellow-200 dark:border-yellow-800 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yellow-400/20 to-transparent rounded-bl-full"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-yellow-500 rounded-xl blur-md opacity-50"></div>
                                <div class="relative w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">Menu Terlaris (Qty)</h3>
                        </div>
                        
                        <div class="space-y-2.5 max-h-48 overflow-y-auto custom-scrollbar pr-2">
                            @forelse ($menuTerlaris as $index => $item)
                                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-yellow-500 dark:hover:border-yellow-500 transition-all duration-300 hover:shadow-md group/item">
                                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg flex items-center justify-center font-bold text-white shadow-md">
                                            {{ $index + 1 }}
                                        </div>
                                        <span class="font-bold text-gray-900 dark:text-gray-100 text-sm truncate group-hover/item:text-yellow-600 dark:group-hover/item:text-yellow-400 transition-colors">
                                            {{ $item->menu->nama_menu }}
                                        </span>
                                    </div>
                                    <span class="flex-shrink-0 px-3 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-md ml-2">
                                        {{ $item->total_terjual }} porsi
                                    </span>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 space-y-2">
                                    <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">N/A</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

                <!-- Card Pendapatan per Menu -->
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 shadow-xl hover:shadow-2xl rounded-2xl border-2 border-indigo-200 dark:border-indigo-800 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-400/20 to-transparent rounded-bl-full"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-indigo-500 rounded-xl blur-md opacity-50"></div>
                                <div class="relative w-12 h-12 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">Pendapatan per Menu (Rp)</h3>
                        </div>
                        
                        <div class="space-y-2.5 max-h-48 overflow-y-auto custom-scrollbar pr-2">
                            @forelse ($pendapatanPerMenu as $index => $item)
                                <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all duration-300 hover:shadow-md group/item">
                                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-400 to-blue-400 rounded-lg flex items-center justify-center font-bold text-white shadow-md">
                                            {{ $index + 1 }}
                                        </div>
                                        <span class="font-bold text-gray-900 dark:text-gray-100 text-sm truncate group-hover/item:text-indigo-600 dark:group-hover/item:text-indigo-400 transition-colors">
                                            {{ $item->menu->nama_menu }}
                                        </span>
                                    </div>
                                    <span class="flex-shrink-0 px-3 py-1 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-bold rounded-full shadow-md ml-2 whitespace-nowrap">
                                        Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}
                                    </span>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 space-y-2">
                                    <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">N/A</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 gap-6">

                <!-- Detail Pemasukan Table -->
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pemasukan')
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-green-900/10 shadow-2xl rounded-2xl border-2 border-green-100 dark:border-green-900/30">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="relative">
                                <div class="absolute inset-0 bg-green-500 rounded-xl blur-md opacity-50"></div>
                                <div class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">Riwayat Pemasukan</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Transaksi Kasir</p>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto rounded-xl border-2 border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gradient-to-r from-green-500 to-emerald-500">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Waktu</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Kasir</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Detail</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-bold text-white uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($daftarPemasukan as $pemasukan)
                                    <tr class="hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors duration-200">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $pemasukan->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $pemasukan->user->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <ul class="space-y-1">
                                                @foreach ($pemasukan->transaksiDetails as $detail)
                                                <li class="flex items-center space-x-2">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $detail->jumlah }}x {{ $detail->menu->nama_menu }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-bold text-green-600 dark:text-green-400">
                                            Rp {{ number_format($pemasukan->total_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center space-y-3">
                                                <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                    </svg>
                                                </div>
                                                <p class="text-gray-500 dark:text-gray-400 font-semibold">Tidak ada transaksi pada rentang tanggal ini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if ($daftarPemasukan instanceof \Illuminate\Pagination\LengthAwarePaginator && $daftarPemasukan->hasPages())
                        <div class="mt-4 flex items-center justify-center">
                            <div class="flex gap-1">
                                @foreach ($daftarPemasukan->getUrlRange(1, $daftarPemasukan->lastPage()) as $page => $url)
                                    @if ($page == $daftarPemasukan->currentPage())
                                        <span class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-green-500 hover:text-white text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Detail Pengeluaran Table -->
                @if($filterJenisAktif == 'semua' || $filterJenisAktif == 'pengeluaran')
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-red-50 dark:from-gray-800 dark:to-red-900/10 shadow-2xl rounded-2xl border-2 border-red-100 dark:border-red-900/30">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="relative">
                                <div class="absolute inset-0 bg-red-500 rounded-xl blur-md opacity-50"></div>
                                <div class="relative w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-extrabold text-gray-900 dark:text-gray-100">Detail Pengeluaran</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Pembelian Stok</p>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto max-h-[450px] overflow-y-auto rounded-xl border-2 border-gray-200 dark:border-gray-700 custom-scrollbar">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gradient-to-r from-red-500 to-orange-500 sticky top-0 z-10">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Deskripsi</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-bold text-white uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($daftarPengeluaran as $pengeluaran)
                                    <tr class="hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors duration-200">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $pengeluaran->tanggal_pengeluaran->format('d/m/y') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $pengeluaran->deskripsi }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-bold text-red-600 dark:text-red-400">
                                            Rp {{ number_format($pengeluaran->jumlah_pengeluaran, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center space-y-3">
                                                <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                    </svg>
                                                </div>
                                                <p class="text-gray-500 dark:text-gray-400 font-semibold">Tidak ada pengeluaran.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #ef4444, #f97316, #f59e0b);
            border-radius: 10px;
            box-shadow: 0 0 6px rgba(239, 68, 68, 0.5);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #dc2626, #ea580c, #d97706);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.7);
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #dc2626, #ea580c, #d97706);
        }
    </style>
</x-app-layout>