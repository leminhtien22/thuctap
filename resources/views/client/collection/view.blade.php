@extends('layouts.app')

@section('title')
    {{ __('List of Collections') }}
@endsection

@php
    $searching = request()->get('q') ?? '';
@endphp

@section('content')
<div class="bg-[#1c1c1c] text-white py-16 px-4 sm:px-8 font-poppins min-h-screen">
    <div class="max-w-7xl mx-auto">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[['url' => 'client.collection', 'label' => 'Collections']]" />

        <h1 class="text-4xl md:text-5xl font-bellefair text-[#f7c873] mb-12 text-center">
            Collections
        </h1>

        <!-- Search bar -->
        <form action="{{ route('client.collection') }}" method="GET" class="mb-14">
            <div class="relative max-w-2xl mx-auto">
                <input type="search" name="q" value="{{ $searching }}"
                    placeholder="Search collections..."
                    class="w-full pl-12 pr-4 py-4 rounded-full text-sm text-white bg-[#2F2F2F] border border-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f7c873] transition" />
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M16.65 10.65A6 6 0 1 1 4.24 4.24a6 6 0 0 1 12.41 6.41z" />
                    </svg>
                </div>
            </div>
        </form>

        <!-- Collection list -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
            @forelse ($data as $item)
                <div class="relative bg-[#2f2f2f] rounded-2xl overflow-hidden shadow-md hover:shadow-yellow-400/40 transition duration-300">
                    
                    <a href="{{ route('client.collection.details', $item->id) }}">
                        <img class="w-full h-100 object-cover transition-transform duration-500 hover:scale-105"
                             src="{{ asset('storage/' . $item->thumbnail) }}"
                             alt="{{ $item->name }}">
                    </a>
                    <div class="p-5 space-y-4">
                        <a href="{{ route('client.collection.details', $item->id) }}">
                            <h3 class="text-2xl font-bellefair text-[#f7c873] truncate">{{ $item->name }}</h3>
                        </a>

                        <p class="text-gray-300 text-sm line-clamp-2">{{ $item->description }}</p>

                        <div class="text-sm text-gray-400">
                            <p><span class="text-white font-medium">Type:</span> {{ $item->formatted_type }}</p>
                            @if ($item->is_sale)
                                <p class="text-green-400 mt-1 font-semibold">On Sale!</p>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-3 pt-4">
                            @if ($item->is_sale)
                                <a href="{{ route('cart.add', $item->id) }}"
                                   class="px-4 py-2 text-sm font-semibold text-black bg-green-400 rounded-full hover:bg-green-500 transition">
                                    Add to Cart
                                </a>
                            @endif

                            <a href="{{ route('client.collection.details', $item->id) }}"
                               class="px-4 py-2 text-sm font-semibold text-black bg-[#f7c873] rounded-full hover:bg-yellow-400 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <x-ui.alert type="warning">
                        {{ $searching ? 'No collections found with keyword "' . $searching . '"' : 'No collections are currently scheduled' }}
                    </x-ui.alert>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection