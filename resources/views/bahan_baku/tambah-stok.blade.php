<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>

            <div class="flex items-baseline space-x-3">
                <h2 class="font-bold text-3xl sm:text-4xl bg-gradient-to-r from-green-600 via-emerald-600 to-green-600 dark:from-green-400 dark:via-emerald-400 dark:to-green-400 bg-clip-text text-transparent leading-tight tracking-tight drop-shadow-[0_2px_8px_rgba(34,197,94,0.3)] dark:drop-shadow-[0_2px_12px_rgba(34,197,94,0.5)]">
                    {{ __('Tambah Stok') }}
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">{{ $bahanBaku->nama_bahan }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="group relative overflow-hidden bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-green-900/10 shadow-2xl rounded-2xl border-2 border-green-100 dark:border-green-900/30">
                
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-bl-[5rem] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-gradient-to-tr from-green-500/10 to-transparent rounded-tr-[5rem] pointer-events-none"></div>
                
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 via-emerald-500 to-green-500"></div>
                </div>

                <div class="relative p-6 sm:p-8">
                    
                    <!-- Form Header -->
                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 via-emerald-500 to-green-500 rounded-xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Tambah Stok Bahan</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Input pembelian stok baru</p>
                        </div>
                        <div class="hidden sm:block px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold rounded-full shadow-lg">
                            + STOCK
                        </div>
                    </div>

                    <!-- Current Stock Display (Prominent) -->
                    <div class="mb-6 relative overflow-hidden bg-gradient-to-br from-blue-500 via-cyan-500 to-blue-500 rounded-2xl p-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-shimmer"></div>
                        
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <p class="text-white/80 text-sm font-bold mb-1 uppercase tracking-wide">Stok Saat Ini</p>
                                <p class="text-white font-extrabold text-4xl sm:text-5xl tracking-tight drop-shadow-lg">
                                    {{ $bahanBaku->stok_saat_ini }} <span class="text-2xl">{{ $bahanBaku->satuan }}</span>
                                </p>
                            </div>
                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('bahan-baku.store-tambah-stok') }}" method="POST">
                        @csrf
                        <input type="hidden" name="bahan_baku_id" value="{{ $bahanBaku->id }}">

                        <div class="space-y-6">
                            
                            <!-- Jumlah Penambahan Field -->
                            <div class="group/field">
                                <label for="jumlah_tambah" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span>Jumlah Penambahan</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(dalam {{ $bahanBaku->satuan }})</span>
                                </label>
                                <div class="relative">
                                    <input id="jumlah_tambah" 
                                           type="number" 
                                           step="0.01" 
                                           name="jumlah_tambah" 
                                           value="{{ old('jumlah_tambah') }}" 
                                           required 
                                           autofocus
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-green-500 dark:focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500 text-lg"
                                           placeholder="0.00"
                                           x-data="{ value: '{{ old('jumlah_tambah', '') }}' }"
                                           x-model="value"
                                           @input="$dispatch('stock-change', { added: parseFloat(value) || 0 })">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Masukkan jumlah stok yang akan ditambahkan</span>
                                </p>
                                @error('jumlah_tambah')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Stock Calculation Preview -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800 p-4 rounded-xl"
                                 x-data="{ 
                                     currentStock: {{ $bahanBaku->stok_saat_ini }}, 
                                     addedStock: 0,
                                     newStock() { return this.currentStock + this.addedStock; }
                                 }"
                                 @stock-change.window="addedStock = $event.detail.added">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center shadow-md">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-green-700 dark:text-green-400 uppercase tracking-wide">Stok Setelah Penambahan</p>
                                            <p class="text-2xl font-extrabold text-green-800 dark:text-green-300" x-text="newStock().toFixed(2) + ' {{ $bahanBaku->satuan }}'"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-green-600 dark:text-green-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Harga Beli Field -->
                            <div class="group/field">
                                <label for="harga_beli" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-red-500 to-orange-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span>Total Harga Beli</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(Rupiah)</span>
                                </label>
                                <div class="relative">
                                    <input id="harga_beli" 
                                           type="number" 
                                           step="100" 
                                           name="harga_beli" 
                                           value="{{ old('harga_beli') }}" 
                                           required
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500 text-lg"
                                           placeholder="0">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <span class="font-bold">Rp</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Biaya pembelian untuk stok ini (akan dicatat sebagai pengeluaran)</span>
                                </p>
                                @error('harga_beli')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Tanggal Pembelian Field -->
                            <div class="group/field">
                                <label for="tanggal_beli" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span>Tanggal Pembelian</span>
                                </label>
                                <div class="relative">
                                    <input id="tanggal_beli" 
                                           type="date" 
                                           name="tanggal_beli" 
                                           value="{{ old('tanggal_beli', now()->toDateString()) }}" 
                                           required
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Tanggal saat melakukan pembelian stok</span>
                                </p>
                                @error('tanggal_beli')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Info Box -->
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded-r-xl">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-yellow-800 dark:text-yellow-300 mb-1">Informasi Penting</h4>
                                        <ul class="text-xs text-yellow-700 dark:text-yellow-400 space-y-1">
                                            <li>• Stok akan otomatis bertambah sesuai jumlah yang diinput</li>
                                            <li>• Harga beli akan dicatat sebagai pengeluaran di laporan</li>
                                            <li>• Pastikan data sudah benar sebelum menyimpan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                                <!-- Submit Button -->
                                <button type="submit" 
                                        class="w-full sm:w-auto group/btn relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                    <svg class="relative z-10 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="relative z-10 text-sm">Simpan Penambahan & Catat Pengeluaran</span>
                                </button>
                                
                                <!-- Cancel Button -->
                                <a href="{{ route('bahan-baku.index') }}" 
                                   class="w-full sm:w-auto group/cancel relative overflow-hidden bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2 border-2 border-gray-300 dark:border-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span>Batal</span>
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js for calculations -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        /* Shimmer Animation for Current Stock Box */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }

        .animate-shimmer {
            animation: shimmer 3s infinite;
        }
    </style>
</x-app-layout>