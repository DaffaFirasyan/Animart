<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div class="flex items-baseline space-x-3">
                <h2 class="font-bold text-3xl sm:text-4xl bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-600 dark:from-blue-400 dark:via-cyan-400 dark:to-blue-400 bg-clip-text text-transparent leading-tight tracking-tight drop-shadow-[0_2px_8px_rgba(59,130,246,0.3)] dark:drop-shadow-[0_2px_12px_rgba(59,130,246,0.5)]">
                    {{ __('Edit Menu') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">{{ $menu->nama_menu }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12"
         x-data="{
            recipeItems: {{ json_encode($currentRecipe) }},
            selectedBahanId: '',
            selectedBahanNama: '',
            jumlahBahan: '',
            editingItemId: null,
            editingJumlah: '',

            addRecipeItem() {
                if (!this.selectedBahanId || !this.jumlahBahan || parseFloat(this.jumlahBahan) <= 0) {
                    alert('Silakan pilih bahan baku dan masukkan jumlah yang valid.');
                    return;
                }
                if (this.recipeItems.some(item => item.bahan_baku_id == this.selectedBahanId)) {
                     alert('Bahan baku ini sudah ada dalam resep.');
                     return;
                }
                this.recipeItems.push({
                    bahan_baku_id: parseInt(this.selectedBahanId),
                    nama_bahan: this.selectedBahanNama,
                    jumlah_dibutuhkan: parseFloat(this.jumlahBahan)
                });
                this.selectedBahanId = '';
                this.selectedBahanNama = '';
                this.jumlahBahan = '';
                document.getElementById('bahan_baku_id_select').selectedIndex = 0;
            },

            removeRecipeItem(index) {
                // Jika item yang dihapus sedang diedit, batalkan mode edit
                if(this.recipeItems[index] && this.editingItemId === this.recipeItems[index].bahan_baku_id) {
                    this.cancelEdit();
                }
                this.recipeItems.splice(index, 1);
            },

            updateSelectedBahanNama(event) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                this.selectedBahanNama = selectedOption.text;
                this.selectedBahanId = selectedOption.value;
            },

            startEditing(item) {
                this.editingItemId = item.bahan_baku_id;
                this.editingJumlah = item.jumlah_dibutuhkan;
                this.$nextTick(() => {
                    const inputElement = document.getElementById('edit-jumlah-' + item.bahan_baku_id);
                    if (inputElement) {
                        inputElement.focus();
                        inputElement.select();
                    }
                });
            },

            saveEdit(index) {
                 if (!this.editingJumlah || parseFloat(this.editingJumlah) <= 0) {
                    alert('Jumlah harus lebih besar dari 0.');
                    return;
                }
                this.recipeItems[index].jumlah_dibutuhkan = parseFloat(this.editingJumlah);
                this.cancelEdit();
            },

            cancelEdit() {
                this.editingItemId = null;
                this.editingJumlah = '';
            }
         }"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Enhanced Alert Messages -->
            @if (session('success'))
                <div class="relative overflow-hidden bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-500 dark:border-green-600 p-5 rounded-2xl shadow-lg animate-in slide-in-from-top duration-500">
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

            @if ($errors->any())
                <div class="relative overflow-hidden bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-2 border-red-500 dark:border-red-600 p-5 rounded-2xl shadow-lg animate-in slide-in-from-top duration-500">
                    <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-red-500 to-orange-500"></div>
                    <div class="ml-2">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-red-800 dark:text-red-200 font-bold text-lg">Terdapat kesalahan:</p>
                        </div>
                        <ul class="list-disc list-inside text-red-700 dark:text-red-300 space-y-1 ml-14">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Section 1: Detail Menu -->
                <div class="relative overflow-hidden bg-gradient-to-br from-white to-orange-50 dark:from-gray-800 dark:to-orange-900/10 shadow-2xl rounded-2xl border-2 border-orange-100 dark:border-orange-900/30 mb-6">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                    
                    <div class="relative p-6 sm:p-8">
                        <div class="flex items-center space-x-4 mb-6 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Detail Menu</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Informasi dasar menu ricebowl</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Nama Menu -->
                            <div class="group/field">
                                <label for="nama_menu" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-red-500 to-orange-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <span>Nama Menu</span>
                                </label>
                                <div class="relative">
                                    <input id="nama_menu" 
                                           type="text" 
                                           name="nama_menu" 
                                           value="{{ old('nama_menu', $menu->nama_menu) }}" 
                                           required 
                                           autofocus
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Harga -->
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
                                           value="{{ old('harga', $menu->harga) }}" 
                                           required
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-green-500 dark:focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg text-lg">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 font-bold">
                                        Rp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Tambah Bahan ke Resep -->
                <div class="relative overflow-hidden bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-green-900/10 shadow-2xl rounded-2xl border-2 border-green-100 dark:border-green-900/30 mb-6">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                    
                    <div class="relative p-6 sm:p-8">
                        <div class="flex items-center space-x-4 mb-6 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-green-500 via-emerald-500 to-green-500 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Tambah Bahan ke Resep</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Pilih bahan dan tentukan jumlahnya</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- Bahan Baku Select -->
                            <div class="group/field">
                                <label for="bahan_baku_id_select" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <span>Bahan Baku</span>
                                </label>
                                <select x-model="selectedBahanId" 
                                        @change="updateSelectedBahanNama($event)"
                                        id="bahan_baku_id_select" 
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg">
                                    <option value="">Pilih Bahan</option>
                                    @foreach ($bahanBakus as $bahan)
                                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }} ({{ $bahan->satuan }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jumlah Input -->
                            <div class="group/field">
                                <label for="jumlah_dibutuhkan_input" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span>Jumlah (per porsi)</span>
                                </label>
                                <input id="jumlah_dibutuhkan_input" 
                                       type="number" 
                                       step="0.01" 
                                       x-model="jumlahBahan"
                                       class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-purple-500 dark:focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg"
                                       placeholder="0.00">
                            </div>

                            <!-- Add Button -->
                            <div class="self-end">
                                <button type="button" 
                                        @click="addRecipeItem()"
                                        class="w-full group/btn relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                    <svg class="relative z-10 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span class="relative z-10">Tambah Bahan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Resep Saat Ini -->
                <div class="relative overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/10 shadow-2xl rounded-2xl border-2 border-blue-100 dark:border-blue-900/30 mb-6">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                    
                    <div class="relative p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                                    <div class="relative w-14 h-14 bg-gradient-to-br from-blue-500 via-cyan-500 to-blue-500 rounded-xl flex items-center justify-center shadow-xl">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Resep Saat Ini</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Untuk 1 porsi {{ $menu->nama_menu }}</p>
                                </div>
                            </div>
                            <div class="hidden sm:block px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-bold rounded-full shadow-lg">
                                <span x-text="recipeItems.length + ' BAHAN'"></span>
                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-2xl border-2 border-gray-200 dark:border-gray-700 shadow-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-600 dark:from-blue-700 dark:via-cyan-700 dark:to-blue-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Nama Bahan
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Jumlah Dibutuhkan
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-for="(item, index) in recipeItems" :key="index">
                                        <tr class="hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-yellow-100 dark:from-orange-900/30 dark:to-yellow-900/30 rounded-lg flex items-center justify-center shadow-md">
                                                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                        </svg>
                                                    </div>
                                                    <span class="font-bold text-gray-900 dark:text-gray-100" x-text="item.nama_bahan"></span>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <template x-if="editingItemId === item.bahan_baku_id">
                                                     <input type="number" 
                                                            step="0.01" 
                                                            x-model="editingJumlah" 
                                                            :id="'edit-jumlah-' + item.bahan_baku_id" 
                                                            class="border-2 border-orange-500 focus:border-orange-600 focus:ring-4 focus:ring-orange-500/20 rounded-lg shadow-md px-3 py-2 w-32 font-bold text-gray-900 dark:text-gray-100 dark:bg-gray-700" 
                                                            @keydown.enter.prevent="saveEdit(index)" 
                                                            @keydown.escape.prevent="cancelEdit()">
                                                </template>
                                                <template x-if="editingItemId !== item.bahan_baku_id">
                                                    <span class="px-3 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm font-bold rounded-full shadow-md" x-text="item.jumlah_dibutuhkan"></span>
                                                </template>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <template x-if="editingItemId === item.bahan_baku_id">
                                                        <div class="flex items-center space-x-2">
                                                            <button type="button" 
                                                                    @click="saveEdit(index)" 
                                                                    class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 inline-flex items-center space-x-1">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                <span class="text-xs">Simpan</span>
                                                            </button>
                                                            <button type="button" 
                                                                    @click="cancelEdit()" 
                                                                    class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 inline-flex items-center space-x-1">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                <span class="text-xs">Batal</span>
                                                            </button>
                                                        </div>
                                                    </template>
                                                    <template x-if="editingItemId !== item.bahan_baku_id">
                                                        <button type="button" 
                                                                @click="startEditing(item)" 
                                                                class="bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 inline-flex items-center space-x-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            <span class="text-xs">Edit</span>
                                                        </button>
                                                    </template>

                                                    <button type="button" 
                                                            @click="removeRecipeItem(index)" 
                                                            class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 inline-flex items-center space-x-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <span class="text-xs">Hapus</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="recipeItems.length === 0">
                                        <tr>
                                            <td colspan="3" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center justify-center space-y-4">
                                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center shadow-xl">
                                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-gray-500 dark:text-gray-400 font-semibold text-lg">
                                                        Resep masih kosong
                                                    </p>
                                                    <p class="text-gray-400 dark:text-gray-500 text-sm">
                                                        Silakan tambahkan bahan di section atas
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Hidden inputs for recipe items -->
                        <template x-for="(item, index) in recipeItems" :key="index">
                            <div>
                                <input type="hidden" :name="'reseps[' + index + '][bahan_baku_id]'" x-model="item.bahan_baku_id">
                                <input type="hidden" :name="'reseps[' + index + '][jumlah_dibutuhkan]'" x-model="item.jumlah_dibutuhkan">
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Action Section -->
                <div class="relative overflow-hidden bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-2xl rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full sm:w-auto group/btn relative overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-600 hover:from-blue-700 hover:via-cyan-700 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                            <svg class="relative z-10 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="relative z-10">Simpan Semua Perubahan</span>
                            <span class="relative z-10 text-xs opacity-75">(Menu & Resep)</span>
                        </button>
                        
                        <!-- Back Button -->
                        <a href="{{ route('menu.index') }}" 
                           class="w-full sm:w-auto group/cancel relative overflow-hidden bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2 border-2 border-gray-300 dark:border-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali ke Daftar Menu</span>
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
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
    </style>
</x-app-layout>