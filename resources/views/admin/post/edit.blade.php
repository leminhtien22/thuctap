@extends('layouts.dashboard')

@section('title')
    {{ __('Cập nhật bài viết') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.post', 'label' => 'Quản lý bài viết'],
        ['url' => 'admin.post.edit', 'label' => 'Cập nhật bài viết'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.post.edit', $data->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-form.input-field name="title" label="Tiêu đề bài viết" :value="old('title') ?? $data->title" required
            placeholder="VD: Triển lãm nghệ thuật" />

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Trạng thái') }}
            </label>
            <select required id="status" name="status"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Chọn trạng thái') }}</option>
                @if (old('status') ?? $data->status)
                    @php $status = old('status') ?? $data->status; @endphp
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>{{ __('Hiển thị') }}</option>
                    <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>{{ __('Không hiển thị') }}
                    </option>
                @else
                    <option value="active">{{ __('Hiển thị') }}</option>
                    <option value="inactive">{{ __('Không hiển thị') }}</option>
                @endif
            </select>

            @error('status')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Nội dung bài viết') }}
            </label>

            <textarea id="content" name="content">{{ old('content') ?? $data->content_html }}</textarea>

            @error('content_html')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- 2 input hidden để lưu dữ liệu -->
        <input type="hidden" id="content_html" name="content_html"
            value="{{ old('content_html') ?? $data->content_html }}">

        <input type="hidden" id="content_text" name="content_text"
            value="{{ old('content_text') ?? $data->content_text }}">

        <div>
            <label for="thumbnail">Ảnh đại diện bài viết</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewAvatar(event)">


            <img id="imgReview" src="{{ asset('storage/' . $data->thumbnail) }}" class="w-16 h-16 rounded-md mt-2"
                alt="Image Preview">

            @error('image')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Lưu thay đổi') }}
        </x-ui.button>
    </form>
@endsection

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        CKEDITOR.replace('content');

        CKEDITOR.instances.content.on('change', function() {
            var editor = CKEDITOR.instances.content;

            var htmlContent = editor.getData(); // Lấy nội dung HTML
            var textContent = editor.document.getBody().getText(); // Lấy nội dung text

            // console.log("HTML Content:", htmlContent);
            // console.log("Text Content:", textContent);

            // Gán lại giá trị cho input hidden
            document.getElementById("content_html").value = htmlContent;
            document.getElementById("content_text").value = textContent;
        });
    });
</script>

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
