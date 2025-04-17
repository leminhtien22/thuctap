@extends('layouts.dashboard')

@section('title')
    {{ __('Cập nhật thông tin đơn hàng') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.order', 'label' => 'Quản lý đơn hàng'],
        ['url' => 'admin.order.create', 'label' => 'Cập nhật thông tin đơn hàng'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.order.edit', $data->id) }}" method="POST">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-ui.alert type="warning">
            Nếu trạng thái đã thanh toán chỉ cho phép chỉnh sửa ghi chú.
        </x-ui.alert>

        <x-form.input-field name="customer" label="Khách hàng" :value="$data->user->name . ' - ' . $data->user->email" readonly
            placeholder="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789" />

        <x-form.textarea-field name="notes" label="Ghi chú" :value="old('notes') ?? $data->notes" required
            placeholder="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789" />

        <x-form.input-field name="customer" label="Tổng tiền" :value="$data->formatted_total_price" readonly
            placeholder="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789" />

        <x-form.input-field name="customer" label="Tổng số lượng" :value="$data->total_quantity" readonly
            placeholder="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789" />

        <div>
            <h2 class="text-sm">Sản phẩm đã chọn</h2>

            <div class="space-y-4">
                @forelse  ($data->orderDetails as $productItem)
                    <div class="flex space-x-2 shadow rounded-lg p-4 hover:shadow-xl product-item">
                        <img src="{{ asset('storage/' . $productItem->collection->thumbnail) }}"
                            alt="{{ $productItem->collection->name }}" class="size-12 rounded-md inline-block">
                        <div>
                            <h1>{{ $productItem->collection->name }}</h1>
                            <p class="text-sm text-green-700 font-bold underline">Giá mua:
                                {{ $productItem->formatted_price }}
                                đ
                            </p>
                            <p class="text-sm text-green-700">Số lượng mua: {{ $productItem->quantity }}</p>
                            <p class="text-sm text-gray-500">Mô tả: {{ $productItem->collection->description }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-sm">
                        <p class="text-red-500 mt-2">Sản phẩm đã bị xoá trước đó.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            <label for="is_paid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Trạng thái') }}
            </label>

            <select required id="is_paid" name="is_paid" {{ $data->is_paid ? 'disabled' : '' }}
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Chọn trạng thái') }}</option>

                @if (old('is_paid') ?? $data->is_paid)
                    <option value="true" selected>
                        {{ __('Đã thanh toán') }}
                    </option>

                    <option value="false">
                        {{ __('Chưa thanh toán') }}
                    </option>
                @else
                    <option value="false" selected>
                        {{ __('Chưa thanh toán') }}
                    </option>

                    <option value="true">
                        {{ __('Đã thanh toán') }}
                    </option>
                @endif
            </select>
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Lưu thay đổi') }}
        </x-ui.button>
    </form>
@endsection
