@props([
    'name' => '',
    'type' => 'text',
    'label',
    'required' => false,
    'value' => null,
    'placeholder' => null,
    'autofocus' => false,
    'autocomplete' => 'off',
    'readonly' => false,
    'description' => null,
    'min' => null,
    'light' => true
])

<div>
    <label for="{{ $name }}"
        class="block mb-2 text-sm font-medium @error($name) text-red-700 dark:text-red-500 @else {{ $light ? 'text-gray-900' : 'text-white' }} @enderror">{{ $label }}</label>

    <input
        type="{{ $type }}"
        name="{{ $name }}" 
        id="{{ $name }}"
        class="bg-gray-50 border border-gray-300 text-sm text-gray-900 rounded-lg @error($name) bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 block w-full @else focus:ring-primary-600 focus:border-primary-600 @enderror  block w-full p-2.5"
        placeholder="{{ $placeholder }}"
        name="{{ $name }}" 
        value="{{ $value }}"
        {{ $required ? 'required' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $autocomplete ? 'autocomplete' : '' }}
        {{ $readonly ? 'readonly' : ''}}
        {{ $min ? 'min="' . $min . '"' : '' }}
    >

    @if ($description)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    @endif

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
