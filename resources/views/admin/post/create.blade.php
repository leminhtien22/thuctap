@extends('layouts.dashboard')

@section('title')
    {{ __('Add Post') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[ 
        ['url' => 'admin.post', 'label' => 'Post Management'],
        ['url' => 'admin.post.create', 'label' => 'Add Post'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.post.create') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-form.input-field name="title" label="Post Title" :value="old('title')" required
            placeholder="E.g., Art Exhibition" />

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Status') }}
            </label>
            <select required id="status" name="status"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @if (old('status'))
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                    </option>
                @else
                    <option value="active">{{ __('Active') }}</option>
                @endif
            </select>
            @error('status')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-form.textarea-field name="content" label="Post Content" :value="old('content')" required
            placeholder="Enter post content" />

        <!-- Hidden inputs for CKEditor -->
        <input type="hidden" id="content_html" name="content_html" value="{{ old('content_html') }}">
        <input type="hidden" id="content_text" name="content_text" value="{{ old('content_text') }}">

        <!-- Thumbnail Section -->
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Post Thumbnail') }}
            </label>

            <!-- Option to Upload New Image -->
            <div class="mb-4">
                <label for="thumbnail" class="block mb-1 text-sm text-gray-400">{{ __('Upload New Image') }}</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewAvatar(event)"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                @error('thumbnail')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
                <img id="imgReview" src="" class="w-16 h-16 rounded-md mt-2 hidden" alt="Image Preview">
            </div>

            <!-- Option to Select Existing Image -->
            <div>
                <label class="block mb-1 text-sm text-gray-400">{{ __('Select Existing Image') }}</label>
                <button type="button" onclick="openImageModal()"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg px-4 py-2">
                    {{ __('Choose from Image Library') }}
                </button>
                <input type="hidden" name="thumbnail_id" id="thumbnail_id" value="{{ old('thumbnail_id') }}">
                <div id="selectedImagePreview" class="mt-2 hidden">
                    <img id="selectedImage" src="" class="w-16 h-16 rounded-md" alt="Selected Image">
                </div>
            </div>
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600">
            {{ __('Add Post') }}
        </x-ui.button>
    </form>

    <!-- Modal for Image Selection -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl p-6 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-white">{{ __('Choose Image') }}</h3>
                <button onclick="closeImageModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @forelse ($images as $image)
                    <div class="cursor-pointer" onclick="selectImage('{{ $image->id }}', '{{ asset('storage/' . $image->url) }}')">
                        <img src="{{ asset('storage/' . $image->url) }}" class="w-full h-24 object-cover rounded-md hover:opacity-80 transition duration-300"
                            alt="Image">
                    </div>
                @empty
                    <p class="text-gray-400 col-span-full text-center">{{ __('No images available') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        CKEDITOR.replace('content');

        CKEDITOR.instances.content.on('change', function() {
            var editor = CKEDITOR.instances.content;
            var htmlContent = editor.getData();
            var textContent = editor.document.getBody().getText();
            document.getElementById("content_html").value = htmlContent;
            document.getElementById("content_text").value = textContent;
        });
    });

    function previewAvatar(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imgReview');
            output.classList.remove('hidden');
            output.src = reader.result;
            // Clear selected image if new file is uploaded
            document.getElementById('thumbnail_id').value = '';
            document.getElementById('selectedImagePreview').classList.add('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function openImageModal() {
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    function selectImage(imageId, imageUrl) {
        document.getElementById('thumbnail_id').value = imageId;
        document.getElementById('selectedImage').src = imageUrl;
        document.getElementById('selectedImagePreview').classList.remove('hidden');
        document.getElementById('imgReview').classList.add('hidden');
        document.getElementById('thumbnail').value = ''; // Clear file input
        closeImageModal();
    }
</script>
