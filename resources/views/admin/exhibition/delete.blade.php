@extends('layouts.dashboard')

@section('title')
    {{ __('Delete Exhibition') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.exhibition', 'label' => 'Exhibitions'],
        ['url' => 'admin.exhibition.delete', 'label' => 'Delete/Edit Exhibition'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.exhibition.delete', $data->id) }}" method="POST">
        @csrf

        <x-ui.alert type="warning">
            Please note that this action cannot be undone. Proceed with caution before deleting.
        </x-ui.alert>

        <x-form.input-field readonly name="title" label="Exhibition Title" :value="old('title') ?? $data->title" required
            placeholder="e.g. Art Exhibition" />

        <x-form.textarea-field readonly name="description" label="Exhibition Description" :value="old('description') ?? $data->description" required
            placeholder="e.g. Short description of the exhibition" />

        <x-form.input-field readonly name="total_tickets" label="Total Tickets" type="number" :value="old('total_tickets') ?? ($data->total_tickets ?? 0)" required
            placeholder="••••••••" description="If set to 0, the number of tickets sold is unlimited." min="0" />

        <x-form.input-field readonly name="start_date" label="Start Date & Time" :value="old('start_date') ?? $data->start_date" type="datetime-local"
            required placeholder="••••••••" />

        <x-form.input-field readonly name="end_date" label="End Date & Time" :value="old('end_date') ?? $data->end_date" type="datetime-local"
            required placeholder="••••••••" />

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Status') }}
            </label>
            <select disabled required id="status" name="status"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Select status') }}</option>
                @if ($data->status ?? old('status'))
                    <option value="active" {{ ($data->status ?? old('status')) === 'active' ? 'selected' : '' }}>
                        {{ __('Visible') }}</option>
                    <option value="inactive" {{ ($data->status ?? old('status')) === 'inactive' ? 'selected' : '' }}>
                        {{ __('Hidden') }}</option>
                @else
                    <option value="active">{{ __('Visible') }}</option>
                    <option value="inactive">{{ __('Hidden') }}</option>
                @endif
            </select>

            @error('status')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image">Thumbnail Image</label>

            <img id="imgReview" src="{{ asset('storage/' . $data->image) }}" class="w-16 h-16 rounded-md mt-2"
                alt="Image Preview">
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <x-ui.button type="submit" class="w-full md:w-auto bg-red-500 hover:bg-red-600">
                {{ __('Delete Exhibition') }}
            </x-ui.button>

            <x-ui.button :href="route('admin.exhibition')" class="w-full md:w-auto">
                {{ __('Cancel') }}
            </x-ui.button>
        </div>
    </form>
@endsection
