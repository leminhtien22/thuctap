@extends('layouts.dashboard')

@section('title')
    {{ __('Xoá bài viết') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.post', 'label' => 'Quản lý bài viết'],
        ['url' => 'admin.post.delete', 'label' => 'Xoá bài viết'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.post.delete', $data->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif


        <div class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Lưu ý hành động này không thể hoàn tác. Vui lòng cân nhắc kĩ trước khi xoá.</span>
                <ul class="mt-1.5 list-disc list-inside">
                    <li>Bài viết sẽ không tìm thấy và sẽ không hiển thị.</li>
                    <li>Bài viết sẽ được đưa vào thùng rác.</li>
                    <li>Bài viết có thể khôi phục sau khi xoá.</li>
                </ul>
            </div>
        </div>

        <x-form.input-field name="title" label="Tiêu đề bài viết" :value="old('title') ?? $data->title" readonly
            placeholder="VD: Triển lãm nghệ thuật" />

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Trạng thái') }}
            </label>
            <select disabled id="status" name="status"
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

            <textarea id="content" name="content" readonly>{{ old('content') ?? $data->content_html }}</textarea>

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

            <img id="imgReview" src="{{ asset('storage/' . $data->thumbnail) }}" class="w-16 h-16 rounded-md mt-2"
                alt="Image Preview">

            @error('image')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <x-ui.button type="submit" class="w-full md:w-auto bg-red-500 hover:bg-red-600">
                {{ __('Xoá bài viết') }}
            </x-ui.button>

            <x-ui.button :href="route('admin.post')" class="w-full md:w-auto">
                {{ __('Huỷ bỏ') }}
            </x-ui.button>
        </div>
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
