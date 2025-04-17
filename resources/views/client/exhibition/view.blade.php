@extends('layouts.app')

@section('title')
    {{ __('Danh sách buổi triển lãm') }}
@endsection

@section('content')
<div class="bg-[#1c1c1c] text-white py-16 px-4 sm:px-8 font-poppins min-h-screen">
    <div class="max-w-7xl mx-auto">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[['url' => 'client.exhibition', 'label' => 'Buổi triển lãm']]" />

        <h1 class="text-4xl md:text-5xl font-bellefair text-[#f7c873] mb-12 text-center">
            Buổi triển lãm nổi bật
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
            @forelse ($data as $item)
                <div class="relative bg-[#2f2f2f] rounded-2xl overflow-hidden shadow-md hover:shadow-yellow-400/40 transition duration-300">
                    <a href="{{ route('client.exhibition.details', $item->id) }}">
                        <img class="w-full h-100 object-cover transition-transform duration-500 hover:scale-105"
                             src="{{ asset('storage/' . $item->image) }}"
                             alt="{{ $item->title }}">
                    </a>

                    <div class="p-5 space-y-4">
                        <a href="{{ route('client.exhibition.details', $item->id) }}">
                            <h3 class="text-2xl font-bellefair text-[#f7c873] truncate">{{ $item->title }}</h3>
                        </a>

                        <p class="text-gray-300 text-sm line-clamp-2">{{ $item->description }}</p>

                        <div class="text-sm text-gray-400 space-y-1">
                            <p><span class="text-white font-medium">Bắt đầu:</span> {{ $item->formatted_start_date }}</p>
                            <p><span class="text-white font-medium">Kết thúc:</span> {{ $item->formatted_end_date }}</p>
                            @if ($item->is_expired)
                                <span class="inline-block mt-1 text-xs text-red-500">{{ __('Hết hạn') }}</span>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-3 pt-4">
                            @if ($item->is_upcoming && !$item->is_expired)
                                <a href="{{ route('client.exhibition.booking', $item->id) }}"
                                   class="px-4 py-2 text-sm font-semibold text-black bg-green-400 rounded-full hover:bg-green-500 transition">
                                    Đặt vé
                                </a>
                            @endif

                            <a href="{{ route('client.exhibition.details', $item->id) }}"
                               class="px-4 py-2 text-sm font-semibold text-black bg-[#f7c873] rounded-full hover:bg-yellow-400 transition">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <x-ui.alert type="warning">
                        Chưa có buổi triển lãm nào được lên lịch
                    </x-ui.alert>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
