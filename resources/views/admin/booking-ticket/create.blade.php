@extends('layouts.dashboard')

@section('title')
    {{ __('Đặt vé tại quầy') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.ticket', 'label' => 'Quản lý đặt vé'],
        ['url' => 'admin.ticket.create', 'label' => 'Đặt vé tại quầy'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.ticket.create') }}" method="POST">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <div>
            <label for="exhibition_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Buổi triển lãm') }}
            </label>

            <select required id="exhibition_id" name="exhibition_id" onchange="handleExhibitionChange(this.value)"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Chọn buổi triển lãm') }}</option>
                @if (old('exhibition_id'))
                    @foreach ($exhibition_list as $exhibition)
                        @if ($exhibition->id === old('exhibition_id'))
                            <option value="{{ $exhibition->id }}" selected>
                                {{ $exhibition->title }}
                            </option>
                        @else
                            <option value="{{ $exhibition->id }}">
                                {{ $exhibition->title }}
                            </option>
                        @endif;
                    @endforeach
                @else
                    @foreach ($exhibition_list as $exhibition)
                        <option value="{{ $exhibition->id }}">
                            {{ $exhibition->title }}
                        </option>
                    @endforeach
                @endif
            </select>

            @error('exhibition_id')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-form.input-field readonly name="total_price" label="Giá vé" :value="old('total_price')" required
            placeholder="VD: Chọn buổi triển lãm" min="0" />

        <x-form.input-field readonly name="start_date" label="Thời gian bắt đầu" :value="old('start_date')" required
            placeholder="VD: Chọn buổi triển lãm" min="0" />

        <x-form.input-field readonly name="end_date" label="Thời gian kết thúc" :value="old('end_date')" required
            placeholder="VD: Chọn buổi triển lãm" min="0" />

        <x-form.input-field name="ticket_count" label="Số lượng đặt vé" type="number" :value="old('ticket_count') ?? 1" required
            placeholder="VD: Nhập số lượng vé" min="1" />

        <x-form.textarea-field name="details" label="Ghi chú" :value="old('details') ?? 'Đặt vé tại quầy'" required
            placeholder="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789"
            description="VD: Đặt cho khách hàng: Nguyễn Văn A - SDT: 0123456789" />

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Đặt vé') }}
        </x-ui.button>
    </form>
@endsection

<script>
    function handleExhibitionChange(event) {
        const exhibitionId = event;

        console.log('exhibitionId', exhibitionId);

        const body = {
            'id': exhibitionId
        }

        const formatPrice = (price) => {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(price);
        }

        const formatDate = (date) => {
            return new Intl.DateTimeFormat('vi-VN', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            }).format(new Date(date));
        }

        fetch('{{ route('api.exhibition.details') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(body)
            }).then(response => response.json())
            .then(data => {
                console.log(`data`, data)

                const total_price = data.price;
                const start_date = data.start_date;
                const end_date = data.end_date;

                document.querySelector('input[name="total_price"]').value = Number(total_price) <= 0 ? 'Miễn phí' :
                    formatPrice(total_price);
                document.querySelector('input[name="start_date"]').value = formatDate(start_date);
                document.querySelector('input[name="end_date"]').value = formatDate(end_date);
            });

    }
</script>
