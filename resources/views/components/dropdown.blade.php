@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-gray-800'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        // [PERBAIKAN] Tambahkan logika ini
        // 'bottom-full' -> posisikan di atas trigger
        // 'origin-bottom-right' -> animasi muncul dari kanan bawah
        $alignmentClasses = 'origin-bottom-right right-0 bottom-full mb-2';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-50 {{ $width }} rounded-xl shadow-2xl shadow-red-500/20 border-2 border-red-100 dark:border-red-800 {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-xl ring-1 ring-red-200/50 dark:ring-red-700/50 {{ $contentClasses }} overflow-hidden bg-gradient-to-br from-white via-red-50/20 to-yellow-50/20 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900">
            {{ $content }}
        </div>
    </div>
</div>