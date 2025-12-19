<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl leading-tight tracking-tight
                bg-gradient-to-r from-red-600 to-yellow-500 
                dark:from-red-400 dark:to-yellow-400 
                bg-clip-text text-transparent">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Tahun Global (Year-over-Year) -->
            <div class="mb-6 group relative overflow-hidden bg-gradient-to-r from-red-50 via-orange-50 to-yellow-50 dark:from-red-900/20 dark:via-orange-900/20 dark:to-yellow-900/20 shadow-xl rounded-2xl transition-all duration-500 border-2 border-red-200 dark:border-red-800">
                <div class="relative p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-yellow-500 rounded-xl blur-md opacity-50"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                                    Filter Tahun (Year-over-Year)
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">
                                    Bandingkan data antar tahun: {{ $selectedYear }} vs {{ $previousYear }}
                                </p>
                            </div>
                        </div>

                        <!-- Dropdown Filter Tahun -->
                        <form action="{{ route('dashboard') }}" method="GET" class="shrink-0">
                            <input type="hidden" name="filter_omzet" value="{{ $filterOmzet }}">
                            <input type="hidden" name="filter_grafik" value="{{ $filterGrafik }}">
                            <div class="relative">
                                <select name="filter_year"
                                        class="appearance-none bg-white dark:bg-gray-800 border-2 border-red-300 dark:border-red-700 text-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 rounded-xl shadow-lg text-base px-6 py-3 pr-12 font-bold cursor-pointer transition-all duration-300 hover:shadow-xl hover:scale-105"
                                        onchange="this.form.submit()">
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" @if($selectedYear == $year) selected @endif>
                                            📆 Tahun {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500"></div>
            </div>

            <!-- Premium Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

                <!-- Card 1: Stok Kritis -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-red-50 dark:from-gray-800 dark:to-red-900/20 shadow-xl hover:shadow-2xl rounded-2xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 border-2 border-red-100 dark:border-red-900/50">
                    <!-- Animated Background Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Decorative Corner -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-red-500/10 to-transparent rounded-bl-[3rem] transform group-hover:scale-110 transition-transform duration-500"></div>
                    
                    <!-- Card Content -->
                    <div class="relative p-6">
                        <!-- Header with Icon -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <!-- Animated Icon Container -->
                                <div class="relative">
                                    <div class="absolute inset-0 bg-red-500 rounded-xl blur-md opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                                    <div class="relative w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 group-hover:scale-110 transition-all duration-300">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                                        Stok Kritis
                                    </h3>
                                    <p class="text-xs text-red-600 dark:text-red-400 font-medium">Perlu Perhatian</p>
                                </div>
                            </div>

                            <!-- Badge Counter -->
                            <div class="relative">
                                <div class="absolute inset-0 bg-red-500 rounded-full blur-sm opacity-50 animate-pulse"></div>
                                <div class="relative px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    {{ count($stokKritis) }}
                                </div>
                            </div>
                        </div>

                        <!-- Content List with Enhanced Scrollbar -->
                        <div class="space-y-2.5 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse ($stokKritis as $bahan)
                                <div class="p-3 bg-white/50 dark:bg-gray-700/30 rounded-xl border border-red-100 dark:border-red-900/30 hover:border-red-300 dark:hover:border-red-700/50 transition-all duration-300 hover:shadow-md group/item">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse shadow-lg shadow-red-500/50 flex-shrink-0"></div>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300 text-xs leading-snug group-hover/item:text-red-600 dark:group-hover/item:text-red-400 transition-colors duration-200">
                                            {{ $bahan->nama_bahan }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <span class="inline-block text-red-600 dark:text-red-400 font-bold text-xs px-2.5 py-1 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                            Stok: {{ $bahan->stok_saat_ini }} {{ $bahan->satuan }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 space-y-3">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-xl animate-bounce">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium text-center">
                                        Semua stok aman! 👍
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Bottom Accent Line -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 via-red-600 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>

                <!-- Card 2: Prediksi Penjualan -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/20 shadow-xl hover:shadow-2xl rounded-2xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 border-2 border-blue-100 dark:border-blue-900/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-[3rem] transform group-hover:scale-110 transition-transform duration-500"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-blue-500 rounded-xl blur-md opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                                    <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 group-hover:scale-110 transition-all duration-300">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                                        Prediksi
                                    </h3>
                                    <p class="text-xs text-blue-600 dark:text-blue-400 font-medium"> Penjualan Hari Ini</p>
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-0 bg-blue-500 rounded-full blur-sm opacity-50 animate-pulse"></div>
                                <div class="relative px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    {{ count($prediksiHariIni) }}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2.5 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse ($prediksiHariIni as $prediksi)
                                <div class="p-3 bg-white/50 dark:bg-gray-700/30 rounded-xl border border-blue-100 dark:border-blue-900/30 hover:border-blue-300 dark:hover:border-blue-700/50 transition-all duration-300 hover:shadow-md group/item">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full shadow-lg shadow-blue-500/50 flex-shrink-0"></div>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300 text-xs leading-snug group-hover/item:text-blue-600 dark:group-hover/item:text-blue-400 transition-colors duration-200">
                                            {{ $prediksi->menu->nama_menu }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <span class="inline-block text-blue-600 dark:text-blue-400 font-bold text-xs px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                            Prediksi: ~{{ $prediksi->jumlah_prediksi }} porsi
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 space-y-3">
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center shadow-xl">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium text-center">
                                        Belum ada data prediksi
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>

                <!-- Card 3: Rekomendasi Pembelian -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-green-900/20 shadow-xl hover:shadow-2xl rounded-2xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 border-2 border-green-100 dark:border-green-900/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-500/10 to-transparent rounded-bl-[3rem] transform group-hover:scale-110 transition-transform duration-500"></div>
                    
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-green-500 rounded-xl blur-md opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                                    <div class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 group-hover:scale-110 transition-all duration-300">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                                        Rekomendasi
                                    </h3>
                                    <p class="text-xs text-green-600 dark:text-green-400 font-medium">Pembelian Bahan</p>
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-0 bg-green-500 rounded-full blur-sm opacity-50 animate-pulse"></div>
                                <div class="relative px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    {{ count($rekomendasiPemesanan) }}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2.5 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse ($rekomendasiPemesanan as $rekomendasi)
                                <div class="p-3 bg-white/50 dark:bg-gray-700/30 rounded-xl border border-green-100 dark:border-green-900/30 hover:border-green-300 dark:hover:border-green-700/50 transition-all duration-300 hover:shadow-md group/item">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full shadow-lg shadow-green-500/50 flex-shrink-0"></div>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300 text-xs leading-snug group-hover/item:text-green-600 dark:group-hover/item:text-green-400 transition-colors duration-200">
                                            {{ $rekomendasi['nama_bahan'] }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <span class="inline-block text-green-600 dark:text-green-400 font-bold text-xs px-2.5 py-1 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                            Beli: {{ $rekomendasi['rekomendasi_beli'] }} {{ $rekomendasi['satuan'] }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-8 space-y-3">
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center shadow-xl">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium text-center">
                                        Tidak ada rekomendasi
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 via-green-600 to-green-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>

                <!-- Card 4: Omzet (Animart Theme) with YoY Comparison -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-orange-50 dark:from-gray-800 dark:to-orange-900/20 shadow-xl hover:shadow-2xl rounded-2xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 border-2 border-orange-100 dark:border-orange-900/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 via-orange-500/5 to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yellow-500/10 to-transparent rounded-bl-[3rem] transform group-hover:scale-110 transition-transform duration-500"></div>
                    
                    <div class="relative p-6">
                        <!-- Enhanced Form -->
                        <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
                            <input type="hidden" name="filter_year" value="{{ $selectedYear }}">
                            <input type="hidden" name="filter_grafik" value="{{ $filterGrafik }}">
                            <div class="relative">
                                <select name="filter_omzet"
                                        class="w-full appearance-none bg-gradient-to-r from-red-50 to-yellow-50 dark:from-red-900/20 dark:to-yellow-900/20 border-2 border-red-200 dark:border-red-800 text-gray-700 dark:text-gray-700 focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 rounded-xl shadow-lg text-sm px-4 py-3 pr-10 font-semibold cursor-pointer transition-all duration-300 hover:shadow-xl"
                                        onchange="this.form.submit()">
                                    <option value="harian" @if($filterOmzet == 'harian') selected @endif>📅 Omzet Hari Ini</option>
                                    <option value="mingguan" @if($filterOmzet == 'mingguan') selected @endif>📊 Omzet Minggu Ini</option>
                                    <option value="bulanan" @if($filterOmzet == 'bulanan') selected @endif>📈 Omzet Bulan Ini</option>
                                </select>
                                <!-- Custom Arrow -->
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </form>

                        <!-- Title with Animation -->
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-yellow-500 rounded-lg blur-md opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                                <div class="relative w-10 h-10 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-all duration-300">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ $judulOmzet }}
                            </h3>
                        </div>

                        <!-- Omzet Value with Enhanced Styling -->
                        <div class="relative mt-4">
                            <!-- Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-yellow-500 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                            
                            <!-- Value Container -->
                            <div class="relative p-6 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-2xl shadow-2xl transform group-hover:scale-105 transition-all duration-300">
                                <div class="text-center">
                                    <p class="text-sm font-bold text-white/80 mb-1 tracking-wide">TOTAL OMZET {{ $selectedYear }}</p>
                                    <p class="text-3xl lg:text-2xl font-extrabold text-white drop-shadow-lg tracking-tight">
                                        Rp {{ number_format($omzetWidget, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Decorative Elements -->
                                <div class="absolute top-2 right-2 w-20 h-20 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="absolute bottom-2 left-2 w-16 h-16 bg-yellow-300/20 rounded-full blur-xl"></div>
                            </div>
                        </div>

                        <!-- YoY Comparison -->
                        <div class="mt-4 p-4 bg-white/50 dark:bg-gray-700/30 rounded-xl border-2 border-orange-200 dark:border-orange-800">
                            <div class="text-center">
                                <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold mb-2">
                                    Perbandingan dengan {{ $previousYear }}
                                </p>
                                <div class="flex items-center justify-center space-x-2">
                                    @if($omzetChangePercentage > 0)
                                        <div class="flex items-center space-x-1 text-green-600 dark:text-green-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                            <span class="text-lg font-bold">{{ number_format($omzetChangePercentage, 2) }}%</span>
                                        </div>
                                    @elseif($omzetChangePercentage < 0)
                                        <div class="flex items-center space-x-1 text-red-600 dark:text-red-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                            <span class="text-lg font-bold">{{ number_format(abs($omzetChangePercentage), 2) }}%</span>
                                        </div>
                                    @else
                                        <div class="flex items-center space-x-1 text-gray-600 dark:text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 12h14" />
                                            </svg>
                                            <span class="text-lg font-bold">0%</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                    {{ $previousYear }}: Rp {{ number_format($omzetPreviousYear, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>

            </div>

            <!-- Premium Chart Section -->
            <div class="mt-6 sm:mt-8 group relative overflow-hidden bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-2xl rounded-2xl transition-all duration-500 border-2 border-gray-100 dark:border-gray-700">
                <!-- Animated Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 via-orange-500/5 to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                
                <!-- Decorative Corners -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-br-[3rem]"></div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-tl from-yellow-500/10 to-transparent rounded-tl-[3rem]"></div>

                <div class="relative p-6 sm:p-8">
                    <!-- Chart Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                        <div class="flex items-center space-x-4">
                            <!-- Icon -->
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-yellow-500 rounded-xl blur-md opacity-50"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                                    Grafik Tren Omzet
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">
                                    Analisis performa penjualan
                                </p>
                            </div>
                        </div>

                        <!-- Enhanced Filter Form -->
                        <form action="{{ route('dashboard') }}" method="GET" class="shrink-0">
                            <input type="hidden" name="filter_year" value="{{ $selectedYear }}">
                            <input type="hidden" name="filter_omzet" value="{{ $filterOmzet }}">
                            <div class="relative">
                                <select name="filter_grafik"
                                        class="appearance-none bg-gradient-to-r from-red-50 to-yellow-50 dark:from-red-900/20 dark:to-yellow-900/20 border-2 border-red-200 dark:border-red-800 text-gray-700 dark:text-gray-700 focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 rounded-xl shadow-lg text-sm px-6 py-3 pr-12 font-semibold cursor-pointer transition-all duration-300 hover:shadow-xl hover:scale-105"
                                        onchange="this.form.submit()">
                                    <option value="harian" @if($filterGrafik == 'harian') selected @endif>📅 7 Hari Terakhir</option>
                                    <option value="mingguan" @if($filterGrafik == 'mingguan') selected @endif>📊 4 Minggu Terakhir</option>
                                    <option value="bulanan" @if($filterGrafik == 'bulanan') selected @endif>📈 12 Bulan {{ $selectedYear }}</option>
                                </select>
                                <!-- Custom Arrow -->
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Chart Container with Premium Styling -->
                    <div class="relative">
                        <!-- Chart Background Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-inner border border-gray-100 dark:border-gray-700">
                            <canvas id="salesChart" class="w-full" style="max-height: 400px;"></canvas>
                        </div>

                        <!-- Decorative Grid Overlay -->
                        <div class="absolute inset-0 pointer-events-none opacity-[0.02] dark:opacity-[0.03]">
                            <div class="w-full h-full" style="background-image: repeating-linear-gradient(0deg, #ef4444 0px, #ef4444 1px, transparent 1px, transparent 20px), repeating-linear-gradient(90deg, #ef4444 0px, #ef4444 1px, transparent 1px, transparent 20px);"></div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Accent -->
                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500"></div>
            </div>

            <!-- Widget Statistik YoY Lengkap -->
            <div class="mt-6 sm:mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                
                <!-- Total Transaksi YoY -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/20 shadow-xl hover:shadow-2xl rounded-2xl transition-all duration-500 hover:scale-[1.02] border-2 border-blue-100 dark:border-blue-900/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Total Transaksi</h3>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Tahun {{ $selectedYear }}</p>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ number_format($yoyStats['totalTransaksiCurrent']) }} transaksi
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl">
                                <span class="text-xs text-gray-600 dark:text-gray-400">vs {{ $previousYear }}</span>
                                @if($yoyStats['transaksiChange'] > 0)
                                    <div class="flex items-center space-x-1 text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                        <span class="text-sm font-bold">{{ number_format($yoyStats['transaksiChange'], 2) }}%</span>
                                    </div>
                                @elseif($yoyStats['transaksiChange'] < 0)
                                    <div class="flex items-center space-x-1 text-red-600 dark:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                        <span class="text-sm font-bold">{{ number_format(abs($yoyStats['transaksiChange']), 2) }}%</span>
                                    </div>
                                @else
                                    <span class="text-sm font-bold text-gray-600 dark:text-gray-400">0%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>

                <!-- Rata-rata Transaksi per Bulan -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-purple-50 dark:from-gray-800 dark:to-purple-900/20 shadow-xl hover:shadow-2xl rounded-2xl transition-all duration-500 hover:scale-[1.02] border-2 border-purple-100 dark:border-purple-900/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Avg per Bulan</h3>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Tahun {{ $selectedYear }}</p>
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                    {{ number_format($yoyStats['avgTransaksiCurrent'], 0) }} /bulan
                                </p>
                            </div>
                            
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl text-center">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $previousYear }}</p>
                                <p class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ number_format($yoyStats['avgTransaksiPrevious'], 0) }} /bulan
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>

                <!-- Total Omzet Tahunan YoY -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-green-900/20 shadow-xl hover:shadow-2xl rounded-2xl transition-all duration-500 hover:scale-[1.02] border-2 border-green-100 dark:border-green-900/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Omzet Tahunan</h3>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Tahun {{ $selectedYear }}</p>
                                <p class="text-xl font-bold text-green-600 dark:text-green-400">
                                    Rp {{ number_format($yoyStats['omzetTahunanCurrent'], 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl">
                                <span class="text-xs text-gray-600 dark:text-gray-400">vs {{ $previousYear }}</span>
                                @if($yoyStats['omzetChange'] > 0)
                                    <div class="flex items-center space-x-1 text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                        <span class="text-sm font-bold">{{ number_format($yoyStats['omzetChange'], 2) }}%</span>
                                    </div>
                                @elseif($yoyStats['omzetChange'] < 0)
                                    <div class="flex items-center space-x-1 text-red-600 dark:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                        <span class="text-sm font-bold">{{ number_format(abs($yoyStats['omzetChange']), 2) }}%</span>
                                    </div>
                                @else
                                    <span class="text-sm font-bold text-gray-600 dark:text-gray-400">0%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 to-emerald-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>

            </div>

        </div>
    </div>

    <!-- Enhanced Chart.js with Animart Theme and YoY Comparison -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart');
            
            // Check if dark mode is active
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            // Animart color palette for current year
            const animartGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            animartGradient.addColorStop(0, 'rgba(239, 68, 68, 0.8)');    // Red
            animartGradient.addColorStop(0.5, 'rgba(249, 115, 22, 0.6)'); // Orange
            animartGradient.addColorStop(1, 'rgba(245, 158, 11, 0.4)');   // Yellow

            const animartGradientArea = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            animartGradientArea.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
            animartGradientArea.addColorStop(0.5, 'rgba(249, 115, 22, 0.2)');
            animartGradientArea.addColorStop(1, 'rgba(245, 158, 11, 0.05)');

            // Previous year gradient (blue-gray)
            const prevYearGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            prevYearGradient.addColorStop(0, 'rgba(59, 130, 246, 0.6)');
            prevYearGradient.addColorStop(1, 'rgba(156, 163, 175, 0.3)');

            const prevYearGradientArea = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            prevYearGradientArea.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
            prevYearGradientArea.addColorStop(1, 'rgba(156, 163, 175, 0.05)');

            // Parse data
            const chartDataPreviousYear = {!! $chartDataPreviousYear !!};
            const selectedYear = {{ $selectedYear }};
            const previousYear = {{ $previousYear }};
            
            // Create datasets array
            const datasets = [
                {
                    label: 'Omzet ' + selectedYear + ' (Rp)',
                    data: {!! $chartData !!},
                    fill: true,
                    backgroundColor: animartGradientArea,
                    borderColor: animartGradient,
                    borderWidth: 4,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#dc2626',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 4,
                }
            ];

            // Add previous year data if available
            if (chartDataPreviousYear && chartDataPreviousYear.length > 0) {
                datasets.push({
                    label: 'Omzet ' + previousYear + ' (Rp)',
                    data: chartDataPreviousYear,
                    fill: true,
                    backgroundColor: prevYearGradientArea,
                    borderColor: prevYearGradient,
                    borderWidth: 3,
                    borderDash: [5, 5],
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#2563eb',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 3,
                });
            }
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $chartLabels !!},
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: isDarkMode ? '#dadbddff' : '#0e0e0fff',
                                font: {
                                    size: 14,
                                    weight: 'bold',
                                    family: "'Figtree', sans-serif"
                                },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            }
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: isDarkMode ? 'rgba(17, 24, 39, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                            titleColor: isDarkMode ? '#fbbf24' : '#ef4444',
                            bodyColor: isDarkMode ? '#e5e7eb' : '#374151',
                            borderColor: '#ef4444',
                            borderWidth: 2,
                            padding: 16,
                            displayColors: true,
                            boxPadding: 8,
                            cornerRadius: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13,
                                weight: '600'
                            },
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                },
                                afterBody: function(tooltipItems) {
                                    if (tooltipItems.length === 2 && chartDataPreviousYear && chartDataPreviousYear.length > 0) {
                                        const current = tooltipItems[0].parsed.y;
                                        const previous = tooltipItems[1].parsed.y;
                                        const diff = current - previous;
                                        const percentage = previous > 0 ? ((diff / previous) * 100).toFixed(2) : 0;
                                        const symbol = diff > 0 ? '↑' : diff < 0 ? '↓' : '=';
                                        return '\nPerubahan: ' + symbol + ' ' + percentage + '%\n(Rp ' + Math.abs(diff).toLocaleString('id-ID') + ')';
                                    }
                                    return '';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: isDarkMode ? 'rgba(55, 65, 81, 0.3)' : 'rgba(229, 231, 235, 0.8)',
                                lineWidth: 1,
                            },
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280',
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                padding: 12,
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            border: {
                                color: isDarkMode ? '#374151' : '#e5e7eb',
                                width: 2
                            }
                        },
                        x: {
                            grid: {
                                color: isDarkMode ? 'rgba(55, 65, 81, 0.2)' : 'rgba(229, 231, 235, 0.5)',
                                lineWidth: 1,
                            },
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280',
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                padding: 12
                            },
                            border: {
                                color: isDarkMode ? '#374151' : '#e5e7eb',
                                width: 2
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        });
    </script>

    <!-- Custom Scrollbar Styles -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
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

        /* Smooth transitions for all interactive elements */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced select dropdown styling */
        select {
            background-image: none;
        }

        /* Prevent layout shift on hover */
        .group:hover {
            backface-visibility: hidden;
            transform: translateZ(0);
        }
    </style>

</x-app-layout>