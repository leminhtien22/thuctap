@extends('layouts.dashboard')

@section('title')
    {{ __('Edit Ticket Information') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.ticket', 'label' => 'Ticket Management'],
        ['url' => 'admin.ticket.edit', 'label' => 'Edit Ticket Information'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.ticket.edit', $data->id) }}" method="POST">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-ui.alert type="warning">
            If the status is "Paid", only the note field can be edited.
        </x-ui.alert>

        <x-form.input-field readonly name="customer" label="Customer" :value="$data->user->name . ' - ' . $data->user->email" required
            placeholder="E.g., Select an exhibition" min="0" />

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
            placeholder="E.g., Select an exhibition" min="0" />

        <x-form.input-field readonly name="start_date" label="Start Time" readonly :value="$data->exhibition->formatted_start_date" required
            placeholder="E.g., Select an exhibition" min="0" />

        <x-form.input-field readonly name="end_date" label="End Time" readonly :value="$data->exhibition->formatted_start_date" required
            placeholder="E.g., Select an exhibition" min="0" />

        <x-form.input-field name="ticket_count" label="Ticket Quantity" type="number" :value="old('ticket_count') ?? $data->ticket_count" :readonly="$data->is_paid"
            placeholder="E.g., Enter ticket quantity" min="1" />

        <x-form.textarea-field name="details" label="Note" :value="old('details') ?? $data->details" required
            placeholder="E.g., Booking for: Nguyen Van A - Phone: 0123456789"
            description="E.g., Booking for: Nguyen Van A - Phone: 0123456789" />

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Status') }}
            </label>

            <select required id="status" name="status" {{ $data->is_paid ? 'disabled' : '' }}
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

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Save Changes') }}
        </x-ui.button>
    </form>
@endsection
