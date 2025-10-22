<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Stok: ') . $bahanBaku->nama_bahan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('bahan-baku.store-tambah-stok') }}" method="POST">
                        @csrf
                        <input type="hidden" name="bahan_baku_id" value="{{ $bahanBaku->id }}">
                        
                        <div class="space-y-4">
                            <div>
                                <x-input-label :value="__('Stok Saat Ini')" />
                                <p class="mt-1 font-semibold text-lg">{{ $bahanBaku->stok_saat_ini }} {{ $bahanBaku->satuan }}</p>
                            </div>

                            <div>
                                <x-input-label for="jumlah_tambah" :value="__('Jumlah Penambahan (dalam ' . $bahanBaku->satuan . ')')" />
                                <x-text-input id="jumlah_tambah" class="block mt-1 w-full" type="number" step="0.01" name="jumlah_tambah" :value="old('jumlah_tambah')" required autofocus />
                                <x-input-error :messages="$errors->get('jumlah_tambah')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit">{{ __('Simpan Penambahan') }}</x-primary-button>
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