<div class="flex flex-col h-full relative overflow-hidden bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 shadow-2xl">

    <!-- Logo Section with Enhanced Gradient -->
    <div @click.prevent="sidebarFull = !sidebarFull"
         class="flex items-center flex-shrink-0 relative cursor-pointer transition-all duration-500 ease-out bg-gradient-to-br from-red-600 via-red-500 to-yellow-500 dark:from-red-800 dark:via-red-700 dark:to-yellow-600 overflow-hidden group"
         :class="{ 'h-auto py-6': sidebarFull, 'h-16': !sidebarFull }"
         title="Toggle sidebar">

        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-gradient-to-br from-white to-transparent transform group-hover:scale-110 transition-transform duration-700"></div>
        </div>

        <!-- Decorative Corner Accent -->
        <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-400 dark:bg-yellow-500 opacity-20 rounded-bl-full transform translate-x-8 -translate-y-8"></div>

        <a href="{{ Auth::user()->isAdmin() ? route('dashboard') : route('kasir.index') }}"
           class="flex items-center gap-3 w-full h-full relative z-10 group-hover:scale-105 transition-transform duration-300"
           :class="{ 'px-6': sidebarFull, 'justify-center': !sidebarFull }">

            <img :src="sidebarFull ? '{{ asset('storage/logo-animart-2.png') }}' : '{{ asset('storage/logo-animart.png') }}'"
                 class="block w-auto flex-shrink-0 transition-all duration-500 filter drop-shadow-lg"
                 :class="{ 'h-36': sidebarFull, 'h-12': !sidebarFull }">
        </a>


    </div>

    <!-- Navigation with Enhanced Styling -->
    <nav class="flex-1 mt-8 px-4 space-y-3 overflow-y-auto relative z-10 scrollbar-thin scrollbar-thumb-red-300 dark:scrollbar-thumb-red-700 scrollbar-track-transparent">
        
        @php
            // LIGHT MODE Classes - Enhanced with better shadows and gradients
            $activeClassLight = 'bg-gradient-to-r from-red-500 via-red-600 to-yellow-500 text-white shadow-lg shadow-red-500/50 scale-105';
            $inactiveClassLight = 'text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-yellow-50 hover:text-red-700 hover:shadow-md hover:scale-102';

            // DARK MODE Classes - Enhanced with better shadows and gradients
            $activeClassDark = 'dark:bg-gradient-to-r dark:from-red-600 dark:via-red-700 dark:to-yellow-600 dark:text-white dark:shadow-lg dark:shadow-red-900/50';
            $inactiveClassDark = 'dark:text-gray-300 dark:hover:bg-gradient-to-r dark:hover:from-gray-700 dark:hover:to-gray-600 dark:hover:text-yellow-300 dark:hover:shadow-md';

            $activeClass = $activeClassLight . ' ' . $activeClassDark;
            $inactiveClass = $inactiveClassLight . ' ' . $inactiveClassDark;
            $baseClass = 'flex items-center py-3.5 px-5 text-sm font-semibold rounded-xl transition-all duration-300 ease-out relative overflow-hidden group/item';
        @endphp

        @if(Auth::user()->isAdmin())
        <!-- Dashboard (Admin Only) -->
        <a href="{{ route('dashboard') }}"
           class="{{ $baseClass }} {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}"
           :class="{ 'justify-start': sidebarFull, 'justify-center': !sidebarFull }">

            <!-- Hover Shimmer Effect -->
            <div class="absolute inset-0 -translate-x-full group-hover/item:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

            <svg class="flex-shrink-0 h-5 w-5 transition-transform duration-300 group-hover/item:scale-110 group-hover/item:rotate-12"
                 :class="{ 'mr-3': sidebarFull }"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h12A2.25 2.25 0 0020.25 14.25V3m-16.5 0h16.5M3.75 3H3v1.5M20.25 3H21v1.5M3.75 16.5c.621 0 1.125-.504 1.125-1.125V11.25h1.5v3.375c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V11.25h1.5v3.375c0 .621.504 1.125 1.125 1.125M6.75 12h10.5" />
            </svg>

            <span x-show="sidebarFull" x-cloak class="relative z-10 font-bold tracking-wide">Dashboard</span>

            <!-- Active Indicator -->
            @if(request()->routeIs('dashboard'))
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-yellow-300 rounded-r-full shadow-lg"></div>
            @endif
        </a>
        @endif

        <!-- Kasir -->
        <a href="{{ route('kasir.index') }}"
           class="{{ $baseClass }} {{ request()->routeIs('kasir.index') ? $activeClass : $inactiveClass }}"
           :class="{ 'justify-start': sidebarFull, 'justify-center': !sidebarFull }">

            <div class="absolute inset-0 -translate-x-full group-hover/item:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

            <svg class="flex-shrink-0 h-5 w-5 transition-transform duration-300 group-hover/item:scale-110 group-hover/item:-rotate-12" 
                 :class="{ 'mr-3': sidebarFull }" 
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>

            <span x-show="sidebarFull" x-cloak class="relative z-10 font-bold tracking-wide">Kasir</span>
            
            @if(request()->routeIs('kasir.index'))
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-yellow-300 rounded-r-full shadow-lg"></div>
            @endif
        </a>

        @if(Auth::user()->isAdmin())
        <!-- Laporan (Admin Only) -->
        <a href="{{ route('laporan.index') }}"
           class="{{ $baseClass }} {{ request()->routeIs('laporan.index') ? $activeClass : $inactiveClass }}"
           :class="{ 'justify-start': sidebarFull, 'justify-center': !sidebarFull }">

            <div class="absolute inset-0 -translate-x-full group-hover/item:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

            <svg class="flex-shrink-0 h-5 w-5 transition-transform duration-300 group-hover/item:scale-110"
                 :class="{ 'mr-3': sidebarFull }"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 100 15 7.5 7.5 0 000-15zM21 21l-5.197-5.197" />
            </svg>

            <span x-show="sidebarFull" x-cloak class="relative z-10 font-bold tracking-wide">Laporan</span>

            @if(request()->routeIs('laporan.index'))
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-yellow-300 rounded-r-full shadow-lg"></div>
            @endif
        </a>
        @endif

        @if(Auth::user()->isAdmin())
        <!-- Manajemen Stok (Admin Only) -->
        <a href="{{ route('bahan-baku.index') }}"
           class="{{ $baseClass }} {{ request()->routeIs('bahan-baku.*') ? $activeClass : $inactiveClass }}"
           :class="{ 'justify-start': sidebarFull, 'justify-center': !sidebarFull }">

            <div class="absolute inset-0 -translate-x-full group-hover/item:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

            <svg class="flex-shrink-0 h-5 w-5 transition-transform duration-300 group-hover/item:scale-110 group-hover/item:rotate-12"
                 :class="{ 'mr-3': sidebarFull }"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>

            <span x-show="sidebarFull" x-cloak class="relative z-10 font-bold tracking-wide">Manajemen Stok</span>

            @if(request()->routeIs('bahan-baku.*'))
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-yellow-300 rounded-r-full shadow-lg"></div>
            @endif
        </a>
        @endif

        @if(Auth::user()->isAdmin())
        <!-- Manajemen Menu (Admin Only) -->
        <a href="{{ route('menu.index') }}"
           class="{{ $baseClass }} {{ request()->routeIs('menu.*') ? $activeClass : $inactiveClass }}"
           :class="{ 'justify-start': sidebarFull, 'justify-center': !sidebarFull }">

            <div class="absolute inset-0 -translate-x-full group-hover/item:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

            <svg class="flex-shrink-0 h-5 w-5 transition-transform duration-300 group-hover/item:scale-110 group-hover/item:-rotate-12"
                 :class="{ 'mr-3': sidebarFull }"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>

            <span x-show="sidebarFull" x-cloak class="relative z-10 font-bold tracking-wide">Manajemen Menu</span>

            @if(request()->routeIs('menu.*'))
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-yellow-300 rounded-r-full shadow-lg"></div>
            @endif
        </a>
        @endif
    </nav>

    <!-- Decorative Divider -->
    <div class="px-4 py-2">
        <div class="h-px bg-gradient-to-r from-transparent via-red-300 dark:via-red-700 to-transparent"></div>
    </div>

    <!-- Bottom Section with Enhanced Design -->
    <div class="p-4 space-y-3 flex-shrink-0">

        <!-- Dark Mode Toggle with Beautiful Animation -->
        <button @click="toggleDarkMode" type="button"
                class="w-full flex items-center py-3.5 px-5 text-sm font-semibold rounded-xl transition-all duration-300 ease-out relative overflow-hidden group/toggle
                       text-gray-700 bg-gradient-to-r from-yellow-50 to-red-50 hover:from-yellow-100 hover:to-red-100 hover:shadow-lg hover:scale-102
                       dark:text-gray-200 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-600 dark:hover:from-gray-600 dark:hover:to-gray-700 dark:hover:shadow-lg"
                :class="{ 'justify-start': sidebarFull, 'justify-center': !sidebarFull }">

            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-200 to-red-200 dark:from-yellow-700 dark:to-red-700 opacity-0 group-hover/toggle:opacity-30 transition-opacity duration-300"></div>

            <div class="relative z-10 flex items-center" :class="{ 'w-full': sidebarFull }">
                <!-- Sun Icon -->
                <svg x-show="!darkMode" 
                     class="h-5 w-5 flex-shrink-0 transition-all duration-500 group-hover/toggle:rotate-180 group-hover/toggle:scale-110 text-yellow-600 dark:text-yellow-400" 
                     :class="{ 'mr-3': sidebarFull }" 
                     fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-6.364-.386l1.591-1.591M3 12H.75m.386-6.364l1.591 1.591" />
                </svg>
                
                <!-- Moon Icon -->
                <svg x-show="darkMode" x-cloak 
                     class="h-5 w-5 flex-shrink-0 transition-all duration-500 group-hover/toggle:rotate-[-20deg] group-hover/toggle:scale-110 text-blue-500" 
                     :class="{ 'mr-3': sidebarFull }" 
                     fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 008.25-4.498z" />
                </svg>

                <span x-show="sidebarFull" x-cloak class="font-bold tracking-wide">
                    <span x-show="!darkMode">Mode Gelap</span>
                    <span x-show="darkMode" x-cloak>Mode Terang</span>
                </span>
            </div>
        </button>

        <!-- User Profile with Premium Design -->
        <div class="relative">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button class="w-full flex items-center p-4 text-sm font-semibold rounded-xl focus:outline-none transition-all duration-300 ease-out relative overflow-hidden group/profile
                                   bg-gradient-to-r from-red-100 via-red-50 to-yellow-100 hover:from-red-200 hover:via-red-100 hover:to-yellow-200 hover:shadow-xl hover:scale-102
                                   dark:from-red-900/30 dark:via-red-800/30 dark:to-yellow-900/30 dark:hover:from-red-800/50 dark:hover:via-red-700/50 dark:hover:to-yellow-800/50 dark:hover:shadow-xl
                                   border-2 border-red-200 dark:border-red-700"
                            :class="{ 'justify-start': sidebarFull, 'justify-center': !sidebarFull }">

                        <!-- Shimmer Effect -->
                        <div class="absolute inset-0 -translate-x-full group-hover/profile:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>

                        <div class="relative flex-shrink-0">
                            <!-- Avatar with Gradient Border -->
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-red-500 via-red-600 to-yellow-500 dark:from-red-600 dark:via-red-700 dark:to-yellow-600 flex items-center justify-center shadow-lg ring-2 ring-white dark:ring-gray-800 transition-transform duration-300 group-hover/profile:scale-110 group-hover/profile:rotate-6">
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            
                            <!-- Online Status Indicator with Pulse -->
                            <div class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full">
                                <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-75"></div>
                            </div>
                        </div>

                        <div class="ml-3 text-left flex-1 min-w-0 relative z-10" x-show="sidebarFull" x-cloak>
                            <div class="truncate font-bold text-gray-900 dark:text-white text-sm tracking-wide">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></div>
                                <div class="text-xs text-gray-600 dark:text-gray-300 font-semibold">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                        </div>

                        <svg class="ml-auto h-5 w-5 text-gray-600 dark:text-gray-400 transition-transform duration-300 group-hover/profile:translate-y-0.5 relative z-10" 
                             x-show="sidebarFull" x-cloak 
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    <!-- Bottom Decorative Accent -->
    <div class="h-1 bg-gradient-to-r from-red-600 via-yellow-500 to-red-600"></div>

</div>

<style>
/* Custom Scrollbar untuk sidebar */
.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(239, 68, 68, 0.3);
    border-radius: 3px;
}

.dark .scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(185, 28, 28, 0.5);
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(239, 68, 68, 0.5);
}

.dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(185, 28, 28, 0.7);
}

/* Smooth scale utilities */
.scale-102 {
    transform: scale(1.02);
}

/* Prevent layout shift during hover */
a, button {
    backface-visibility: hidden;
    transform: translateZ(0);
}
</style>