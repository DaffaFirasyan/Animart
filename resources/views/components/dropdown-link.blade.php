<a {{ $attributes->merge(['class' => 'block w-full px-4 py-3 text-start text-sm font-medium leading-5 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-red-50 hover:to-yellow-50 dark:hover:from-red-900/30 dark:hover:to-yellow-900/30 hover:text-red-700 dark:hover:text-red-400 focus:outline-none focus:bg-gradient-to-r focus:from-red-100 focus:to-yellow-100 dark:focus:from-red-900/40 dark:focus:to-yellow-900/40 transition-all duration-200 ease-in-out relative overflow-hidden group']) }}>
    <div class="absolute inset-0 bg-gradient-to-r from-red-600/5 to-yellow-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
    <span class="relative z-10">{{ $slot }}</span>
</a>
