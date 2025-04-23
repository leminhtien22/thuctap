@extends('layouts.app')

@section('title')
    {{ __('List of Orders') }}
@endsection

@php
    $columns = ['Customer', 'Total Price', 'Total Quantity', 'Order Time', 'Notes', 'Status', 'Actions'];
@endphp

@section('content')
    <div class="px-2">
        <x-ui.breadcrumb :is-admin="0" is-dark :breadcrumbs="[['url' => 'client.exhibition', 'label' => 'Ticket Booking History']]" />

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
                                <a href="{{ route('admin.order.edit', $item->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    {{ $item->formatted_total_price }}
                                </a>
                            </td>

                            <td class="px-6 py-4  truncate max-w-[100px]">
                                {{ $item->total_quantity }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->formatted_created_at }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->notes }}
                            </td>

                            <td class="px-6 py-4">
                                <x-ui.badge text="{{ $item->formatted_is_paid }}" :color="$item->is_paid ? 'green' : 'red'" />
                            </td>

                            <td class="px-6 py-4 text-nowrap">
                                <a href={{ route('order.details', $item->id) }}
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    {{ __('View Details') }}
                                </a>
                            </td>
                        </x-ui.table-row>
                    @empty
                        <x-ui.table-row>
                            <td class="px-6 py-4 text-center dark:text-white" colspan="{{ count($columns) }}">
                                You have no orders yet
                            </td>
                        </x-ui.table-row>
                    @endforelse
                </x-slot:body>
            </x-ui.table>
        </div>

        <div class="mt-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow sm:flex sm:items-center sm:justify-between">
            <x-common.pagination-info :paginator="$data" unit="orders" />
            <x-ui.pagination :paginator="$data" />
        </div>
    </div>
@endsection

<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>