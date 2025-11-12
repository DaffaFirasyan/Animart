<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Animated Gradient Background */
            @keyframes gradient-shift {
                0%, 100% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
            }

            .animate-gradient {
                background-size: 200% 200%;
                animation: gradient-shift 15s ease infinite;
            }

            /* Floating Animation */
            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-20px);
                }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            /* Pulse Glow */
            @keyframes pulse-glow {
                0%, 100% {
                    opacity: 0.5;
                }
                50% {
                    opacity: 0.8;
                }
            }

            .animate-pulse-glow {
                animation: pulse-glow 3s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden animate-gradient bg-gradient-to-br from-orange-50 via-yellow-50 to-red-50 dark:from-gray-900 dark:via-orange-950 dark:to-red-950">
            
            <!-- Animated Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <!-- Large Blur Circles -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-red-400/20 to-transparent rounded-full blur-3xl animate-pulse-glow"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-yellow-400/20 to-transparent rounded-full blur-3xl animate-pulse-glow" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[32rem] h-[32rem] bg-gradient-to-br from-orange-400/10 to-transparent rounded-full blur-3xl animate-pulse-glow" style="animation-delay: 2s;"></div>
                
                <!-- Animated Shapes -->
                <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-br from-red-500/10 to-orange-500/10 rounded-3xl rotate-12 animate-float"></div>
                <div class="absolute bottom-20 right-20 w-40 h-40 bg-gradient-to-br from-yellow-500/10 to-red-500/10 rounded-3xl -rotate-12 animate-float" style="animation-delay: 2s;"></div>
                <div class="absolute top-1/3 right-1/4 w-24 h-24 bg-gradient-to-br from-orange-500/10 to-yellow-500/10 rounded-full animate-float" style="animation-delay: 1s;"></div>
                
                <!-- Grid Pattern -->
                <div class="absolute inset-0 opacity-[0.02] dark:opacity-[0.05]">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')]"></div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="relative z-10 w-full sm:max-w-md px-4">
                {{ $slot }}
            </div>

            <!-- Footer Info -->
            <div class="relative z-10 mt-8 text-center px-4">
                <div class="inline-flex items-center space-x-2 px-6 py-3 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full shadow-lg border border-orange-200 dark:border-orange-900/50">
                    <div class="w-2 h-2 bg-gradient-to-r from-red-500 to-orange-500 rounded-full animate-pulse"></div>
                    <p class="text-sm font-semibold bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 dark:from-red-400 dark:via-orange-400 dark:to-yellow-400 bg-clip-text text-transparent">
                        Ricebowl Animart System
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>