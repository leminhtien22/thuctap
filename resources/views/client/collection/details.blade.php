@extends('layouts.app')

@section('title')
    {{ __('Chi tiết bộ sưu tập') }}
@endsection

@php
    $searching = request()->get('q') ?? '';
@endphp

@section('content')
    <div class="px-4 py-6 bg-[#1c1c1c] text-white min-h-screen">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[
            ['url' => 'client.collection', 'label' => 'Bộ sưu tập'],
            ['url' => 'client.collection.details', 'param' => $data->id, 'label' => 'Chi tiết bộ sưu tập'],
        ]" />

        <h1 class="text-3xl font-bold mt-4">{{ $data->title }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">Ảnh tiêu đề:</h2>
                <img src="{{ asset('storage/' . $data->thumbnail) }}" alt="{{ $data->title }}" class="w-full h-auto rounded-xl shadow-lg">
            </div>
            <div class="space-y-4">
                <div>
                    <h2 class="text-lg font-semibold">Mô tả:</h2>
                    <p class="text-gray-300">{{ $data->description }}</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold">Loại bộ sưu tập:</h2>
                    <p class="text-gray-300">{{ $data->formatted_type }}</p>
                </div>

                @if ($data->is_sale)
                    <div>
                        <h2 class="text-lg font-semibold">Giá bán:</h2>
                        <p class="text-green-400 font-bold">{{ $data->formatted_price . ' VND' }}</p>
                    </div>

                    <div>
                        <a href="{{ route('cart.add', $data->id) }}" class="inline-block mt-3 px-5 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-white font-medium transition">
                            Thêm giỏ hàng
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
