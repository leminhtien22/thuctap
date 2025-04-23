@extends('layouts.app')

@section('title')
    {{ __('Account Settings') }}
@endsection

@section('content')
<div class="min-h-screen bg-[#2F2F2F] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8 space-y-6 transform transition-all hover:shadow-3xl">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-white">Account Settings</h2>
            <p class="mt-2 text-sm text-gray-400">Personalize your profile</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-purple-900/50 text-purple-200 rounded-lg text-sm font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('client.user.setting') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Full Name</label>
                <div class="mt-1 relative">
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="block w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300 ease-in-out transform hover:scale-[1.02]"
                           placeholder="Enter your name" required>
                    <svg class="absolute top-3 right-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <!-- Avatar -->
            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-300">Avatar (optional)</label>
                <div class="mt-1 flex items-center justify-center">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-20 h-20 rounded-full border-2 border-purple-500 object-cover transform transition hover:scale-110" alt="Avatar">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gray-700 flex items-center justify-center border-2 border-purple-500">
                            <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="mt-3">
                    <input id="avatar" type="file" name="avatar"
                           class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-900 file:text-purple-200 hover:file:bg-purple-800 transition duration-300">
                </div>
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">New Password (optional)</label>
                <div class="mt-1 relative">
                    <input id="password" type="password" name="password"
                           class="block w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300 ease-in-out transform hover:scale-[1.02]"
                           placeholder="Enter new password">
                    <svg class="absolute top-3 right-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-2 4-2 4m-4-4c0-1.1-.9-2-2-2s-2 .9-2 2 2 4 2 4m6 5H6m6-11V4" />
                    </svg>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                <div class="mt-1 relative">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="block w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-300 ease-in-out transform hover:scale-[1.02]"
                           placeholder="Confirm your password">
                    <svg class="absolute top-3 right-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-2 4-2 4m-4-4c0-1.1-.9-2-2-2s-2 .9-2 2 2 4 2 4m6 5H6m6-11V4" />
                    </svg>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-purple-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400 transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection