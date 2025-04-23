@extends('layouts.dashboard')

@section('title')
    {{ __('Update Image') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.photo', 'label' => 'Image Management'],
        ['url' => 'admin.photo.edit', 'label' => 'Update Image'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.photo.update', $image->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <div>
            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Current Image') }}
            </label>
            <img src="{{ asset('storage/' . $image->url) }}" class="w-16 h-16 rounded-md mb-4" alt="Current Image">
        </div>

        <div>
            <label for="new_image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Upload New Image (if you want to change)') }}
            </label>
            <input type="file" name="new_image" id="new_image" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
            @error('new_image')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Save Changes') }}
        </x-ui.button>
    </form>
@endsection

<script>
    function previewAvatar(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imgReview');
            output.classList.remove('hidden');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
