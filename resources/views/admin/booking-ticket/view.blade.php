@extends('layouts.dashboard')

@section('title')
    {{ __('Quản lý đặt vé') }}
@endsection

@php
    $columns = [
        'Khách hàng',
        'Tổng tiền',
        'Số lượng vé',
        'Thời gian đặt',
        'Buổi triển lãm',
        'Ghi chú',
        'Trạng thái',
        'Hành động',
    ];
@endphp

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[['url' => 'admin.user', 'label' => 'Quản lý đặt vé']]" />

    <!-- Start coding here -->
    <x-common.section-action title="Quản lý đặt vé" description="Danh sách đặt vé trong hệ thống">
        <x-ui.button :href="route('admin.ticket.create')">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor"
                    aria-hidden="true">
                    <path
                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                </svg>
            </x-slot>

            <span>Đặt vé tại quầy</span>
        </x-ui.button>
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
                        <p>
                            {{ $item->user->name }}
                        </p>

                        <p>
                            {{ $item->user->email }}
                        </p>
                    </th>

                    <td class="px-6 py-4  truncate max-w-[100px]">
                        {{ $item->total_price == 0 ? 'Miễn phí' : number_format($item->total_price) . ' VND' }}
                    </td>

                    <td class="px-6 py-4  truncate max-w-[100px]">
                        {{ $item->ticket_count }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($item->created_at)->locale('vi_VN')->format('H:i:s, d-m-Y') }}
                    </td>

                    <td class="px-6 py-4  truncate max-w-[200px]">
                        <p>
                            <span class="font-semibold text-gray-900">{{ __('Tên:') }}</span>
                            <span class="text-red-500 underline">{{ $item->exhibition->title }}</span>
                        </p>
                        <p>
                            <span class="font-semibold text-gray-900">{{ __('Bắt đầu:') }}</span>
                            <span class="text-green-600">
                                {{ \Carbon\Carbon::parse($item->exhibition->start_date)->locale('vi_VN')->format('H:i, d-m-Y') }}
                            </span>
                        </p>
                        <p>
                            <span class="font-semibold text-gray-900">{{ __('Kết thúc:') }}</span>
                            <span class="text-green-600">
                                {{ \Carbon\Carbon::parse($item->exhibition->end_date)->locale('vi_VN')->format('H:i, d-m-Y') }}
                            </span>
                        </p>
                    </td>

                    <td class="px-6 py-4  text-wrap max-w-[200px]">
                        {{ $item->details }}
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge text="{{ $item->is_paid ? 'Đã thanh toán' : 'Chưa thanh toán' }}" :color="$item->is_paid ? 'green' : 'red'" />
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <a href={{ route('admin.ticket.edit', $item->id) }}
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline {{ $item->role == 'admin' ? 'hidden' : '' }}">
                            {{ __('Chỉnh sửa') }}
                        </a>

                        <a href={{ route('admin.ticket.delete', $item->id) }}
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
        <x-common.pagination-info :paginator="$data" unit="vé" />
        <x-ui.pagination :paginator="$data" />
    </div>
@endsection


<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>
