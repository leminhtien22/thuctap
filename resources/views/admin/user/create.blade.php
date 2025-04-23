@extends('layouts.dashboard')

@section('title')
    {{ __('Add User') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[ 
        ['url' => 'admin.user', 'label' => 'Users'],
        ['url' => 'admin.user.create', 'label' => 'Add User'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.user.create') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <x-form.input-field name="name" label="Full Name" :value="old('name')" required placeholder="e.g., John Doe" />
        <x-form.input-field name="email" label="Email" type="email" :value="old('email')" required
            placeholder="e.g., john.doe@example.com" />
        <x-form.input-field name="password" label="Password" type="password" :value="old('password')" required
            placeholder="••••••••" />
        <x-form.input-field name="password_confirmation" label="Confirm Password" :value="old('password_confirmation')" type="password"
            required placeholder="••••••••" />

        <div>
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(event)">

            <img id="avatarPreview" src="{{ asset('storage/default-avatar.png') }}" class="w-16 h-16 rounded-full mt-2"
                alt="Avatar Preview">

            @error('avatar')
                <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Add User') }}
        </x-ui.button>
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
