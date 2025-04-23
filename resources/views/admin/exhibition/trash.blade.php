@extends('layouts.dashboard')

@section('title')
    {{ __('Exhibitions') }}
@endsection

@php
    $columns = [
        'Title',
        'Description',
        'Total Tickets',
        'Start Time',
        'End Time',
        'Status',
        'Actions',
    ];
@endphp

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.exhibition', 'label' => 'Exhibitions'],
        ['url' => 'admin.exhibition.trash', 'label' => 'Deleted Exhibitions'],
    ]" />

    <!-- Start coding here -->
    <x-common.section-action title="Deleted Exhibitions Management"
        description="List of deleted exhibitions in the system">
        <div class="flex flex-col md:flex-row md:space-x-4">
            <x-ui.button :href="route('admin.exhibition')" class="bg-red-500 hover:bg-red-600">
                <x-slot:icon>
                    <svg class="h-3.5 w-3.5 mr-2 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14M5 12l4-4m-4 4 4 4" />
                    </svg>
                </x-slot>
                <span>Go Back</span>
            </x-ui.button>

            <x-ui.button :href="route('admin.exhibition.create')">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-2 -ml-1" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path
                            d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                </x-slot>
                <span>Add New</span>
            </x-ui.button>
        </div>
    </x-common.section-action>

    @if (session('success'))
        <x-ui.alert type="success">
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <x-ui.table :columns="$columns">
        <x-slot:body>
            @forelse ($data as $item)
                <x-ui.table-row>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                            class="size-8 rounded-full mr-2 inline-block">

                        {{ $item->title }}
                    </th>

                    <td class="px-6 py-4 truncate max-w-[100px]">
                        {{ $item->description }}
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge text="{{ $item->total_tickets == 0 ? 'Unlimited' : $item->total_tickets }}"
                            color='green' />
                    </td>

                    <td class="px-6 py-4 truncate max-w-[200px]">
                        {{ \Carbon\Carbon::parse($item->start_date)->locale('en')->isoFormat('dddd, D MMM, YYYY HH:mm') }}
                    </td>

                    <td class="px-6 py-4 truncate max-w-[200px]">
                        {{ \Carbon\Carbon::parse($item->end_date)->locale('en')->isoFormat('dddd, D MMM, YYYY HH:mm') }}
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge text="{{ $item->status == 'active' ? 'Visible' : 'Hidden' }}"
                            :color="$item->status == 'active' ? 'green' : 'red'" />
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <form action="{{ route('admin.exhibition.restore', $item->id) }}" method="POST">
                            @csrf

                            <button type="submit"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline {{ $item->role == 'admin' ? 'hidden' : '' }}">
                                {{ __('Restore') }}
                            </button>
                        </form>
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

    <div class="mt-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow sm:flex sm:items-center sm:justify-between">
        <x-common.pagination-info :paginator="$data" unit="exhibition(s)" />
        <x-ui.pagination :paginator="$data" />
    </div>
@endsection

<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>
