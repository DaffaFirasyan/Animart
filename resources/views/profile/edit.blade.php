<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="flex items-baseline space-x-3">
                <h2 class="font-bold text-3xl sm:text-4xl bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 dark:from-red-400 dark:via-orange-400 dark:to-yellow-400 bg-clip-text text-transparent leading-tight tracking-tight drop-shadow-[0_2px_8px_rgba(239,68,68,0.3)] dark:drop-shadow-[0_2px_12px_rgba(239,68,68,0.5)]">
                    {{ __('Profile') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Kelola informasi akun Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Section 1: Update Profile Information -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-white to-orange-50 dark:from-gray-800 dark:to-orange-900/10 shadow-2xl rounded-2xl border-2 border-orange-100 dark:border-orange-900/30">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-yellow-500/10 to-transparent rounded-bl-[5rem] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-gradient-to-tr from-red-500/10 to-transparent rounded-tr-[5rem] pointer-events-none"></div>
                
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500"></div>
                </div>

                <div class="relative p-6 sm:p-8">
                    <!-- Section Header -->
                    <div class="flex items-center space-x-4 mb-8 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-yellow-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Informasi Profile</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Perbarui nama dan email akun Anda</p>
                        </div>
                        <div class="hidden sm:block px-4 py-2 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg">
                            PROFILE
                        </div>
                    </div>

                    <!-- Profile Form Content -->
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Section 2: Update Password -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/10 shadow-2xl rounded-2xl border-2 border-blue-100 dark:border-blue-900/30">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-cyan-500/10 to-transparent rounded-bl-[5rem] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-gradient-to-tr from-blue-500/10 to-transparent rounded-tr-[5rem] pointer-events-none"></div>
                
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-cyan-500 to-blue-500"></div>
                </div>

                <div class="relative p-6 sm:p-8">
                    <!-- Section Header -->
                    <div class="flex items-center space-x-4 mb-8 pb-6 border-b-2 border-gray-200 dark:border-gray-700">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl blur-md opacity-50 animate-pulse"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 via-cyan-500 to-blue-500 rounded-xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">Keamanan Password</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium mt-1">Ubah password untuk keamanan akun</p>
                        </div>
                        <div class="hidden sm:block px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-bold rounded-full shadow-lg">
                            SECURITY
                        </div>
                    </div>

                    <!-- Password Form Content -->
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Info Box - Best Practices -->
            <div class="relative overflow-hidden bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 border-2 border-purple-200 dark:border-purple-800 p-6 rounded-2xl shadow-lg">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-bold text-purple-900 dark:text-purple-200 mb-3">💡 Tips Keamanan Akun</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-purple-800 dark:text-purple-300">
                            <div class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Gunakan password minimal 8 karakter</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Kombinasikan huruf besar, kecil, dan angka</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Jangan gunakan password yang sama</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Perbarui password secara berkala</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>