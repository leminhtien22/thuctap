@extends('layouts.app')

@section('title')
    {{ __('Đặt vé cho buổi triển lãm') }}
@endsection

@section('content')
    <div class="text-white px-2">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[
            ['url' => 'client.exhibition', 'label' => 'Buổi triển lãm'],
            ['url' => 'client.exhibition.details', 'param' => $data->id, 'label' => $data->title],
            ['url' => 'client.exhibition.booking', 'param' => $data->id, 'label' => 'Đặt vé cho buổi triển lãm'],
        ]" />


        <h1 class="text-2xl capitalize mt-2">
            {{ $data->title }}
        </h1>

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <div class="mb-3 mt-5">
            <h2 class="mb-1 font-bold tracking-tight text-gray-100">Mô tả:</h2>
            <p class="mb-3 font-normal text-gray-400 test-sm">{{ $data->description }}</p>
        </div>

        <div class="mb-3 mt-5">
            <h2 class="mb-1 font-bold tracking-tight text-gray-100 underline">Bắt đầu:</h2>
            <p class="mb-3 font-normal text-gray-400 test-sm">{{ $data->formatted_start_date }}</p>
        </div>

        <div class="mb-3 mt-5">
            <h2 class="mb-1 font-bold tracking-tight text-gray-100 underline">Kết thúc:</h2>
            <p class="mb-3 font-normal text-gray-400 test-sm">{{ $data->formatted_end_date }}</p>
        </div>

        <div class="mb-3 mt-5">
            <h2 class="mb-1 font-bold tracking-tight text-gray-100">Số lượng vé có sẵn:</h2>
            <p class="mb-3 font-normal text-gray-400 test-sm">
                <x-ui.badge type="green" :text="$data->is_limited_tickets ? $data->available_tickets : 'Không giới hạn'" />
            </p>
        </div>

        <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('client.exhibition.booking', $data->id) }}"
            method="POST">
            @csrf
            <div class="mb-3 mt-5">
                <x-form.input-field :light="false" name="ticket_count" label="Số lượng đặt vé" type="number"
                    :value="old('ticket_count') ?? 1" required placeholder="VD: Nhập số lượng vé" min="1" />
            </div>

            <div class="mb-3 mt-5">
                <x-form.textarea-field :light="false" name="details" label="Ghi chú" :value="old('details')"
                    placeholder="VD: Ghi chú" />
            </div>

            <div class="mb-3 mt-5">
                <button type="submit"
                    class="inline-flex mt-3 items-center px-3 py-2 text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Đặt vé
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M6 5V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H3V7a2 2 0 0 1 2-2h1ZM3 19v-8h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm5-6a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection
