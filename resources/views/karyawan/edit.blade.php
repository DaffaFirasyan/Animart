<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl leading-tight tracking-tight
                bg-gradient-to-r from-red-600 to-yellow-500
                dark:from-red-400 dark:to-yellow-400
                bg-clip-text text-transparent">
            {{ __('Edit Data Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="group relative overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/10 shadow-2xl rounded-2xl border-2 border-blue-100 dark:border-blue-900/30">

                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-cyan-500/10 to-transparent rounded-bl-[5rem] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-gradient-to-tr from-blue-500/10 to-transparent rounded-tr-[5rem] pointer-events-none"></div>

                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-cyan-500 to-blue-600"></div>
                </div>

                <div class="relative p-6 sm:p-8">

                    <!-- Form Header with Icon -->
                    <div class="flex items-center space-x-4 mb-8 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 via-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Edit Karyawan</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Update informasi karyawan</p>
                        </div>
                    </div>

                    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">

                            <!-- Nama Field -->
                            <div class="group/field">
                                <label for="name" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span>Nama Lengkap</span>
                                </label>
                                <div class="relative">
                                    <input id="name"
                                           type="text"
                                           name="name"
                                           value="{{ old('name', $karyawan->name) }}"
                                           required
                                           autofocus
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500"
                                           placeholder="Contoh: John Doe">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="group/field">
                                <label for="email" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span>Email</span>
                                </label>
                                <div class="relative">
                                    <input id="email"
                                           type="email"
                                           name="email"
                                           value="{{ old('email', $karyawan->email) }}"
                                           required
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-green-500 dark:focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500"
                                           placeholder="karyawan@animart.com">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Email akan digunakan untuk login ke sistem</span>
                                </p>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="group/field">
                                <label for="password" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <span>Password Baru</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <input id="password"
                                           type="password"
                                           name="password"
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-purple-500 dark:focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500"
                                           placeholder="Kosongkan jika tidak ingin mengubah password">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Kosongkan jika tidak ingin mengubah password</span>
                                </p>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Password Confirmation Field -->
                            <div class="group/field">
                                <label for="password_confirmation" class="flex items-center space-x-2 text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-pink-500 to-purple-500 rounded-md flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span>Konfirmasi Password Baru</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation"
                                           type="password"
                                           name="password_confirmation"
                                           class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-pink-500 dark:focus:border-pink-500 focus:ring-4 focus:ring-pink-500/20 transition-all duration-300 font-semibold text-gray-900 dark:text-gray-100 shadow-md hover:shadow-lg placeholder-gray-400 dark:placeholder-gray-500"
                                           placeholder="Ulangi password baru">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Pastikan password sama dengan yang di atas</span>
                                </p>
                            </div>

                            <!-- Info Box -->
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded-r-xl">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-yellow-800 dark:text-yellow-300 mb-1">Informasi Penting</h4>
                                        <ul class="text-xs text-yellow-700 dark:text-yellow-400 space-y-1">
                                            <li>• Role karyawan tidak dapat diubah menjadi admin</li>
                                            <li>• Email harus unik dan belum terdaftar oleh user lain</li>
                                            <li>• Password hanya akan diupdate jika field password diisi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                                <!-- Submit Button -->
                                <button type="submit"
                                        class="w-full sm:w-auto group/btn relative overflow-hidden bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold py-3 px-8 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                    <svg class="relative z-10 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="relative z-10">Update Karyawan</span>
                                </button>

                                <!-- Cancel Button -->
                                <a href="{{ route('karyawan.index') }}"
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
