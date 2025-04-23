@extends('layouts.dashboard')

@section('title')
    {{ __('System Configuration') }}
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-8 text-white bg-gray-900 rounded-xl shadow-lg px-6">
    <h2 class="text-3xl font-bold mb-6">⚙️ System Configuration</h2>

    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{ tab: 'contact' }">
        <!-- Tab buttons -->
        <div class="flex space-x-4 border-b border-gray-700 mb-6 pb-2">
            <button @click="tab = 'contact'"
                :class="tab === 'contact' ? 'border-b-2 border-indigo-500 text-indigo-400' : 'text-gray-400'"
                class="px-3 py-2 font-medium focus:outline-none transition-all">Contact Information</button>
        </div>

        <form action="{{ route('admin.system_settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf

            <!-- Tab 1: Contact Information -->
            <div x-show="tab === 'contact'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="contact_email" class="block text-sm font-medium mb-1">📧 Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $configurations['contact_email']->value ?? '' }}">
                </div>

                <div>
                    <label for="contact_phone" class="block text-sm font-medium mb-1">📞 Phone Number</label>
                    <input type="text" name="contact_phone" id="contact_phone"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $configurations['contact_phone']->value ?? '' }}">
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium mb-1">📍 Address</label>
                    <input type="text" name="address" id="address"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $configurations['address']->value ?? '' }}">
                </div>
            </div>

            <!-- Tab 2: Social -->
            <div x-show="tab === 'social'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $fb = $configurations['facebook']->value ?? '';
                    $ig = $configurations['instagram']->value ?? '';
                    $tt = $configurations['tiktok']->value ?? '';
                    $yt = $configurations['youtube']->value ?? '';
                @endphp

                <div>
                    <label for="facebook" class="block text-sm font-medium mb-1">📘 Facebook</label>
                    <input type="url" name="facebook" id="facebook"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="https://facebook.com/yourpage" value="{{ old('facebook', $fb) }}">
                </div>

                <div>
                    <label for="instagram" class="block text-sm font-medium mb-1">📷 Instagram</label>
                    <input type="url" name="instagram" id="instagram"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="https://instagram.com/yourprofile" value="{{ old('instagram', $ig) }}">
                </div>

                <div>
                    <label for="tiktok" class="block text-sm font-medium mb-1">🎵 TikTok</label>
                    <input type="url" name="tiktok" id="tiktok"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="https://tiktok.com/@yourhandle" value="{{ old('tiktok', $tt) }}">
                </div>

                <div>
                    <label for="youtube" class="block text-sm font-medium mb-1">📺 YouTube</label>
                    <input type="url" name="youtube" id="youtube"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="https://youtube.com/channel/yourchannel" value="{{ old('youtube', $yt) }}">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition-all shadow-md">
                    💾 Save Configuration
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
