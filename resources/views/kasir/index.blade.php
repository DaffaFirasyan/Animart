<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Halaman Kasir (POS)') }}
        </h2>
    </x-slot>

    <div class="py-12" 
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

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-400 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 text-red-600 bg-red-100 border border-red-400 p-4 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Menu</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                @forelse ($menus as $menu)
                                    <div @click='addToCart({{ json_encode($menu) }})' 
                                         class="border rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition">
                                        <div class="font-semibold">{{ $menu->nama_menu }}</div>
                                        <div class="text-sm text-gray-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                    </div>
                                @empty
                                    <p class="col-span-full text-gray-500">
                                        Tidak ada menu yang tersedia atau stok bahan baku habis.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Keranjang</h3>

                            <form action="{{ route('kasir.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_data" x-model="cartData">

                                <div class="space-y-4">
                                    <template x-if="cart.length === 0">
                                        <p class="text-gray-500 text-center">Keranjang masih kosong.</p>
                                    </template>
                                    
                                    <template x-for="item in cart" :key="item.id">
                                        <div class="border-b pb-2">
                                            <div class="font-semibold" x-text="item.nama"></div>
                                            <div class="flex justify-between items-center mt-1">
                                                <div class="flex items-center space-x-2">
                                                    <button @click.prevent="decrement(item.id)" type="button" class="text-red-500 font-bold">-</button>
                                                    <span x-text="item.quantity"></span>
                                                    <button @click.prevent="increment(item.id)" type="button" class="text-green-500 font-bold">+</button>
                                                </div>
                                                <div class="text-gray-700" x-text="'Rp ' + subtotal(item).toLocaleString('id-ID')"></div>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="border-t pt-4 mt-4" x-show="cart.length > 0">
                                        <div class="flex justify-between font-bold text-lg">
                                            <span>Total:</span>
                                            <span x-text="'Rp ' + totalPrice().toLocaleString('id-ID')"></span>
                                        </div>

                                        <x-primary-button class="w-full justify-center mt-4" 
                                                          type="submit" 
                                                          x-bind:disabled="cart.length === 0"
                                                          x-bind:class="{ 'opacity-50 cursor-not-allowed': cart.length === 0 }">
                                            Simpan Transaksi
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>