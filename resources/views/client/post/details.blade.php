@extends('layouts.app')

@section('title')
    {{ __('Post Details') }}
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6 text-white">
        {{-- Breadcrumb --}}
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[ 
            ['url' => 'client.post', 'label' => 'Posts'],
            ['url' => 'client.post.details', 'param' => $data->id, 'label' => 'Post Details'],
        ]" />

        {{-- Post Title --}}
        <h1 class="text-3xl font-semibold mt-4 mb-2">{{ $data->title }}</h1>

        {{-- Author Information and Created Date --}}
        <div class="flex items-center text-sm text-gray-400 space-x-4 mt-2">
            <div class="flex items-center">
                <span class="font-medium">{{ $data->user->name }}</span>
                <span class="ml-1 text-gray-500">({{ $data->user->email }})</span>
            </div>
            <span class="hidden sm:inline">|</span>
            <div>{{ $data->formatted_created_at }}</div>
        </div>

        {{-- Title Image --}}
        @if ($data->thumbnail)
            <div class="mt-6">
                <img src="{{ asset('storage/' . $data->thumbnail) }}" alt="{{ $data->title }}" class="w-full max-h-160 object-cover rounded-lg shadow-md">
            </div>
        @endif

        {{-- Content --}}
        <div class="mt-8 prose prose-invert prose-lg max-w-none">
            {!! $data->content_html !!}
        </div>
    </div>
@endsection

{{-- View Increase Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            fetch("{{ route('post.increase.view', $data->id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            });
        }, 5000);
    });
</script>
