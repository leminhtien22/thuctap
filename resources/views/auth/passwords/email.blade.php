@extends('layouts.auth')

@section('content')
    <div
        class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">

        <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            {{ __('Thay đổi mật khẩu') }}
        </h2>

        @if (session('success'))
            <x-ui.alert type="success">
                {{ session('success') }}
            </x-ui.alert>
        @endif


        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ route('password.email') }}">
            @csrf

            <x-form.input-field label="Email" name="email" type="email" required autofocus
                placeholder="example@gmail.com" />


            <x-ui.button type="submit" class="w-full">
                {{ __('Gửi link thay đổi') }}
            </x-ui.button>

            <p class="text-sm font-light text-gray-500 ">
                <span>{{ __('Bạn muốn quay trở lại?') }}</span>
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline">
                    {{ __('Đăng nhập') }}
                </a>
            </p>
        </form>
    </div>
@endsection
