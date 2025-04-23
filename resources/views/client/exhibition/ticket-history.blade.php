@extends('layouts.app')

@section('title')
    {{ __('Exhibition Booking List') }}
@endsection

@php
    $columns = ['Customer', 'Total Price', 'Ticket Quantity', 'Booking Time', 'Exhibition', 'Notes', 'Status'];
@endphp

@section('content')
    <div class="px-2">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[['url' => 'client.exhibition', 'label' => 'Booking History']]" />

        <h1 class="text-2xl text-white capitalize">
            Exhibition Ticket Booking List
        </h1>

        @if (session('success'))
            <x-ui.alert type="success">
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <div class="mt-4">
            <x-ui.table :columns="$columns">
                <x-slot:body>
                    @forelse ($data as $item)
                        <x-ui.table-row>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <p>
                                    {{ $item->user->name }}
                                </p>

                                <p>
                                    {{ $item->user->email }}
                                </p>
                            </th>

                            <td class="px-6 py-4  truncate max-w-[100px]">
                                {{ $item->total_price == 0 ? 'Free' : number_format($item->total_price) . ' VND' }}
                            </td>

                            <td class="px-6 py-4  truncate max-w-[100px]">
                                {{ $item->ticket_count }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($item->created_at)->locale('en')->format('H:i:s, d-m-Y') }}
                            </td>

                            <td class="px-6 py-4  truncate max-w-[200px]">
                                <p>
                                    <span class="font-semibold text-gray-900">{{ __('Name:') }}</span>
                                    <a href="{{ route('client.exhibition.details', $item->exhibition->id) }}" class="text-red-500 hover:underline">{{ $item->exhibition->title }}</a>
                                </p>
                                <p>
                                    <span class="font-semibold text-gray-900">{{ __('Start:') }}</span>
                                    <span class="text-green-600">
                                        {{ \Carbon\Carbon::parse($item->exhibition->start_date)->locale('en')->format('H:i, d-m-Y') }}
                                    </span>
                                </p>
                                <p>
                                    <span class="font-semibold text-gray-900">{{ __('End:') }}</span>
                                    <span class="text-green-600">
                                        {{ \Carbon\Carbon::parse($item->exhibition->end_date)->locale('en')->format('H:i, d-m-Y') }}
                                    </span>
                                </p>
                            </td>

                            <td class="px-6 py-4  text-wrap max-w-[200px]">
                                {{ $item->details }}
                            </td>

                            <td class="px-6 py-4">
                                <x-ui.badge text="{{ $item->is_paid ? 'Paid' : 'Unpaid' }}"
                                    :color="$item->is_paid ? 'green' : 'red'" />
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
            <x-common.pagination-info :paginator="$data" unit="tickets" />
            <x-ui.pagination :paginator="$data" />
        </div>
    </div>
@endsection

<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>
