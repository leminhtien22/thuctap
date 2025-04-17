@props(['paginator', 'class' => '', 'unit' => 'kết quả'])

<span class="text-sm text-gray-700 dark:text-gray-400">
    {{ __('Hiển thị ') }}
    <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->firstItem() }}</span>
    {{ __('đến ') }}
    <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->lastItem() }}</span>
    {{ __('của ') }}
    <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->total() }}</span>
    {{ $unit }}
</span>
