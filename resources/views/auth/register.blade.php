@extends('layouts.auth')

@section('title')
    {{ __('Tạo tài khoản') }}
@endsection

@section('content')
    <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                {{ __('Tạo tài khoản mới') }}
            </h1>
            
            <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <x-form.input-field name="name" label="Họ và tên" :value="old('name')" required
                    placeholder="VD: Nguyễn Văn A" />

                <x-form.input-field name="email" label="Email" type="email" :value="old('email')" required
                    placeholder="VD: example@gmail.com" />

                <x-form.input-field name="password" label="Mật khẩu" type="password" :value="old('password')" required
                    placeholder="••••••••" />

                <x-form.input-field name="password_confirmation" label="Xác nhận mật khẩu" :value="old('password_confirmation')" type="password"
                    required placeholder="••••••••" />


                <x-ui.button type="submit" class="w-full">
                    {{ __('Tạo tài khoản') }}
                </x-ui.button>

                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    <span>{{ __('Bạn đã có tài khoản?') }}</span>
                    <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                        {{ __('Đăng nhập') }}
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
