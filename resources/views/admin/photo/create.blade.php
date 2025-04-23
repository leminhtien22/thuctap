@extends('layouts.dashboard')

@section('title')
    {{ __('Add Photo') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.photo', 'label' => 'Photo Management'],
        ['url' => 'admin.photo.create', 'label' => 'Add Photo'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.photo.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <div>
            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Upload Image') }}
            </label>
            <input type="file" name="image" id="image" accept="image/*" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
            @error('image')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Add Photo') }}
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
