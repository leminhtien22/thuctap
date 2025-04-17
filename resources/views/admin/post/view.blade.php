@extends('layouts.dashboard')

@section('title')
    {{ __('Quản lý bài viết') }}
@endsection

@php
    $columns = ['Tiêu đề', 'Nội dung', 'Thời gian tạo', 'Số lượt xem', 'Trạng thái', 'Hành động'];
@endphp

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[['url' => 'admin.post', 'label' => 'Quản lý bài viết']]" />

    <!-- Start coding here -->
    <x-common.section-action title="Quản lý bài viết" description="Danh sách bài viết trong hệ thống">
        <div class="flex flex-col md:flex-row md:space-x-4">
            <x-ui.button :href="route('admin.post.trash')" class="bg-red-500 hover:bg-red-600">
                <x-slot:icon>
                    <svg class="h-3.5 w-3.5 mr-2 -ml-1 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                            clip-rule="evenodd" />
                    </svg>
                </x-slot>

                <span>Đã xoá</span>
            </x-ui.button>

            <x-ui.button :href="route('admin.post.create')">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-2 -ml-1" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path
                            d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                </x-slot>

                <span>Thêm mới</span>
            </x-ui.button>
        </div>
    </x-common.section-action>

    @if (session('success'))
        <x-ui.alert type="success">
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <x-ui.table :columns="$columns">
        <x-slot:body>
            @forelse ($data as $item)
                <x-ui.table-row>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('admin.post.edit', $item->id) }}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            {{ $item->title }}
                        </a>
                    </th>

                    <td class="px-6 py-4  truncate max-w-[100px]">
                        {{ $item->content_text }}
                    </td>

                    <td class="px-6 py-4  truncate max-w-[100px]">
                        {{ $item->formatted_created_at }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->view_count }}
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge text="{{ $item->formatted_status }}" :color="$item->status == 'active' ? 'green' : 'red'" />
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <a href={{ route('admin.post.edit', $item->id) }}
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline {{ $item->role == 'admin' ? 'hidden' : '' }}">
                            {{ __('Chỉnh sửa') }}
                        </a>

                        <a href={{ route('admin.post.delete', $item->id) }}
                            class="font-medium text-red-600 dark:text-red-500 hover:underline ml-4 {{ $item->role == 'admin' ? 'hidden' : '' }}">
                            {{ __('Xoá') }}
                        </a>
                    </td>
                </x-ui.table-row>
            @empty
                <x-ui.table-row>
                    <td class="px-6 py-4 text-center dark:text-white" colspan="{{ count($columns) }}">
                        Không có dữ liệu
                    </td>
                </x-ui.table-row>
            @endforelse
        </x-slot:body>
    </x-ui.table>

    <div class="mt-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow sm:flex sm:items-center sm:justify-between">
        <x-common.pagination-info :paginator="$data" unit="bài viết" />
        <x-ui.pagination :paginator="$data" />
    </div>
@endsection

<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>
