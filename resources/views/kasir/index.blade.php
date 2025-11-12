<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl leading-tight tracking-tight
                bg-gradient-to-r from-red-600 to-yellow-500 
                dark:from-red-400 dark:to-yellow-400 
                bg-clip-text text-transparent">
            {{ __('Halaman Kasir (POS)') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12" 
         x-data="{ 
            cart: [], 
            cartData: '[]',
            
            // Fungsi untuk menambah menu ke keranjang
            addToCart(menu) {
                // Cek apakah menu sudah ada di keranjang
                let existingItem = this.cart.find(item => item.id === menu.id);
                
                if (existingItem) {
                    // Jika ada, tambahkan quantity
                    existingItem.quantity++;
                } else {
                    // Jika tidak ada, tambahkan sebagai item baru
                    this.cart.push({
                        id: menu.id,
                        nama: menu.nama_menu,
                        harga: parseFloat(menu.harga),
                        quantity: 1
                    });
                }
                this.updateCartData();
            },
            
            // Fungsi untuk menambah jumlah item
            increment(id) {
                let item = this.cart.find(item => item.id === id);
                if (item) item.quantity++;
                this.updateCartData();
            },
            
            // Fungsi untuk mengurangi jumlah item
            decrement(id) {
                let item = this.cart.find(item => item.id === id);
                if (item && item.quantity > 1) {
                    item.quantity--;
                } else if (item && item.quantity === 1) {
                    // Jika quantity 1 dan dikurangi, hapus dari cart
                    this.removeFromCart(id);
                }
                this.updateCartData();
            },
            
            // Fungsi untuk menghapus item dari keranjang
            removeFromCart(id) {
                this.cart = this.cart.filter(item => item.id !== id);
                this.updateCartData();
            },

            // Menghitung subtotal per item
            subtotal(item) {
                return item.harga * item.quantity;
            },

            // Menghitung total harga keseluruhan keranjang
            totalPrice() {
                return this.cart.reduce((total, item) => {
                    return total + this.subtotal(item);
                }, 0);
            },

            // Fungsi untuk meng-update hidden input
            updateCartData() {
                this.cartData = JSON.stringify(this.cart);
            }
         }"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Enhanced Alert Messages -->
            @if (session('success'))
                <div class="mb-6 relative overflow-hidden bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-500 dark:border-green-600 p-5 rounded-2xl shadow-lg animate-in slide-in-from-top duration-500">
                    <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-green-500 to-emerald-500"></div>
                    <div class="flex items-center space-x-3 ml-2">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-green-800 dark:text-green-200 font-bold text-lg">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 relative overflow-hidden bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-2 border-red-500 dark:border-red-600 p-5 rounded-2xl shadow-lg animate-in slide-in-from-top duration-500">
                    <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-red-500 to-orange-500"></div>
                    <div class="flex items-center space-x-3 ml-2">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-red-800 dark:text-red-200 font-bold text-lg">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Menu Section - Enhanced -->
                <div class="lg:col-span-2">
                    <div class="group relative overflow-hidden bg-gradient-to-br from-white to-orange-50 dark:from-gray-800 dark:to-orange-900/10 shadow-2xl rounded-2xl border-2 border-orange-100 dark:border-orange-900/30 transition-all duration-500">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-red-500/10 to-transparent rounded-tr-[4rem] pointer-events-none"></div>

                        <div class="relative p-6 sm:p-8">
                            <!-- Section Header -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-yellow-500 rounded-xl blur-md opacity-50"></div>
                                        <div class="relative w-12 h-12 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Daftar Menu</h3>
                                    </div>
                                </div>
                                
                                <!-- Menu Count Badge -->
                                <div class="px-4 py-2 bg-gradient-to-r from-red-500 to-yellow-500 text-white rounded-full shadow-lg">
                                    <span class="font-bold text-sm">{{ count($menus) }} Items</span>
                                </div>
                            </div>

                            <!-- Menu Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                @forelse ($menus as $menu)
                                    <div @click='addToCart({{ json_encode($menu) }})' 
                                         class="group/card relative overflow-hidden bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-2xl p-5 text-center cursor-pointer transition-all duration-300 hover:border-red-500 dark:hover:border-red-500 hover:shadow-[0_0_30px_rgba(239,68,68,0.4)] hover:scale-105 hover:-translate-y-1 active:scale-95">
                                        
                                        <!-- Hover Gradient Background -->
                                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/0 to-yellow-500/0 group-hover/card:from-red-500/10 group-hover/card:to-yellow-500/10 transition-all duration-300 rounded-2xl"></div>
                                        
                                        <!-- Plus Icon Overlay -->
                                        <div class="absolute top-2 right-2 w-8 h-8 bg-gradient-to-br from-red-500 to-yellow-500 rounded-full flex items-center justify-center opacity-0 group-hover/card:opacity-100 transform scale-0 group-hover/card:scale-100 transition-all duration-300 shadow-lg">
                                            <svg class="w-5 h-5 text-white font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </div>

                                        <!-- Menu Icon/Image Placeholder -->
                                        <div class="relative mb-3">
                                            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-red-100 to-yellow-100 dark:from-red-900/30 dark:to-yellow-900/30 rounded-2xl flex items-center justify-center shadow-lg group-hover/card:shadow-xl group-hover/card:scale-110 transition-all duration-300">
                                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Menu Info -->
                                        <div class="relative z-10 space-y-2">
                                            <div class="font-bold text-gray-900 dark:text-gray-100 group-hover/card:text-red-600 dark:group-hover/card:text-red-400 transition-colors duration-300 line-clamp-2">
                                                {{ $menu->nama_menu }}
                                            </div>
                                            <div class="inline-block px-3 py-1 bg-gradient-to-r from-red-500 to-orange-500 text-white text-sm font-bold rounded-full shadow-md group-hover/card:shadow-lg group-hover/card:from-red-600 group-hover/card:to-orange-600 transition-all duration-300">
                                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                            </div>
                                        </div>

                                        <!-- Shimmer Effect -->
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/card:translate-x-full transition-transform duration-1000"></div>
                                    </div>
                                @empty
                                    <div class="col-span-full flex flex-col items-center justify-center py-16 space-y-4">
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center shadow-xl">
                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium text-center text-lg">
                                            Tidak ada menu yang tersedia atau stok bahan baku habis.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Section - Enhanced -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 group relative overflow-hidden bg-gradient-to-br from-white to-yellow-50 dark:from-gray-800 dark:to-yellow-900/10 shadow-2xl rounded-2xl border-2 border-yellow-100 dark:border-yellow-900/30 transition-all duration-500">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>

                        <div class="relative p-6">
                            <!-- Cart Header -->
                            <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-red-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                                        <div class="relative w-12 h-12 bg-gradient-to-br from-yellow-500 via-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-xl">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Keranjang</h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 font-medium" x-text="cart.length + ' items'"></p>
                                    </div>
                                </div>

                                <!-- Cart Count Badge -->
                                <div class="relative">
                                    <div class="absolute inset-0 bg-red-500 rounded-full blur-sm animate-pulse"></div>
                                    <div class="relative px-3 py-1.5 bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-lg">
                                        <span class="font-bold text-sm" x-text="cart.length"></span>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('kasir.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_data" x-model="cartData">

                                <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar mb-4">
                                    <!-- Empty State -->
                                    <template x-if="cart.length === 0">
                                        <div class="flex flex-col items-center justify-center py-12 space-y-4">
                                            <div class="w-20 h-20 bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center shadow-xl animate-bounce">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 dark:text-gray-400 font-semibold text-center">
                                                Keranjang masih kosong
                                            </p>
                                            <p class="text-gray-400 dark:text-gray-500 text-sm text-center">
                                                Mulai tambahkan menu
                                            </p>
                                        </div>
                                    </template>
                                    
                                    <!-- Cart Items -->
                                    <template x-for="item in cart" :key="item.id">
                                        <div class="group/item relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 border-2 border-gray-200 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-500 rounded-xl p-4 transition-all duration-300 hover:shadow-lg">
                                            <!-- Item Info -->
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex-1 min-w-0 pr-2">
                                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 text-sm line-clamp-2" x-text="item.nama"></h4>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                        <span x-text="'Rp ' + item.harga.toLocaleString('id-ID')"></span> × <span x-text="item.quantity"></span>
                                                    </p>
                                                </div>
                                                
                                                <!-- Remove Button -->
                                                <button @click.prevent="removeFromCart(item.id)" 
                                                        type="button" 
                                                        class="flex-shrink-0 w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110 active:scale-95 shadow-md">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Quantity Controls & Subtotal -->
                                            <div class="flex items-center justify-between">
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center space-x-2 bg-white dark:bg-gray-800 rounded-lg p-1.5 shadow-inner">
                                                    <button @click.prevent="decrement(item.id)" 
                                                            type="button" 
                                                            class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-bold flex items-center justify-center transition-all duration-200 hover:scale-110 active:scale-95 shadow-md">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                                        </svg>
                                                    </button>
                                                    
                                                    <span class="w-10 text-center font-bold text-gray-900 dark:text-gray-100 text-lg" x-text="item.quantity"></span>
                                                    
                                                    <button @click.prevent="increment(item.id)" 
                                                            type="button" 
                                                            class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg font-bold flex items-center justify-center transition-all duration-200 hover:scale-110 active:scale-95 shadow-md">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Subtotal -->
                                                <div class="text-right">
                                                    <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">Subtotal</div>
                                                    <div class="font-bold text-red-600 dark:text-red-400 text-base" x-text="'Rp ' + subtotal(item).toLocaleString('id-ID')"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Total & Checkout -->
                                <div class="border-t-2 border-gray-300 dark:border-gray-600 pt-4 mt-4 space-y-4" x-show="cart.length > 0">
                                    <!-- Total Price Box -->
                                    <div class="relative overflow-hidden bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-2xl p-6 shadow-2xl">
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-shimmer"></div>
                                        
                                        <div class="relative z-10 flex items-center justify-between">
                                            <div>
                                                <p class="text-white/80 text-sm font-bold mb-1">TOTAL PEMBAYARAN</p>
                                                <p class="text-white font-extrabold text-3xl tracking-tight drop-shadow-lg" x-text="'Rp ' + totalPrice().toLocaleString('id-ID')"></p>
                                            </div>
                                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Checkout Button -->
                                    <button type="submit" 
                                            x-bind:disabled="cart.length === 0"
                                            x-bind:class="{ 'opacity-50 cursor-not-allowed': cart.length === 0 }"
                                            class="group/btn w-full relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 disabled:hover:scale-100">
                                        
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                        
                                        <div class="relative z-10 flex items-center justify-center space-x-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-lg">Simpan Transaksi</span>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Custom Scrollbar for Cart */
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

        /* Shimmer Animation */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }

        .animate-shimmer {
            animation: shimmer 3s infinite;
        }

        /* Slide In Animation */
        @keyframes slide-in-from-top {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: slide-in-from-top 0.5s ease-out;
        }

        /* Line Clamp Utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>