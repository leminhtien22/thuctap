@extends('layouts.app')

@section('title')
    {{ __('Chi tiết đơn hàng') }}
@endsection

@php
    $totalPrice = 0;
    $totalQuantity = 0;
@endphp

@section('content')
    <div class="text-white px-2">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[
            ['url' => 'order.history', 'label' => 'Lịch sử đặt hàng'],
            ['url' => 'client.ticket.details', 'label' => 'Chi tiết đơn hàng'],
        ]" />

        <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16 mt-4">
            <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
                    {{ __('Thời gian đặt hàng') }}
                    {{ $data->formatted_created_at }}
                </h2>

                <div class="mt-6 sm:mt-8 lg:flex lg:gap-8">
                    <div
                        class="w-full divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-200 dark:divide-gray-700 dark:border-gray-700 lg:max-w-xl xl:max-w-2xl">
                        <div class="space-y-4 p-6">
                            @forelse ($data->orderDetails as $productItem)
                                @php
                                    $totalPrice += $productItem->price;
                                @endphp

                                <div class="flex items-center gap-6">
                                    <a href="{{ route('client.collection.details', $productItem->collection->id) }}"
                                        class="h-14 w-14 shrink-0">
                                        <img class="h-full w-full dark:hidden"
                                            src="{{ asset('storage/' . $productItem->collection->thumbnail) }}"
                                            alt="{{ $productItem->collection->name }}" />
                                    </a>

                                    <a href="{{ route('client.collection.details', $productItem->collection->id) }}"
                                        class="min-w-0 flex-1 font-medium text-gray-900 hover:underline dark:text-white">
                                        {{ $productItem->collection->name }}
                                    </a>
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400"><span
                                            class="font-medium text-gray-900 dark:text-white">
                                            {{ __('Mã sản phẩm:') }}</span>
                                        {{ $productItem->collection->id }}</p>

                                    <div class="flex items-center justify-end gap-4">
                                        <p class="text-base font-normal text-gray-900 dark:text-white">
                                            x{{ $productItem->quantity }}</p>

                                        <p class="text-xl font-bold leading-tight text-gray-900 dark:text-white">
                                            {{ $productItem->formatted_price . ' đ' }}
                                        </p>
                                    </div>
                                </div>

                            @empty
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Không tìm thấy sản phẩm</p>
                            @endforelse
                        </div>

                        <div class="space-y-4 bg-gray-50 p-6 dark:bg-gray-800">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-normal text-gray-500 dark:text-gray-400">
                                        {{ __('Tổng đơn giá') }}
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">
                                        {{ number_format($totalPrice) . ' VND' }}
                                    </dd>
                                </dl>

                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-normal text-gray-500 dark:text-gray-400">
                                        {{ __('Tổng số lượng') }}
                                    </dt>
                                    <dd class="text-base font-medium text-green-500">
                                        {{ $data->total_quantity }}
                                    </dd>
                                </dl>
                            </div>

                            <dl
                                class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-lg font-bold text-gray-900 dark:text-white">Thành tiền</dt>
                                <dd class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $data->formatted_total_price }}
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 grow sm:mt-8 lg:mt-0">
                        <div
                            class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('Lịch sử đặt hàng') }}
                            </h3>

                            <ol class="relative ms-3 border-s border-gray-200 dark:border-gray-700">
                                <li class="mb-10 ms-6">
                                    <span
                                        class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white dark:bg-gray-700 dark:ring-gray-800">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                                        </svg>
                                    </span>
                                    <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-white">
                                        {{ 'Đã đặt hàng lúc ' . $data->formatted_created_at }}
                                    </h4>
                                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        {{ __('Đang chờ xác nhận') }}
                                    </p>
                                </li>

                                <li class="mb-10 ms-6">
                                    <span
                                        class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white dark:bg-gray-700 dark:ring-gray-800">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                        </svg>
                                    </span>
                                    <h4 class="mb-0.5 text-base font-semibold text-gray-900 dark:text-white">
                                        {{ __('Trạng thái') }}
                                    </h4>
                                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        {{ $data->formatted_is_paid }}
                                    </p>
                                </li>

                                <li class="mb-10 ms-6 text-primary-700 dark:text-primary-500">
                                    <span
                                        class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-primary-100 ring-8 ring-white dark:bg-primary-900 dark:ring-gray-800">
                                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                        </svg>
                                    </span>
                                    <h4 class="mb-0.5 font-semibold">Ghi chú</h4>
                                    <p class="text-sm">
                                        {{ $data->notes ?? 'Không có!' }}
                                    </p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
