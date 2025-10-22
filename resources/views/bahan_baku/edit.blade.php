<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bahan Baku: ') . $bahanBaku->nama_bahan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('bahan-baku.update', $bahanBaku->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nama_bahan" :value="__('Nama Bahan')" />
                                <x-text-input id="nama_bahan" class="block mt-1 w-full" type="text" name="nama_bahan" :value="old('nama_bahan', $bahanBaku->nama_bahan)" required autofocus />
                                <x-input-error :messages="$errors->get('nama_bahan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="stok_saat_ini" :value="__('Stok Saat Ini')" />
                                <x-text-input id="stok_saat_ini" class="block mt-1 w-full" type="number" step="0.01" name="stok_saat_ini" :value="old('stok_saat_ini', $bahanBaku->stok_saat_ini)" required />
                                <x-input-error :messages="$errors->get('stok_saat_ini')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="satuan" :value="__('Satuan (Contoh: gram, ml, pcs)')" />
                                <x-text-input id="satuan" class="block mt-1 w-full" type="text" name="satuan" :value="old('satuan', $bahanBaku->satuan)" required />
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="stok_minimum" :value="__('Stok Minimum (Untuk Peringatan)')" />
                                <x-text-input id="stok_minimum" class="block mt-1 w-full" type="number" step="0.01" name="stok_minimum" :value="old('stok_minimum', $bahanBaku->stok_minimum)" required />
                                <x-input-error :messages="$errors->get('stok_minimum')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit">{{ __('Perbarui') }}</x-primary-button>
                                
                                <a href="{{ route('bahan-baku.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Batal') }}
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>