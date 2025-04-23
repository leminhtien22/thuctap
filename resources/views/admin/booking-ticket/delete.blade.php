@extends('layouts.dashboard')

@section('title')
    {{ __('Delete Ticket Booking') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.ticket', 'label' => 'Manage Ticket Bookings'],
        ['url' => 'admin.ticket.edit', 'label' => 'Delete Ticket Booking'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.ticket.delete', $data->id) }}" method="POST">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-ui.alert type="warning">
            Note: This action cannot be undone. Please proceed with caution.
        </x-ui.alert>

        <x-form.input-field readonly name="customer" label="Customer" :value="$data->user->name . ' - ' . $data->user->email" required
            placeholder="e.g. Select an exhibition" min="0" />

        <div>
            <label for="exhibition_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Exhibition') }}
            </label>

            <select required id="exhibition_id" name="exhibition_id" disabled
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Select an exhibition') }}</option>
                <option value="{{ $data->exhibition->id }}" selected>
                    {{ $data->exhibition->title }}
                </option>
            </select>
        </div>

        <x-form.input-field readonly name="total_price" label="Ticket Price" :value="$data->exhibition->formatted_price" required
            placeholder="e.g. Select an exhibition" min="0" />

        <x-form.input-field readonly name="start_date" label="Start Time" :value="$data->exhibition->formatted_start_date" required
            placeholder="e.g. Select an exhibition" min="0" />

        <x-form.input-field readonly name="end_date" label="End Time" :value="$data->exhibition->formatted_start_date" required
            placeholder="e.g. Select an exhibition" min="0" />

        <x-form.input-field name="ticket_count" label="Number of Tickets" type="number" :value="old('ticket_count') ?? $data->ticket_count" readonly
            placeholder="e.g. Enter number of tickets" min="1" />

        <x-form.textarea-field name="details" label="Notes" :value="old('details') ?? $data->details" required
            placeholder="e.g. Booking for customer: John Doe - Phone: 0123456789"
            description="e.g. Booking for customer: John Doe - Phone: 0123456789" />

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Status') }}
            </label>

            <select required id="status" name="status" disabled
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
                {{ __('Delete Ticket Booking') }}
            </x-ui.button>

            <x-ui.button :href="route('admin.ticket')" class="w-full md:w-auto">
                {{ __('Cancel') }}
            </x-ui.button>
        </div>
    </form>
@endsection
