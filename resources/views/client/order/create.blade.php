@extends('layouts.app')

@section('title')
    {{ __('Mua hàng') }}
@endsection

@php
    $columns = ['Tên sản phẩm', 'Số lượng', 'Đơn giá', 'Tổng tiền'];
    $totalPrice = 0;
    $totalQuantity = 0;
@endphp

@section('content')
    <div class="text-white px-2">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[
            ['url' => 'cart', 'label' => 'Giỏ hàng'],
            ['url' => 'client.post.details', 'label' => 'Tiến hành mua hàng'],
        ]" />
    </div>

    <div class="mt-4 px-2">
        <section class="bg-gray-50 rounded-2xl py-8 antialiased dark:bg-gray-900 md:py-16">
            <form action="{{ route('order.create') }}" method="POST" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                @csrf

                <div class="mx-auto max-w-3xl">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Thông tin đơn hàng</h2>

                    <div class="mt-6 space-y-4 border-b border-t border-gray-200 py-8 dark:border-gray-700 sm:mt-8">
                        <x-form.textarea-field name="notes" label="Ghi chú" :value="old('notes')"
                            placeholder="Bạn có thể nhập ghi chú hoặc không nhập." />
                    </div>

                    <div class="mt-6 sm:mt-8">
                        <div class="relative overflow-x-auto border-b border-gray-200 dark:border-gray-800">
                            <table class="w-full text-left font-medium text-gray-900 dark:text-white md:table-fixed">
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                    @foreach ($data as $id => $item)
                                        @php
                                            $totalPrice += $item['price'];
                                            $totalQuantity += $item['quantity_buy'];
                                        @endphp

                                        <tr>
                                            <td class="whitespace-nowrap py-4 md:w-[384px]">
                                                <div class="flex items-center gap-4">
                                                    <a href="{{ route('client.collection.details', $id) }}"
                                                        class="flex items-center aspect-square w-10 h-10 shrink-0">
                                                        <img class="h-auto w-full max-h-full dark:hidden"
                                                            src="{{ asset('storage/' . $item['thumbnail']) }}"
                                                            alt="imac image" />
                                                    </a>
                                                    <a href="{{ route('client.collection.details', $id) }}"
                                                        class="hover:underline">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="p-4 text-base font-normal text-gray-900 dark:text-white">
                                                {{ 'x' . $item['quantity_buy'] }}
                                            </td>

                                            <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">
                                                {{ number_format($item['price']) . ' VND' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 space-y-6">
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('Tổng quan về đơn hàng') }}
                            </h4>

                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <dl class="flex items-center justify-between gap-4">
                                        <dt class="text-gray-500 dark:text-gray-400">
                                            {{ __('Tổng đơn giá') }}
                                        </dt>
                                        <dd class="text-base font-medium text-gray-900 dark:text-white">
                                            {{ number_format($totalPrice) . ' VND' }}
                                        </dd>
                                    </dl>

                                    <dl class="flex items-center justify-between gap-4">
                                        <dt class="text-gray-500 dark:text-gray-400">
                                            {{ __('Tổng số lượng') }}
                                        </dt>
                                        <dd class="text-base font-medium text-green-500">
                                            {{ $totalQuantity }}
                                        </dd>
                                    </dl>
                                </div>

                                <dl
                                    class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                    <dt class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ __('Tổng tiền') }}
                                    </dt>
                                    <dd class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ number_format($totalPrice * $totalQuantity) . ' VND' }}
                                    </dd>
                                </dl>
                            </div>

                            <div class="gap-4 sm:flex sm:items-center">
                                <a href="{{ route('client.collection') }}"
                                    class="block text-center w-full rounded-lg  border border-gray-200 bg-white px-5  py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                                    {{ __('Tiếp tục mua hàng') }}
                                </a>

                                <button type="submit"
                                    class="mt-4 flex w-full items-center justify-center rounded-lg bg-primary-700  px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300  dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 sm:mt-0">
                                    {{ __('Mua hàng') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection


<script></script>
