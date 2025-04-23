@extends('layouts.dashboard')

@section('title')
    {{ __('Ban User Account') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[ 
        ['url' => 'admin.user', 'label' => 'Users'],
        ['url' => 'admin.user.create', 'label' => 'Ban User Account'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.user.ban', $user->id) }}" method="POST">
        @csrf

        <x-form.input-field readonly name="name" label="Full Name" :value="old('name') ?? $user->name" required
            placeholder="e.g., John Doe" />
        <x-form.input-field readonly name="email" label="Email" type="email" :value="old('email') ?? $user->email" required
            placeholder="e.g., john.doe@example.com" />

        <div>
            <img id="avatarPreview"
                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/default-avatar.png') }}"
                class="w-16 h-16 rounded-full mt-2" alt="Avatar Preview">
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <x-ui.button type="submit" class="w-full md:w-auto bg-red-500 hover:bg-red-600">
                {{ __('Ban Account') }}
            </x-ui.button>

            <x-ui.button :href="route('admin.user')" class="w-full md:w-auto">
                {{ __('Cancel') }}
            </x-ui.button>
        </div>
    </form>
@endsection


<script>
    function previewAvatar(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('avatarPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
