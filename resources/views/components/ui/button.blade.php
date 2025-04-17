@props(['icon' => null, 'type' => 'button', 'href' => null, 'class' => ''])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => 'flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 ' . $class]) }}>
        {{ $icon }}

        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->merge(['class' => 'flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 ' . $class]) }}>
        {{ $icon }}

        {{ $slot }}
    </button>
@endif
