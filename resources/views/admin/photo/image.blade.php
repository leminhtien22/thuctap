@extends('layouts.dashboard')

@section('title')
    {{ __('Photo Management') }}
@endsection

@php
    $columns = ['Image', 'Link', 'Created At', 'Actions'];
@endphp

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[ 
        ['url' => 'admin.photo', 'label' => 'Photo Management'],
    ]" />

    <!-- Photo Upload Form -->
    <div class="mb-8">
        <form class="space-y-4 md:space-y-6" action="{{ route('admin.photo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ __('Upload Image') }}
                </label>
                <input type="file" name="image" id="image" accept="image/*" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                @error('image')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <x-ui.button type="submit" class="bg-blue-500 hover:bg-blue-600">
                {{ __('Upload') }}
            </x-ui.button>
        </form>
    </div>

    <!-- Image List -->
    <x-ui.table :columns="$columns">
        <x-slot:body>
            @forelse ($images as $image)
                <x-ui.table-row>
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/' . $image->url) }}" class="w-16 h-16 rounded-md" alt="Image">
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <input id="image-link-{{ $image->id }}" type="text" value="{{ asset('storage/' . $image->url) }}" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <button onclick="copyLink('image-link-{{ $image->id }}')" class="text-blue-600 hover:underline">Copy</button>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $image->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-nowrap">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-image-{{ $image->id }}').submit();" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                            {{ __('Delete') }}
                        </a>
                        <form id="delete-image-{{ $image->id }}" action="{{ route('admin.photo.delete', $image->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </x-ui.table-row>
            @empty
                <x-ui.table-row>
                    <td class="px-6 py-4 text-center dark:text-white" colspan="{{ count($columns) }}">
                        No images available
                    </td>
                </x-ui.table-row>
            @endforelse
        </x-slot:body>
    </x-ui.table>

    <!-- Pagination -->
    <div class="mt-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow sm:flex sm:items-center sm:justify-between">
        <x-common.pagination-info :paginator="$images" unit="image" />
        <x-ui.pagination :paginator="$images" />
    </div>
@endsection

<script>
    function copyLink(inputId) {
        const input = document.getElementById(inputId);
        input.select();
        document.execCommand('copy');
        alert('Copied image link: ' + input.value);
    }
</script>
