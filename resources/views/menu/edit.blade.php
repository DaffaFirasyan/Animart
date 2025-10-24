<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Menu: ') . $menu->nama_menu }}
        </h2>
    </x-slot>

    <div class="py-12"
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
        <div class="max-w-7xl mx-auto sm:px-6 lg-px-8 space-y-6">

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-400 p-4 rounded-lg sm:rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
             @if ($errors->any())
                <div class="mb-4 text-red-600 bg-red-100 border border-red-400 p-4 rounded-lg sm:rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Menu</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nama_menu" :value="__('Nama Menu')" />
                                <x-text-input id="nama_menu" class="block mt-1 w-full" type="text" name="nama_menu" :value="old('nama_menu', $menu->nama_menu)" required autofocus />
                            </div>
                            <div>
                                <x-input-label for="harga" :value="__('Harga Jual (Rp)')" />
                                <x-text-input id="harga" class="block mt-1 w-full" type="number" step="100" name="harga" :value="old('harga', $menu->harga)" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Bahan ke Resep</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="bahan_baku_id_select" :value="__('Bahan Baku')" />
                                <select x-model="selectedBahanId" @change="updateSelectedBahanNama($event)"
                                        id="bahan_baku_id_select" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Pilih Bahan</option>
                                    @foreach ($bahanBakus as $bahan)
                                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }} ({{ $bahan->satuan }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="jumlah_dibutuhkan_input" :value="__('Jumlah Dibutuhkan (per porsi)')" />
                                <x-text-input id="jumlah_dibutuhkan_input" class="block mt-1 w-full" type="number" step="0.01" x-model="jumlahBahan" />
                            </div>
                            <div class="self-end">
                                <x-primary-button type="button" @click="addRecipeItem()">{{ __('Tambah Bahan') }}</x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Resep Saat Ini (untuk 1 porsi {{ $menu->nama_menu }})</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bahan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Dibutuhkan</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="(item, index) in recipeItems" :key="index">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap" x-text="item.nama_bahan"></td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <template x-if="editingItemId === item.bahan_baku_id">
                                                     <input type="number" step="0.01" x-model="editingJumlah" :id="'edit-jumlah-' + item.bahan_baku_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm p-1 w-24" @keydown.enter.prevent="saveEdit(index)" @keydown.escape.prevent="cancelEdit()">
                                                </template>
                                                <template x-if="editingItemId !== item.bahan_baku_id">
                                                    <span x-text="item.jumlah_dibutuhkan"></span>
                                                </template>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <template x-if="editingItemId === item.bahan_baku_id">
                                                    <button type="button" @click="saveEdit(index)" class="text-green-600 hover:text-green-900">Simpan</button>
                                                    <button type="button" @click="cancelEdit()" class="text-gray-600 hover:text-gray-900">Batal</button>
                                                </template>
                                                <template x-if="editingItemId !== item.bahan_baku_id">
                                                    <button type="button" @click="startEditing(item)" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                </template>

                                                <button type="button" @click="removeRecipeItem(index)" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="recipeItems.length === 0">
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                                Resep masih kosong. Silakan tambahkan bahan.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <template x-for="(item, index) in recipeItems" :key="index">
                            <div>
                                <input type="hidden" :name="'reseps[' + index + '][bahan_baku_id]'" x-model="item.bahan_baku_id">
                                <input type="hidden" :name="'reseps[' + index + '][jumlah_dibutuhkan]'" x-model="item.jumlah_dibutuhkan">
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <x-primary-button type="submit">{{ __('Simpan Semua Perubahan (Menu & Resep)') }}</x-primary-button>
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Kembali ke Daftar Menu') }}
                    </a>
                </div>

            </form> </div>
    </div>
</x-app-layout>