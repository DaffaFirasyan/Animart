<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl sm:text-4xl bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 dark:from-red-400 dark:via-orange-400 dark:to-yellow-400 bg-clip-text text-transparent leading-tight tracking-tight drop-shadow-[0_2px_8px_rgba(239,68,68,0.3)] dark:drop-shadow-[0_2px_12px_rgba(239,68,68,0.5)]">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="group relative overflow-hidden bg-gradient-to-br from-white to-orange-50 dark:from-gray-800 dark:to-orange-900/10 shadow-2xl rounded-2xl border-2 border-orange-100 dark:border-orange-900/30">
                
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-yellow-500/10 to-transparent rounded-bl-[5rem] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-gradient-to-tr from-red-500/10 to-transparent rounded-tr-[5rem] pointer-events-none"></div>
                
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500"></div>
                </div>

                <div class="relative p-6 sm:p-8">
                    
                    <!-- Form Header with Icon -->
                    <div class="flex items-center space-x-4 mb-8 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-yellow-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Buat Menu Baru</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Tambahkan item ke menu ricebowl</p>
                        </div>
                    </div>

                    <!-- Workflow Info Box -->
                    <div class="mb-6 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-l-4 border-blue-500 p-4 rounded-r-xl">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-2">Alur Pembuatan Menu</h4>
                                <ol class="text-xs text-blue-700 dark:text-blue-400 space-y-1.5">
                                    <li class="flex items-center space-x-2">
                                        <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                        <span><strong>Isi data menu</strong> (nama dan harga)</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <span class="flex-shrink-0 w-5 h-5 bg-blue-400 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                        <span><strong>Atur resep</strong> (bahan baku dan takaran)</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <span class="flex-shrink-0 w-5 h-5 bg-blue-300 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                        <span><strong>Menu siap</strong> dijual di kasir</span>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('menu.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            
                            <!-- Nama Menu Field -->
                            <div class="group/field">
                                <label for="nama_menu" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-red-500 to-orange-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <span>Nama Menu</span>
                                </label>
                                <div class="relative">
                                    <input id="nama_menu" 
                                           type="text" 
                                           name="nama_menu" 
                                           value="{{ old('nama_menu') }}" 
                                           required 
                                           autofocus
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500"
                                           placeholder="Contoh: Ricebowl Ayam Teriyaki, Ricebowl Rendang, dll">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Berikan nama yang menarik dan mudah diingat pelanggan</span>
                                </p>
                                @error('nama_menu')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Harga Field -->
                            <div class="group/field">
                                <label for="harga" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span>Harga Jual</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(Rupiah)</span>
                                </label>
                                <div class="relative">
                                    <input id="harga" 
                                           type="number" 
                                           step="100" 
                                           name="harga" 
                                           value="{{ old('harga') }}" 
                                           required
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-green-500 dark:focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500 text-lg"
                                           placeholder="15000">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 font-bold">
                                        Rp
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Harga yang akan ditampilkan di kasir (kelipatan Rp 100)</span>
                                </p>
                                @error('harga')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Next Steps Info Box -->
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border-l-4 border-yellow-500 p-4 rounded-r-xl">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-yellow-800 dark:text-yellow-300 mb-1">Langkah Selanjutnya</h4>
                                        <p class="text-xs text-yellow-700 dark:text-yellow-400">Setelah menyimpan, Anda akan diarahkan ke halaman <strong>Atur Resep</strong> untuk menentukan bahan baku dan takaran yang dibutuhkan untuk menu ini.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tips Box -->
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 border-2 border-purple-200 dark:border-purple-800 p-4 rounded-xl">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-purple-800 dark:text-purple-300 mb-1">💡 Tips Penamaan & Harga</h4>
                                        <ul class="text-xs text-purple-700 dark:text-purple-400 space-y-1">
                                            <li>• Gunakan nama yang mencerminkan topping utama (Ayam Teriyaki, Beef Bulgogi)</li>
                                            <li>• Pertimbangkan biaya bahan baku + margin keuntungan saat menentukan harga</li>
                                            <li>• Harga disarankan kelipatan Rp 500 atau Rp 1.000 untuk memudahkan transaksi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                                <!-- Submit Button -->
                                <button type="submit" 
                                        class="w-full sm:w-auto group/btn relative overflow-hidden bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 hover:from-red-700 hover:via-orange-700 hover:to-yellow-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                    <svg class="relative z-10 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="relative z-10">Simpan & Lanjut Atur Resep</span>
                                    <svg class="relative z-10 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                                
                                <!-- Cancel Button -->
                                <a href="{{ route('menu.index') }}" 
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
</x-app-layout>