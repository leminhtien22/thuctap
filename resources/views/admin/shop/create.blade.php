@extends('layouts.dashboard')

@section('title')
    {{ __('Add Shop') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.shop', 'label' => 'Manage Shops'],
        ['url' => 'admin.shop.create', 'label' => 'Add Shop'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.shop.create') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-form.input-field name="name" label="Shop Name" :value="old('name')" required
            placeholder="Enter shop name" />

        <div>
            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('What type is this shop?') }}
            </label>

            <select required id="type" name="type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Select type') }}</option>
                @foreach (['painting', 'sculpture', 'statues', 'fossils', 'handicrafts', 'others'] as $item)
                    <option value="{{ $item }}" {{ old('type') === $item ? 'selected' : '' }}>
                        {{ __(ucfirst($item)) }}
                    </option>
                @endforeach
            </select>

            @error('type')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-form.textarea-field name="description" label="Short Description" :value="old('description')" required
            placeholder="Enter a short description of the shop" />

        <x-form.input-field name="price" label="Price" type="number" :value="old('price') ?? 0" required
            placeholder="Enter price" min="0" description="Default price is 0 meaning this shop is for display only and not for sale." />

        <x-form.input-field name="quantity" label="Quantity" type="number" :value="old('quantity') ?? 0" required
            placeholder="E.g. Enter quantity" min="0" description="The number available for display and sale." />

        <div>
            <label for="is_public" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Status') }}
            </label>

            <select required id="is_public" name="is_public"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="true" {{ old('is_public') === 'true' ? 'selected' : '' }}>{{ __('Visible') }}</option>
                <option value="false" {{ old('is_public') === 'false' ? 'selected' : '' }}>{{ __('Hidden') }}</option>
            </select>

            @error('is_public')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="thumbnail">Thumbnail Image</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewAvatar(event)" required>

            <img id="imgReview" src="" class="w-16 h-16 rounded-md mt-2 hidden" alt="Image Preview">

            @error('thumbnail')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label for="images">Gallery Images</label>

            <div class="flex items-center justify-center w-full">
                <label for="images"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input type="file" name="images[]" id="images" accept="image/*" class="hidden" multiple required
                        onchange="previewImages(event)">
                </label>
            </div>

            <div id="imagePreviewContainer" class="mt-2 flex gap-3 flex-wrap"></div>

            @error('images')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Create Shop') }}
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

    function previewImages(event) {
        const container = document.getElementById("imagePreviewContainer");
        container.innerHTML = "";

        const files = Array.from(event.target.files);
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageWrapper = document.createElement("div");
                imageWrapper.className = "relative w-16 h-16";

                const img = document.createElement("img");
                img.className = "w-full h-full rounded-md border object-cover";
                img.src = e.target.result;

                const deleteBtn = document.createElement("button");
                deleteBtn.className =
                    "absolute -top-2 -right-2 bg-red-500 text-white w-5 h-5 flex items-center justify-center rounded-full text-xs hover:bg-red-600 cursor-pointer";
                deleteBtn.innerHTML = "×";
                deleteBtn.onclick = function() {
                    imageWrapper.remove();
                    files.splice(index, 1);
                };

                imageWrapper.appendChild(img);
                imageWrapper.appendChild(deleteBtn);
                container.appendChild(imageWrapper);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
