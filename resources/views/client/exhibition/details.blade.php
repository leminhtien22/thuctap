@extends('layouts.app')

@section('title')
    {{ __('Exhibition Details') }}
@endsection

@section('content')
    <div class="bg-[#1c1c1c] text-white py-12 px-4 min-h-screen font-sans">
        <div class="max-w-4xl mx-auto">
            <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[ 
                ['url' => 'client.exhibition', 'label' => 'Exhibition'],
                ['url' => 'client.ticket.details', 'label' => 'Exhibition Details'],
            ]" />

            <h1 class="text-4xl font-serif font-bold text-yellow-300 mt-10 mb-6">{{ $data->title }}</h1>

            <div class="rounded-xl overflow-hidden shadow-lg mb-10">
                <img src="{{ asset('storage/' . $data->image ?? '') }}" alt="{{ $data->title }}" class="w-full object-cover h-64 transition-transform duration-500 hover:scale-105">
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-yellow-300">Description</h2>
                    <p class="text-gray-300 leading-relaxed">{{ $data->description }}</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-yellow-300">Start Date</h2>
                    <p class="text-gray-300">{{ $data->formatted_start_date }}</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-yellow-300">End Date</h2>
                    <p class="text-gray-300">{{ $data->formatted_end_date }}</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-yellow-300">Available Tickets</h2>
                    <p>
                        <x-ui.badge type="green" :text="$data->is_limited_tickets ? $data->available_tickets : 'Unlimited'" />
                    </p>
                </div>

                @if ($data->is_expired)
                    <p class="text-red-500 text-sm font-semibold">{{ __('Expired') }}</p>
                @else
                    <div class="pt-6">
                        <a href="{{ route('client.exhibition.booking', $data->id) }}"
                            class="inline-flex items-center px-6 py-3 text-base font-semibold text-black bg-yellow-300 rounded-full hover:bg-yellow-400 transition">
                            Book Tickets Now
                            <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
