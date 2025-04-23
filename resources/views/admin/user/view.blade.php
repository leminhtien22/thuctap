@extends('layouts.dashboard')

@section('title')
    {{ __('Users') }}
@endsection

@php
    $columns = ['Name', 'Email', 'Role', 'Status', 'Actions'];
@endphp

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[['url' => 'admin.user', 'label' => 'Users']]" />

    <!-- Start coding here -->
    <x-common.section-action title="Manage Users" description="List of users in the system">
        <x-ui.button :href="route('admin.user.create')">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor"
                    aria-hidden="true">
                    <path
                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                </svg>
            </x-slot>

            <span>Add New</span>
        </x-ui.button>
    </x-common.section-action>

    @if (session('success'))
        <x-ui.alert type="success">
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <x-ui.table :columns="$columns">
        <x-slot:body>
            @forelse ($users as $user)
                <x-ui.table-row>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                class="size-8 rounded-full mr-2 inline-block">
                        @else
                            <img src="{{ asset('storage/default-avatar.png') }}" alt="{{ $user->name }}"
                                class="size-8 rounded-full mr-2 inline-block">
                        @endif

                        {{ $user->name }}
                    </th>

                    <td class="px-6 py-4">
                        {{ $user->email }}
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge :text="$user->role" :color="$user->role == 'admin' ? 'red' : 'green'" class="capitalize" />
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge text="{{ $user->status == 'active' ? 'Active' : 'Blocked' }}" :color="$user->status == 'active' ? 'green' : 'red'" />
                    </td>

                    <td class="px-6 py-4 text-nowrap">
                        <a href={{ route('admin.user.edit', $user->id) }}
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline {{ $user->role == 'admin' ? 'hidden' : '' }}">Edit</a>

                        @if ($user->status == 'active')
                            <a href={{ route('admin.user.ban', $user->id) }}
                                class="font-medium text-red-600 dark:text-red-500 hover:underline ml-4 {{ $user->role == 'admin' ? 'hidden' : '' }}">Block</a>
                        @else
                            <a href={{ route('admin.user.unBan', $user->id) }}
                                class="font-medium text-green-600 dark:text-green-500 hover:underline ml-4 {{ $user->role == 'admin' ? 'hidden' : '' }}">Unblock</a>
                        @endif
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
        <x-common.pagination-info :paginator="$users" unit="users" />
        <x-ui.pagination :paginator="$users" />
    </div>
@endsection


<script>
    setTimeout(() => {
        document.querySelector('#alert')?.remove();
    }, 3000);
</script>
