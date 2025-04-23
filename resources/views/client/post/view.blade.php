@extends('layouts.app')

@section('title')
    {{ __('List of Posts') }}
@endsection

@php
    $searching = request()->get('q') ?? '';
@endphp

@section('content')
<div class="bg-[#1c1c1c] text-white py-16 px-4 min-h-screen font-poppins">
    <div class="max-w-7xl mx-auto">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[['url' => 'client.exhibition', 'label' => 'Posts']]" />

        <h1 class="text-5xl font-bellefair text-[#f7c873] mb-12 text-center">Explore Posts</h1>

        <!-- Search bar -->
        <form action="{{ route('client.post') }}" method="GET" class="mb-14">
            <div class="relative max-w-2xl mx-auto">
                <input type="search" name="q" value="{{ $searching }}"
                    placeholder="Search posts..."
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

        <!-- List of posts -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
            @forelse ($data as $item)
                <div class="bg-[#2f2f2f] rounded-2xl overflow-hidden shadow-md hover:shadow-yellow-400/30 transition duration-300">
                    <a href="{{ route('client.post.details', $item->id) }}">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                             alt="{{ $item->title }}"
                             class="w-full h-100 object-cover transition-transform duration-500 hover:scale-105">
                    </a>

                    <div class="p-6 space-y-3">
                        <a href="{{ route('client.post.details', $item->id) }}">
                            <h2 class="text-2xl font-bellefair text-[#f7c873] line-clamp-1">{{ $item->title }}</h2>
                        </a>

                        <p class="text-gray-300 text-sm line-clamp-2">{{ $item->content_text }}</p>

                        <div class="text-sm text-gray-400 mt-2">
                            <p><span class="text-white font-medium">Author:</span> {{ $item->user->name }}</p>
                            <p><span class="text-white font-medium">Created At:</span> {{ $item->formatted_created_at }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('client.post.details', $item->id) }}"
                               class="inline-block px-4 py-2 bg-[#f7c873] text-black font-semibold rounded-full hover:bg-yellow-400 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <x-ui.alert type="warning">
                        {{ $searching ? 'No posts found with keyword "' . $searching . '"' : 'No posts available' }}
                    </x-ui.alert>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection