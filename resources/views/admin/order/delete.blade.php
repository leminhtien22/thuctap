@extends('layouts.dashboard')

@section('title')
    {{ __('Delete Order') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.order', 'label' => 'Order Management'],
        ['url' => 'admin.order.create', 'label' => 'Delete Order'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.order.delete', $data->id) }}" method="POST">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-ui.alert type="warning">
            Please note this action cannot be undone. Proceed with caution before deleting.
        </x-ui.alert>

        <x-form.input-field name="customer" label="Customer" :value="$data->user->name . ' - ' . $data->user->email" readonly
            placeholder="E.g: Order placed for customer: John Doe - Phone: 0123456789" />

        <x-form.textarea-field name="notes" label="Notes" :value="old('notes') ?? $data->notes" readonly
            placeholder="E.g: Order placed for customer: John Doe - Phone: 0123456789" />

        <x-form.input-field name="customer" label="Total Price" :value="$data->formatted_total_price" readonly
            placeholder="E.g: Order placed for customer: John Doe - Phone: 0123456789" />

        <x-form.input-field name="customer" label="Total Quantity" :value="$data->total_quantity" readonly
            placeholder="E.g: Order placed for customer: John Doe - Phone: 0123456789" />

        <div>
            <h2 class="text-sm">Selected Products</h2>

            <div class="space-y-4">
                @forelse  ($data->orderDetails as $productItem)
                    <div class="flex space-x-2 shadow rounded-lg p-4 hover:shadow-xl product-item">
                        <img src="{{ asset('storage/' . $productItem->collection->thumbnail) }}"
                            alt="{{ $productItem->collection->name }}" class="size-12 rounded-md inline-block">
                        <div>
                            <h1>{{ $productItem->collection->name }}</h1>
                            <p class="text-sm text-green-700 font-bold underline">Price:
                                {{ $productItem->formatted_price }}
                                đ
                            </p>
                            <p class="text-sm text-green-700">Quantity: {{ $productItem->quantity }}</p>
                            <p class="text-sm text-gray-500">Description: {{ $productItem->collection->description }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-sm">
                        <p class="text-red-500 mt-2">No products selected. <a href="{{ route('admin.collection') }}"
                                class="underline">Add new products</a></p>
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            <label for="is_paid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Status') }}
            </label>

            <select required id="is_paid" name="is_paid" disabled
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Select status') }}</option>

                @if (old('is_paid') ?? $data->is_paid)
                    <option value="true" selected>
                        {{ __('Paid') }}
                    </option>

                    <option value="false">
                        {{ __('Unpaid') }}
                    </option>
                @else
                    <option value="false" selected>
                        {{ __('Unpaid') }}
                    </option>

                    <option value="true">
                        {{ __('Paid') }}
                    </option>
                @endif
            </select>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <x-ui.button type="submit" class="w-full md:w-auto bg-red-500 hover:bg-red-600">
                {{ __('Delete Order') }}
            </x-ui.button>

            <x-ui.button :href="route('admin.order')" class="w-full md:w-auto">
                {{ __('Cancel') }}
            </x-ui.button>
        </div>
    </form>
@endsection
