<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen"
     class="fixed inset-0 z-40 flex lg:hidden"
     x-cloak
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <!-- Enhanced Backdrop with Blur and Gradient -->
    <div x-show="sidebarOpen"
         @click.away="sidebarOpen = false"
         class="fixed inset-0 bg-gradient-to-br from-gray-900/80 via-red-900/40 to-orange-900/40 dark:from-black/90 dark:via-red-950/60 dark:to-orange-950/60 backdrop-blur-sm"
         x-transition:enter="ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Mobile Sidebar Panel with Enhanced Shadow -->
    <div x-show="sidebarOpen"
         class="relative flex-1 flex flex-col max-w-xs w-full"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full">

        <!-- Enhanced Close Button with Animart Theme -->
        <div class="absolute top-0 right-0 -mr-12 pt-2">
            <button @click="sidebarOpen = false"
                    type="button"
                    class="ml-1 flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 hover:from-red-600 hover:via-orange-600 hover:to-yellow-600 shadow-xl shadow-orange-500/50 hover:shadow-2xl hover:shadow-orange-500/60 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 hover:scale-110 active:scale-95 group">
                <span class="sr-only">Tutup sidebar</span>
                <!-- X Icon with Animation -->
                <svg class="h-7 w-7 text-white transition-transform duration-300 group-hover:rotate-90 drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Sidebar Container with Premium Shadow -->
        <div x-data="{ sidebarFull: true }"
             class="flex-1 flex flex-col min-h-0 shadow-2xl shadow-red-900/20 dark:shadow-black/40 ring-1 ring-orange-500/10">
            @include('layouts.navigation-content')
        </div>
    </div>

    <!-- Decorative Corner Accent (Mobile) -->
    <div class="fixed top-0 left-0 w-32 h-32 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-red-500/20 via-orange-500/10 to-transparent rounded-br-full blur-2xl"></div>
    </div>
</div>

<!-- Desktop Sidebar with Enhanced Design -->
<div class="hidden lg:flex lg:flex-shrink-0 relative">
    <!-- Decorative Glow Effect (Desktop) -->
    <div class="absolute -inset-1 bg-gradient-to-br from-red-500/5 via-orange-500/5 to-yellow-500/5 rounded-r-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
    
    <div class="flex flex-col transition-all duration-500 ease-in-out shadow-2xl shadow-gray-900/10 dark:shadow-black/30 relative z-10 group rounded-r-2xl overflow-hidden"
         :class="{ 'w-64': sidebarFull, 'w-20': !sidebarFull }">
        
        <!-- Animated Border Gradient -->
        <div class="absolute inset-y-0 right-0 w-1 bg-gradient-to-b from-red-500 via-orange-500 to-yellow-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        @include('layouts.navigation-content')
    </div>

    <!-- Floating Action Hint (appears on hover when collapsed) -->
    <div x-show="!sidebarFull" 
         x-cloak
         class="absolute left-full ml-2 top-8 bg-gradient-to-r from-red-500 to-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap text-sm font-semibold">
        <div class="absolute left-0 top-1/2 -translate-x-1/2 -translate-y-1/2 rotate-45 w-2 h-2 bg-red-500"></div>
        Klik logo untuk expand
    </div>
</div>

<style>
/* Custom smooth transitions for sidebar */
@media (min-width: 1024px) {
    .lg\:flex-shrink-0 {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
}

/* Enhanced backdrop blur for better performance */
@supports (backdrop-filter: blur(8px)) or (-webkit-backdrop-filter: blur(8px)) {
    .backdrop-blur-sm {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
}

/* Smooth scale animation */
@keyframes smoothScale {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Remove default focus styles and add custom ones */
button:focus:not(:focus-visible) {
    outline: none;
}

button:focus-visible {
    outline: 2px solid rgba(251, 191, 36, 0.5);
    outline-offset: 2px;
}
</style>