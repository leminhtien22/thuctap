@extends('layouts.dashboard')

@section('title')
    {{ __('Bộ sưu tập') }}
@endsection

@php
    $columns = [
        'Hình ảnh',
        'Tên bộ sưu tập',
        'Mô tả ngắn',
        'Thuộc loại',
        'Giá bán',
        'Số lượng',
        'Thời gian tạo',
        'Trạng thái',
        'Hành động',
    ];
@endphp

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[['url' => 'admin.user', 'label' => 'Bộ sưu tập']]" />

    <!-- Start coding here -->
    <x-common.section-action title="Bộ sưu tập" description="Danh sách bộ sưu tập trong hệ thống">
        <x-ui.button :href="route('admin.collection.create')">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor"
                    aria-hidden="true">
                    <path
                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                </svg>
            </x-slot>

            <span>Thêm bộ sưu tập</span>
        </x-ui.button>
    </x-common.section-action>

    @if (session('success'))
        <x-ui.alert type="success">
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <x-ui.table :columns="$columns">
        <x-slot:body>
            @forelse ($data as $key => $item)
                <x-ui.table-row>
                    <th scope="row" class="max-w-[100px] px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}"
                            class="size-8 rounded-md inline-block">
                    </th>

                    <td class="px-6 py-4  text-wrap max-w-[100px]">
                        {{ $item->name }}
                    </td>

                    <td class="px-6 py-4  truncate max-w-[100px]">
                        {{ $item->description }}
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge :text="$item->formatted_type" color='info' />
                    </td>

                    <td class="px-6 py-4  truncate max-w-[200px]">
                        {{ $item->formatted_price }}
                    </td>

                    <td class="px-6 py-4  text-wrap max-w-[200px]">
                        {{ $item->quantity }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->formatted_created_at }}
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge :text="$item->formatted_is_public" :color="$item->is_public ? 'green' : 'red'" />
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <a href={{ route('admin.collection.edit', $item->id) }}
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline {{ $item->role == 'admin' ? 'hidden' : '' }}">
                            {{ __('Chỉnh sửa') }}
                        </a>

                        <a href={{ route('admin.collection.delete', $item->id) }}
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
        <x-common.pagination-info :paginator="$data" unit="bộ sưu tập" />
        <x-ui.pagination :paginator="$data" />
    </div>
@endsection


<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>
