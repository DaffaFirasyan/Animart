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
      x-bind:class="{ 'dark': darkMode }"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* ===== CUSTOM SCROLLBAR ===== */
            ::-webkit-scrollbar {
                width: 12px;
                height: 12px;
            }
            
            ::-webkit-scrollbar-track {
                background: linear-gradient(180deg, #fef3c7 0%, #fed7aa 100%);
                border-radius: 10px;
                margin: 4px;
            }
            
            .dark ::-webkit-scrollbar-track {
                background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            }
            
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, #ef4444 0%, #f59e0b 50%, #ef4444 100%);
                border-radius: 10px;
                border: 2px solid transparent;
                background-clip: padding-box;
                box-shadow: inset 0 0 6px rgba(0,0,0,0.2);
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(135deg, #dc2626 0%, #d97706 50%, #dc2626 100%);
                box-shadow: inset 0 0 8px rgba(0,0,0,0.3);
            }

            /* ===== GRADIENT ANIMATIONS ===== */
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            @keyframes gradientRotate {
                0% { background-position: 0% 0%; }
                25% { background-position: 100% 0%; }
                50% { background-position: 100% 100%; }
                75% { background-position: 0% 100%; }
                100% { background-position: 0% 0%; }
            }

            .gradient-animate {
                background-size: 200% 200%;
                animation: gradientShift 10s ease infinite;
            }

            .gradient-rotate {
                background-size: 400% 400%;
                animation: gradientRotate 15s ease infinite;
            }

            /* ===== PULSE & FLOAT ANIMATIONS ===== */
            @keyframes pulse-soft {
                0%, 100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.85; transform: scale(1.05); }
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            @keyframes float-slow {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(5deg); }
            }

            .animate-pulse-soft {
                animation: pulse-soft 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            .animate-float {
                animation: float 4s ease-in-out infinite;
            }

            .animate-float-slow {
                animation: float-slow 6s ease-in-out infinite;
            }

            /* ===== SHINE EFFECT ===== */
            @keyframes shine {
                0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
                100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
            }

            .shine-effect {
                position: relative;
                overflow: hidden;
            }

            .shine-effect::after {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(
                    45deg,
                    transparent 30%,
                    rgba(255, 255, 255, 0.3) 50%,
                    transparent 70%
                );
                animation: shine 6s infinite;
            }

            /* ===== GLOW EFFECTS ===== */
            .glow-red {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.3),
                            0 0 40px rgba(239, 68, 68, 0.2),
                            0 0 60px rgba(239, 68, 68, 0.1);
            }

            .glow-yellow {
                box-shadow: 0 0 20px rgba(245, 158, 11, 0.3),
                            0 0 40px rgba(245, 158, 11, 0.2),
                            0 0 60px rgba(245, 158, 11, 0.1);
            }

            .glow-mixed {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.2),
                            0 0 40px rgba(245, 158, 11, 0.2),
                            0 0 60px rgba(251, 146, 60, 0.1);
            }

            /* ===== BACKGROUND PATTERNS ===== */
            .pattern-dots {
                background-image: radial-gradient(circle at 1px 1px, currentColor 1px, transparent 0);
                background-size: 24px 24px;
            }

            .pattern-grid {
                background-image: 
                    linear-gradient(currentColor 1px, transparent 1px),
                    linear-gradient(90deg, currentColor 1px, transparent 1px);
                background-size: 40px 40px;
            }

            .pattern-diagonal {
                background-image: repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    currentColor 10px,
                    currentColor 11px
                );
            }

            /* ===== RICE BOWL DECORATIVE ELEMENTS ===== */
            @keyframes steam {
                0%, 100% { 
                    transform: translateY(0) translateX(0) scaleX(1);
                    opacity: 0.6;
                }
                50% { 
                    transform: translateY(-20px) translateX(5px) scaleX(1.2);
                    opacity: 0.3;
                }
            }

            .steam-effect {
                animation: steam 3s ease-in-out infinite;
            }

            /* ===== CARD HOVER EFFECTS ===== */
            .card-hover {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .card-hover:hover {
                transform: translateY(-4px) scale(1.01);
                box-shadow: 0 20px 40px rgba(239, 68, 68, 0.15),
                            0 10px 20px rgba(245, 158, 11, 0.15);
            }

            /* ===== TEXT GRADIENT ===== */
            .text-gradient-brand {
                background: linear-gradient(135deg, #ef4444 0%, #f59e0b 50%, #f97316 100%);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            /* ===== BUTTON RIPPLE EFFECT ===== */
            .ripple {
                position: relative;
                overflow: hidden;
            }

            .ripple::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.5);
                transform: translate(-50%, -50%);
                transition: width 0.6s, height 0.6s;
            }

            .ripple:active::before {
                width: 300px;
                height: 300px;
            }

            /* ===== GLASSMORPHISM ===== */
            .glass {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px) saturate(180%);
                -webkit-backdrop-filter: blur(16px) saturate(180%);
            }

            .dark .glass {
                background: rgba(31, 41, 55, 0.85);
            }

            /* ===== SKELETON LOADING ===== */
            @keyframes shimmer {
                0% { background-position: -1000px 0; }
                100% { background-position: 1000px 0; }
            }

            .skeleton {
                animation: shimmer 2s infinite;
                background: linear-gradient(
                    90deg,
                    rgba(239, 68, 68, 0.1) 0%,
                    rgba(245, 158, 11, 0.2) 50%,
                    rgba(239, 68, 68, 0.1) 100%
                );
                background-size: 1000px 100%;
            }
        </style>
    </head>
    <body class="font-sans antialiased relative overflow-hidden">
        
        <!-- Animated Background -->
        <div class="fixed inset-0 -z-10 bg-gradient-to-br from-red-50 via-yellow-50 via-orange-50 to-red-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 gradient-rotate"></div>
        
        <!-- Decorative Background Elements -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <!-- Floating Orbs -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-red-400/20 dark:bg-red-600/10 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-400/20 dark:bg-yellow-600/10 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-orange-400/20 dark:bg-orange-600/10 rounded-full blur-3xl animate-float-slow" style="animation-delay: 2s;"></div>
            
            <!-- Pattern Overlay -->
            <div class="absolute inset-0 pattern-dots opacity-[0.03] dark:opacity-[0.05] text-red-600"></div>
        </div>

        <div x-data="{ 
                sidebarOpen: false, 
                sidebarFull: window.innerWidth > 1024 ? true : false,
             }"
             x-init="$watch('sidebarFull', val => { 
                localStorage.setItem('sidebarFull', val);
             });
             sidebarFull = localStorage.getItem('sidebarFull') === 'true';"
             class="flex h-screen overflow-hidden relative"
        >

            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex flex-col flex-1 w-0 overflow-hidden">
                
                <!-- Premium Header dengan Multiple Effects -->
                <header class="sticky top-0 z-10 flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 flex-shrink-0 glass border-b border-red-100/50 dark:border-red-900/30 shadow-xl">
                    
                    <!-- Gradient Accent Bar -->
                    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-red-500 via-yellow-500 via-orange-500 to-red-500 gradient-animate"></div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Enhanced Mobile Menu Button -->
                        <button @click="sidebarOpen = true" type="button"
                                class="lg:hidden p-2.5 -ml-2.5 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gradient-to-br hover:from-red-500 hover:to-yellow-500 hover:text-white transition-all duration-300 transform hover:scale-110 active:scale-95 shadow-lg hover:shadow-2xl ripple relative group">
                            <span class="sr-only">Buka sidebar</span>
                            <svg class="h-6 w-6 relative z-10" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Tooltip -->
                            <span class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                Menu
                            </span>
                        </button>

                        <!-- Header Title with Enhanced Typography -->
                        <div class="flex items-center space-x-3">
                            @if (isset($header))
                                <div class="relative shine-effect">
                                    <h1 class="font-bold text-xl sm:text-2xl text-gradient-brand tracking-tight drop-shadow-sm">
                                        {{ $header }}
                                    </h1>
                                </div>
                            @endif
                        </div>
                    </div>

                </header>

                <!-- Enhanced Main Content Area -->
                <main class="flex-1 overflow-y-auto relative">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 pointer-events-none opacity-[0.02] dark:opacity-[0.03]">
                        <div class="absolute inset-0 pattern-grid text-red-600"></div>
                    </div>

                    <!-- Content Container with Enhanced Padding -->
                    <div class="relative p-4 sm:p-6 lg:p-8">
                        <!-- Decorative Corner Accents -->
                        <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-red-500/5 to-transparent rounded-br-full pointer-events-none"></div>
                        <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-tl from-yellow-500/5 to-transparent rounded-tl-full pointer-events-none"></div>
                        
                        <!-- Main Content Slot -->
                        <div class="relative z-10">
                            {{ $slot }}
                        </div>
                    </div>
                </main>

            </div>
        </div>

        <!-- Premium Loading Indicator -->
        <div x-data="{ loading: false }" 
             x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-md z-50 flex items-center justify-center"
             style="display: none;">
            <div class="glass rounded-3xl p-10 shadow-2xl border border-white/20 dark:border-gray-700/50 transform scale-100">
                <div class="flex flex-col items-center space-y-6">
                    <!-- Animated Rice Bowl Loading -->
                    <div class="relative">
                        <div class="w-20 h-20 border-4 border-transparent border-t-red-500 border-r-yellow-500 border-b-orange-500 rounded-full animate-spin"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-yellow-500 rounded-full animate-pulse-soft"></div>
                        </div>
                    </div>
                    
                    <!-- Loading Text -->
                    <div class="text-center space-y-2">
                        <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">Memuat...</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Mohon tunggu sebentar</p>
                    </div>

                    <!-- Animated Dots -->
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-red-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notification Container (Optional) -->
        <div x-data="{ show: false, message: '' }"
             @toast.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed bottom-4 right-4 z-50 max-w-sm"
             style="display: none;">
            <div class="glass rounded-2xl p-4 shadow-2xl border border-red-200/50 dark:border-red-800/50 flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-yellow-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-800 dark:text-gray-200 font-medium" x-text="message"></p>
            </div>
        </div>
    </body>
</html>