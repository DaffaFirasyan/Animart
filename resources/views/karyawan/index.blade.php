<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl leading-tight tracking-tight
                bg-gradient-to-r from-red-600 to-yellow-500
                dark:from-red-400 dark:to-yellow-400
                bg-clip-text text-transparent">
            {{ __('Manajemen Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="group relative overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/10 shadow-2xl rounded-2xl border-2 border-blue-100 dark:border-blue-900/30">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-[4rem] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-cyan-500/10 to-transparent rounded-tr-[4rem] pointer-events-none"></div>

                <div class="relative p-6 sm:p-8">

                    <!-- Header Section with Add Button -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                                <div class="relative w-14 h-14 bg-gradient-to-br from-blue-500 via-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Daftar Karyawan</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Kelola akun karyawan</p>
                            </div>
                        </div>

                        <!-- Add Button -->
                        <a href="{{ route('karyawan.create') }}"
                           class="group/btn relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                            <svg class="relative z-10 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="relative z-10">Tambah Karyawan</span>
                        </a>
                    </div>

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

                    <!-- Enhanced Table -->
                    <div class="overflow-x-auto rounded-2xl border-2 border-gray-200 dark:border-gray-700 shadow-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-600 dark:from-blue-700 dark:via-cyan-700 dark:to-blue-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($karyawans as $karyawan)
                                    <tr class="hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors duration-200">
                                        <!-- Nama -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-full flex items-center justify-center shadow-md">
                                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-gray-900 dark:text-gray-100">{{ $karyawan->name }}</span>
                                            </div>
                                        </td>

                                        <!-- Email -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $karyawan->email }}</span>
                                            </div>
                                        </td>

                                        <!-- Role -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-sm font-bold rounded-full shadow-md uppercase">
                                                {{ $karyawan->role }}
                                            </span>
                                        </td>

                                        <!-- Action Buttons -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                                                   class="group/edit relative overflow-hidden bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 inline-flex items-center space-x-1.5">
                                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/edit:translate-x-full transition-transform duration-700"></div>
                                                    <svg class="relative z-10 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    <span class="relative z-10 text-xs uppercase tracking-wider">Edit</span>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="group/del relative overflow-hidden bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 inline-flex items-center space-x-1.5">
                                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/del:translate-x-full transition-transform duration-700"></div>
                                                        <svg class="relative z-10 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <span class="relative z-10 text-xs uppercase tracking-wider">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center space-y-4">
                                                <div class="w-24 h-24 bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center shadow-xl">
                                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                                <p class="text-gray-500 dark:text-gray-400 font-semibold text-lg">
                                                    Belum ada data karyawan
                                                </p>
                                                <p class="text-gray-400 dark:text-gray-500 text-sm">
                                                    Klik tombol "Tambah Karyawan" untuk memulai
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($karyawans->hasPages())
                    <div class="mt-6">
                        {{ $karyawans->links() }}
                    </div>
                    @endif

                </div>
            </div>
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
