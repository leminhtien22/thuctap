@extends('layouts.dashboard')

@section('title')
    {{ __('Xoá đặt vé') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.ticket', 'label' => 'Quản lý đặt vé'],
        ['url' => 'admin.ticket.edit', 'label' => 'Xoá đặt vé'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.ticket.delete', $data->id) }}" method="POST">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-ui.alert type="warning">
            Lưu ý hành động này không thể hoàn tác. Vui lòng cân nhắc kĩ trước khi xoá.
        </x-ui.alert>

        <x-form.input-field readonly name="customer" label="Khách hàng" :value="$data->user->name . ' - ' . $data->user->email" required
            placeholder="VD: Chọn buổi triển lãm" min="0" />

        <div>
            <label for="exhibition_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Buổi triển lãm') }}
            </label>

            <select required id="exhibition_id" name="exhibition_id" disabled
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Chọn buổi triển lãm') }}</option>
                <option value="{{ $data->exhibition->id }}" selected>
                    {{ $data->exhibition->title }}
                </option>
            </select>
        </div>

        <x-form.input-field readonly name="total_price" label="Giá vé" :value="$data->exhibition->formatted_price" required
            placeholder="VD: Chọn buổi triển lãm" min="0" />

        <x-form.input-field readonly name="start_date" label="Thời gian bắt đầu" readonly :value="$data->exhibition->formatted_start_date" required
            placeholder="VD: Chọn buổi triển lãm" min="0" />

        <x-form.input-field readonly name="end_date" label="Thời gian kết thúc" readonly :value="$data->exhibition->formatted_start_date" required
            placeholder="VD: Chọn buổi triển lãm" min="0" />

        <x-form.input-field name="ticket_count" label="Số lượng đặt vé" type="number" :value="old('ticket_count') ?? $data->ticket_count" readonly
            placeholder="VD: Nhập số lượng vé" min="1" />

        <x-form.textarea-field name="details" label="Ghi chú" :value="old('details') ?? $data->details" required
            placeholder="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789"
            description="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789" />

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Trạng thái') }}
            </label>

            <select required id="status" name="status" disabled
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

        <div class="flex flex-col md:flex-row md:space-x-4">
            <x-ui.button type="submit" class="w-full md:w-auto bg-red-500 hover:bg-red-600">
                {{ __('Xoá đặt vé') }}
            </x-ui.button>

            <x-ui.button :href="route('admin.ticket')" class="w-full md:w-auto">
                {{ __('Huỷ bỏ') }}
            </x-ui.button>
        </div>
    </form>
@endsection
