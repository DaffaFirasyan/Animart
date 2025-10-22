<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Menu: ') . $menu->nama_menu }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-400 p-4 rounded-lg sm:rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Menu</h3>
                    <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nama_menu" :value="__('Nama Menu')" />
                                <x-text-input id="nama_menu" class="block mt-1 w-full" type="text" name="nama_menu" :value="old('nama_menu', $menu->nama_menu)" required autofocus />
                                <x-input-error :messages="$errors->get('nama_menu')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="harga" :value="__('Harga Jual (Rp)')" />
                                <x-text-input id="harga" class="block mt-1 w-full" type="number" step="100" name="harga" :value="old('harga', $menu->harga)" required />
                                <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                            </div>
                            <div>
                                <x-primary-button type="submit">{{ __('Perbarui Detail Menu') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Bahan ke Resep</h3>
                    <form action="{{ route('resep.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="bahan_baku_id" :value="__('Bahan Baku')" />
                                <select name="bahan_baku_id" id="bahan_baku_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih Bahan</option>
                                    @foreach ($bahanBakus as $bahan)
                                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }} ({{ $bahan->satuan }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('bahan_baku_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jumlah_dibutuhkan" :value="__('Jumlah Dibutuhkan (per porsi)')" />
                                <x-text-input id="jumlah_dibutuhkan" class="block mt-1 w-full" type="number" step="0.01" name="jumlah_dibutuhkan" required />
                                <x-input-error :messages="$errors->get('jumlah_dibutuhkan')" class="mt-2" />
                            </div>
                            <div class="self-end">
                                <x-primary-button type="submit">{{ __('Tambah/Update Resep') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                                @forelse ($menu->reseps as $resep)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $resep->bahanBaku->nama_bahan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $resep->jumlah_dibutuhkan }} {{ $resep->bahanBaku->satuan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('resep.destroy', $resep->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bahan ini dari resep?');">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <x-danger-button type="submit">Hapus</x-danger-button>
                                                
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Resep masih kosong. Silakan tambahkan bahan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>