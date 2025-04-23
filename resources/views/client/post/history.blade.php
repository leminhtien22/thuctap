@extends('layouts.app')

@section('title')
    {{ __('View History') }}
@endsection

@php
    $columns = ['Title', 'Category', 'Author', 'Viewed At', 'Views'];
@endphp

@section('content')
    <div class="px-2">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[['url' => 'client.post.history', 'label' => 'View History']]" />

        <h1 class="text-2xl text-white capitalize">
            List of Viewed Posts
        </h1>

        @if (session('success'))
            <x-ui.alert type="success">
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <div class="mt-4">
            <x-ui.table :columns="$columns">
                <x-slot:body>
                    @forelse ($views as $item)
                        <x-ui.table-row>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ route('client.post.details', $item->post->slug) }}" class="text-blue-500 hover:underline">
                                    {{ $item->post->title }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-wrap max-w-[150px]">
                                {{ $item->post->category->name ?? 'None' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->post->author->name ?? 'Anonymous' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($item->viewed_at)->locale('en')->format('H:i, d-m-Y') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->post->views_count ?? 0 }}
                            </td>
                        </x-ui.table-row>
                    @empty
                        <x-ui.table-row>
                            <td class="px-6 py-4 text-center dark:text-white" colspan="{{ count($columns) }}">
                                No data available
                            </td>
                        </x-ui.table-row>
                    @endforelse
                </x-slot:body>
            </x-ui.table>
        </div>

        <div class="mt-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow sm:flex sm:items-center sm:justify-between">
            <x-common.pagination-info :paginator="$views" unit="views" />
            <x-ui.pagination :paginator="$views" />
        </div>
    </div>
@endsection

<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>
