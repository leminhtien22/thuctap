@extends('layouts.app')

@section('title', 'Book Private Tour')

@section('content')
    <div class="bg-[#1c1c1c] text-white py-16 px-4 sm:px-8 font-poppins min-h-screen">
        <div class="max-w-7xl mx-auto">
            <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[['url' => 'tour.create', 'label' => 'Book Private Tour']]" />

            <h1 class="text-4xl md:text-5xl font-bellefair text-[#f7c873] mb-12 text-center">
                Book a Private Tour
            </h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#2f2f2f] rounded-2xl shadow-md p-6 max-w-lg mx-auto">
                <form action="{{ route('tour.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="mb-4">
                        <label for="booking_date" class="block mb-2 text-sm font-medium text-gray-300">Date of Tour</label>
                        <input type="datetime-local" name="booking_date" id="booking_date" value="{{ old('booking_date') }}"
                            class="w-full pl-4 pr-4 py-3 rounded-full text-sm text-white bg-[#2F2F2F] border border-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f7c873] transition"
                            required>
                        @error('booking_date')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="number_of_people" class="block mb-2 text-sm font-medium text-gray-300">Number of People</label>
                        <input type="number" name="number_of_people" id="number_of_people" value="{{ old('number_of_people', 1) }}"
                            class="w-full pl-4 pr-4 py-3 rounded-full text-sm text-white bg-[#2F2F2F] border border-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f7c873] transition"
                            min="1" required>
                        @error('number_of_people')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-300">Additional Notes</label>
                        <textarea name="notes" id="notes"
                            class="w-full pl-4 pr-4 py-3 rounded-xl text-sm text-white bg-[#2F2F2F] border border-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f7c873] transition">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="px-6 py-2 text-sm font-semibold text-black bg-[#f7c873] rounded-full hover:bg-yellow-400 transition">
                            Submit Booking
                        </button>
                        <a href="{{ route('home') }}" class="px-6 py-2 text-sm font-semibold text-black bg-gray-500 rounded-full hover:bg-gray-600 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection