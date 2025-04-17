@props([
    'name' => '',
    'label',
    'required' => false,
    'value' => null,
    'placeholder' => null,
    'autofocus' => false,
    'autocomplete' => 'off',
    'readonly' => false,
    'description' => null,
    'rows' => '2',
    'light' => true
])

<div>
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium {{ $light ? 'text-gray-900' : 'text-white' }}">
        {{ $label }}
    </label>

    <textarea id="{{ $name }}" rows="{{ $rows }}"
        class="block p-2.5 w-full text-sm rounded-lg border @error($name) bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @else text-gray-900 bg-gray-50 border-gray-300 focus:ring-primary-600 focus:border-primary-600 @enderror"
        {{ $required ? 'required' : '' }} {{ $autofocus ? 'autofocus' : '' }} {{ $autocomplete ? 'autocomplete' : '' }}
        {{ $readonly ? 'readonly' : '' }} placeholder="{{ $placeholder }}" name="{{ $name }}">{{ $value }}</textarea>

    @if ($description)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    @endif

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
