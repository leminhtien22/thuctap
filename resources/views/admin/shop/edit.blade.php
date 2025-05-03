@extends('layouts.dashboard')

@section('title')
    {{ __('Edit Shop') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.shop', 'label' => 'Manage Shops'],
        ['url' => 'admin.shop.create', 'label' => 'Edit Shop'],
    ]" />

    <form novalidate class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.shop.edit', $data->id) }}"
        method="POST" enctype="multipart/form-data">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-form.input-field name="name" label="Shop Name" :value="old('name') ?? $data->name" required
            placeholder="Enter shop name" />

        <div>
            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('What type is this shop item?') }}
            </label>

            <select required id="type" name="type"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Select type') }}</option>
                @if (old('type') ?? $data->type)
                    <option value="painting" {{ (old('type') ?? $data->type) === 'painting' ? 'selected' : '' }}>{{ __('Painting') }}</option>
                    <option value="sculpture" {{ (old('type') ?? $data->type) === 'sculpture' ? 'selected' : '' }}>{{ __('Sculpture') }}</option>
                    <option value="statues" {{ (old('type') ?? $data->type) === 'statues' ? 'selected' : '' }}>{{ __('Statue') }}</option>
                    <option value="fossils" {{ (old('type') ?? $data->type) === 'fossils' ? 'selected' : '' }}>{{ __('Fossil') }}</option>
                    <option value="handicrafts" {{ (old('type') ?? $data->type) === 'handicrafts' ? 'selected' : '' }}>{{ __('Handicrafts') }}</option>
                    <option value="others" {{ (old('type') ?? $data->type) === 'others' ? 'selected' : '' }}>{{ __('Other') }}</option>
                @else
                    <option value="painting">{{ __('Painting') }}</option>
                    <option value="sculpture">{{ __('Sculpture') }}</option>
                    <option value="statues">{{ __('Statue') }}</option>
                    <option value="fossils">{{ __('Fossil') }}</option>
                    <option value="handicrafts">{{ __('Handicrafts') }}</option>
                    <option value="others">{{ __('Other') }}</option>
                @endif
            </select>

            @error('type')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-form.textarea-field name="description" label="Short Description" :value="old('description') ?? $data->description" required
            placeholder="Enter short description" />

        <x-form.input-field name="price" label="Price" type="number" :value="old('price') ?? ($data->price ?? 0)" required
            placeholder="Enter price" min="0"
            description="Default price is 0, meaning the shop item is for display only and not for sale." />

        <x-form.input-field name="quantity" label="Quantity" type="number" :value="old('quantity') ?? ($data->quantity ?? 0)" required
            placeholder="e.g. Enter quantity" min="0" description="Number of items for display and sale." />

        <div>
            <label for="is_public" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Visibility') }}
            </label>

            <select required id="is_public" name="is_public"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Select visibility') }}</option>
                @if (old('is_public') ?? isset($data->is_public))
                    @php
                        $is_public = old('is_public') ?? ($data->is_public ? 'true' : 'false');
                    @endphp

                    <option value="true" {{ $is_public === 'true' ? 'selected' : '' }}>{{ __('Visible') }}</option>
                    <option value="false" {{ $is_public === 'false' ? 'selected' : '' }}>{{ __('Hidden') }}</option>
                @else
                    <option value="true">{{ __('Visible') }}</option>
                    <option value="false">{{ __('Hidden') }}</option>
                @endif
            </select>

            @error('is_public')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="thumbnail">Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewAvatar(event)">

            <img id="imgReview" src="{{ asset('storage/' . $data->thumbnail) }}" class="w-16 h-16 rounded-md mt-2"
                alt="Image Preview">

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
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input type="file" name="images[]" id="images" accept="image/*" class="hidden" multiple
                        onchange="previewImages(event)">
                </label>
            </div>

            <input type="hidden" name="images-exist" id="images-input" value="{{ $data->images }}">

            <div id="imagePreviewContainer" class="mt-2 flex gap-3 flex-wrap">
                @foreach ($data->images_json as $image)
                    <div class="relative w-16 h-16">
                        <img src="{{ asset('storage/' . $image) }}" alt="Image Preview"
                            class="w-full h-full rounded-md border object-cover">
                        <button type="button"
                            class="absolute -top-2 -right-2 bg-red-500 text-white w-5 h-5 flex items-center justify-center rounded-full text-xs hover:bg-red-600 cursor-pointer"
                            onclick="removeImage('{{ $image }}')">
                            ×
                        </button>
                    </div>
                @endforeach
            </div>

            @error('images')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Save Changes') }}
        </x-ui.button>
    </form>
@endsection