<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: localStorage.getItem('darkMode') === 'true' || 
                    (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          
          toggleDarkMode() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('darkMode', this.darkMode);
          }
      }"
      x-init="$watch('darkMode', val => {
          if (val) { document.documentElement.classList.add('dark'); } 
          else { document.documentElement.classList.remove('dark'); }
      }); 
      if (darkMode) { document.documentElement.classList.add('dark'); }"
      x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Animart</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Ricebowl Animart Theme */
        :root {
            --ricebowl-red: #DC2626;
            --ricebowl-red-dark: #B91C1C;
            --ricebowl-yellow: #FBBF24;
            --ricebowl-yellow-dark: #F59E0B;
            --ricebowl-orange: #F97316;
        }

        /* Custom Animations */
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(220, 38, 38, 0.3),
                            0 0 40px rgba(251, 191, 36, 0.2);
            }
            50% { 
                box-shadow: 0 0 30px rgba(220, 38, 38, 0.5),
                            0 0 60px rgba(251, 191, 36, 0.4);
            }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes bowl-bounce {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-gradient { 
            background-size: 300% 300%;
            animation: gradient-shift 15s ease infinite;
        }
        
        .animate-float { animation: float 10s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out; }
        .bowl-bounce { animation: bowl-bounce 2s ease-in-out infinite; }
        .spin-slow { animation: spin-slow 20s linear infinite; }

        /* Input Focus Effects */
        .input-ricebowl {
            transition: all 0.3s ease;
        }

        .input-ricebowl:focus {
            transform: translateY(-2px);
        }

        /* Button Shine Effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }

        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-shine:hover::before {
            left: 100%;
        }

        /* Card Shadow */
        .card-ricebowl {
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.1),
                        0 0 40px rgba(251, 191, 36, 0.1);
        }

        .dark .card-ricebowl {
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.2),
                        0 0 40px rgba(251, 191, 36, 0.15);
        }

        /* Steam Effect for Decoration */
        @keyframes steam {
            0% {
                transform: translateY(0) scaleX(1);
                opacity: 0.6;
            }
            50% {
                transform: translateY(-15px) scaleX(1.2);
                opacity: 0.3;
            }
            100% {
                transform: translateY(-30px) scaleX(0.8);
                opacity: 0;
            }
        }

        .steam {
            animation: steam 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Full Page Container with Animated Background -->
    <div class="min-h-screen flex items-center justify-center p-3 relative overflow-hidden animate-gradient bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 dark:from-gray-900 dark:via-red-950 dark:to-orange-950">
        
        <!-- Dark Mode Toggle Button -->
        <button @click="toggleDarkMode()" 
                class="fixed top-4 right-4 z-50 p-2.5 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full shadow-lg hover:shadow-xl transition-all duration-300 group hover:scale-110 border-2 border-orange-200 dark:border-orange-800">
            <svg x-show="!darkMode" class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </button>

        <!-- Animated Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Large Animated Circles -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-gradient-to-br from-red-400/20 to-transparent rounded-full blur-3xl animate-pulse-glow"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-gradient-to-tr from-yellow-400/20 to-transparent rounded-full blur-3xl animate-pulse-glow" style="animation-delay: 2s;"></div>
            
            <!-- Floating Rice Bowl Shapes -->
            <div class="absolute top-20 left-10 sm:left-20 w-20 h-20 sm:w-32 sm:h-32 opacity-10 dark:opacity-5 animate-float">
                <svg class="w-full h-full text-red-600" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" opacity="0.3"/>
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </div>
            <div class="absolute bottom-20 right-10 sm:right-20 w-24 h-24 sm:w-40 sm:h-40 opacity-10 dark:opacity-5 animate-float" style="animation-delay: 3s;">
                <svg class="w-full h-full text-yellow-600 spin-slow" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="8" opacity="0.2"/>
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>

            <!-- Decorative Pattern -->
            <div class="absolute top-1/4 right-1/4 w-64 h-64 opacity-5 dark:opacity-10">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0RDMjYyNiIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-30"></div>
            </div>
        </div>

        <!-- Register Content -->
        <div class="relative z-10 w-full max-w-sm animate-fade-in-up">

            <!-- Register Card -->
            <div class="relative bg-white dark:bg-gray-800 shadow-2xl overflow-hidden rounded-2xl border-2 border-red-100 dark:border-red-900/30 card-ricebowl">
                
                <!-- Animated Header Section -->
                <div class="relative bg-gradient-to-br from-red-600 via-orange-600 to-yellow-600 px-4 py-4 overflow-hidden">
                    <!-- Animated Pattern Overlay -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')]"></div>
                    </div>

                    <!-- Steam Effects -->
                    <div class="absolute top-2 left-10 w-6 h-8 bg-white/20 rounded-full blur-md steam"></div>
                    <div class="absolute top-2 right-12 w-5 h-7 bg-white/15 rounded-full blur-md steam" style="animation-delay: 1s;"></div>
                    
                    <div class="relative text-center">
                        
                        <h1 class="text-2xl font-extrabold text-white tracking-tight drop-shadow-lg mb-1">
                            Ricebowl Animart
                        </h1>
                        <p class="text-white/90 text-xs font-semibold">
                            🍜 Daftar Akun Baru
                        </p>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="px-5 py-4">

                    <form method="POST" action="{{ route('register') }}" class="space-y-3">
                        @csrf

                        <!-- Name Field -->
                        <div class="group">
                            <label for="name" class="flex items-center space-x-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                                <div class="w-5 h-5 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center shadow-md">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span>Nama Lengkap</span>
                            </label>
                            <div class="relative">
                                <input id="name" 
                                       type="text" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="name"
                                       class="input-ricebowl w-full px-3 py-2 pl-9 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-purple-500 dark:focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 font-semibold text-sm text-gray-900 dark:text-gray-100 shadow-sm hover:shadow-md placeholder-gray-400 dark:placeholder-gray-500"
                                       placeholder="Masukkan nama lengkap Anda">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1 animate-fade-in-up">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="group">
                            <label for="email" class="flex items-center space-x-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                                <div class="w-5 h-5 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center shadow-md">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span>Email</span>
                            </label>
                            <div class="relative">
                                <input id="email" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="username"
                                       class="input-ricebowl w-full px-3 py-2 pl-9 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 font-semibold text-sm text-gray-900 dark:text-gray-100 shadow-sm hover:shadow-md placeholder-gray-400 dark:placeholder-gray-500"
                                       placeholder="nama@email.com">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1 animate-fade-in-up">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="flex items-center space-x-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                                <div class="w-5 h-5 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <span>Password</span>
                            </label>
                            <div class="relative">
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password"
                                       class="input-ricebowl w-full px-3 py-2 pl-9 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-red-500 dark:focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all duration-300 font-semibold text-sm text-gray-900 dark:text-gray-100 shadow-sm hover:shadow-md placeholder-gray-400 dark:placeholder-gray-500"
                                       placeholder="Minimal 8 karakter">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1 animate-fade-in-up">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="group">
                            <label for="password_confirmation" class="flex items-center space-x-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                                <div class="w-5 h-5 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span>Konfirmasi Password</span>
                            </label>
                            <div class="relative">
                                <input id="password_confirmation" 
                                       type="password" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       class="input-ricebowl w-full px-3 py-2 pl-9 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:border-yellow-500 dark:focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 transition-all duration-300 font-semibold text-sm text-gray-900 dark:text-gray-100 shadow-sm hover:shadow-md placeholder-gray-400 dark:placeholder-gray-500"
                                       placeholder="Ulangi password Anda">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400 font-semibold flex items-center space-x-1 animate-fade-in-up">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
                            <a href="{{ route('login') }}" 
                               class="text-xs font-bold text-red-600 hover:text-orange-600 dark:text-red-400 dark:hover:text-orange-400 transition-all duration-300 flex items-center space-x-1.5 group">
                                <svg class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span>Sudah punya akun?</span>
                            </a>

                            <button type="submit" 
                                    class="btn-shine w-full sm:w-auto group relative overflow-hidden bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 hover:from-red-700 hover:via-orange-700 hover:to-yellow-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-2 text-sm">
                                <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <span>Daftar Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer Security Badge -->
                <div class="px-5 py-2.5 bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-gray-700 dark:to-gray-700/50 border-t-2 border-orange-100 dark:border-gray-600">
                    <div class="flex items-center justify-center space-x-1.5 text-xs text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="font-semibold">Data diamankan dengan enkripsi</span>
                    </div>
                </div>
            </div>

            <!-- Footer Badge & Copyright -->
            <div class="mt-3 space-y-2">
                <!-- Brand Badge -->
                <div class="flex justify-center">
                    <div class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-full shadow-lg border-2 border-orange-200 dark:border-orange-900/50 hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center space-x-0.5">
                            <div class="w-1.5 h-1.5 bg-gradient-to-r from-red-500 to-orange-500 rounded-full animate-pulse"></div>
                            <div class="w-1.5 h-1.5 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full animate-pulse" style="animation-delay: 0.3s;"></div>
                            <div class="w-1.5 h-1.5 bg-gradient-to-r from-yellow-500 to-red-500 rounded-full animate-pulse" style="animation-delay: 0.6s;"></div>
                        </div>
                        <p class="text-xs font-bold bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 dark:from-red-400 dark:via-orange-400 dark:to-yellow-400 bg-clip-text text-transparent">
                            Ricebowl Animart System
                        </p>
                    </div>
                </div>
                
                <!-- Copyright -->
                <div class="text-center">
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium">
                        © 2024 <span class="font-extrabold text-orange-600 dark:text-orange-400">Ricebowl Animart</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 