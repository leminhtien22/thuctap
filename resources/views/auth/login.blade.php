@extends('layouts.auth')

@section('title')
    {{ __('Đăng nhập') }}
@endsection

@section('content')
    <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                {{ __('Đăng nhập') }}
            </h1>

            <form class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <x-form.input-field name="email" type="email" label="Họ và tên" :value="old('email')" required
                    placeholder="VD: example@gmail.com" />

                <x-form.input-field name="password" label="Mật khẩu" type="password" :value="old('password')" required
                    placeholder="••••••••" />

                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300"
                                name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        </div>

                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 "> {{ __('Lưu đăng nhập') }}</label>
                        </div>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:underline">
                            {{ __('Quên mật khẩu?') }}
                        </a>
                    @endif
                </div>

                <x-ui.button type="submit" class="w-full">
                    {{ __('Đăng nhập') }}
                </x-ui.button>

                <p class="text-sm font-light text-gray-500 ">
                    <span>{{ __('Bạn chưa có tài khoản?') }}</span>
                    <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:underline">
                        {{ __('Đăng ký') }}
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
