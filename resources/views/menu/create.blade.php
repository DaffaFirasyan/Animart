<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('menu.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nama_menu" :value="__('Nama Menu')" />
                                <x-text-input id="nama_menu" class="block mt-1 w-full" type="text" name="nama_menu" :value="old('nama_menu')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_menu')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="harga" :value="__('Harga Jual (Rp)')" />
                                <x-text-input id="harga" class="block mt-1 w-full" type="number" step="100" name="harga" :value="old('harga')" required />
                                <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit">{{ __('Simpan dan Lanjut Atur Resep') }}</x-primary-button>
                                
                                <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
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