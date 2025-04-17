@props(['type' => 'info'])

@php
    $colorClasses = [
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    ];

    $alertClass = $colorClasses[$type] ?? $colorClasses['info']; // Mặc định là màu xanh nếu không có màu hợp lệ
@endphp

<div {{ $attributes->merge(['class' => 'p-4 mb-4 text-sm rounded-lg ' . $alertClass]) }} role="alert" id='alert'>
    {{ $slot }}
</div>
