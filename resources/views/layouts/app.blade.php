<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $settings = \App\Models\SiteSetting::first();
    @endphp

    <title>{{ $settings->site_name }}</title>
    <meta name="description" content="{{ $settings->site_description }}">
    <meta name="keywords" content="{{ $settings->keywords }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=EB+Garamond&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-gradient-hero {
            background: linear-gradient(32deg, rgba(17, 17, 17, 1) 0%, rgba(0, 0, 0, 0) 100%);
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body class="bg-black">
    <div class="max-w-full mx-auto overflow-hidden">
        <!-- Navigation -->
        <nav class="bg-black relative z-10">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="p-6">
                        <div class="text-white font-serif" style="font-family: 'EB Garamond', serif;">
                            <div class="text-[20px] leading-none">The</div>
                            <div class="text-[25px] leading-tight font-medium">Folk Museum</div>
                        </div>
                    </div>
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-6 items-center">
                        <div class="relative group">
                            <a href="{{ route('home') }}" class="uppercase text-white text-sm font-medium flex items-center space-x-1 hover:underline">
                                <span>Home</span>
                            </a>
                        </div>
                        <div class="relative group">
                            <a href="{{ route('client.exhibition') }}" class="uppercase text-white text-sm font-medium flex items-center space-x-1 hover:underline">
                                <span>Exhibition</span>
                            </a>
                        </div>
                        <div class="relative group">
                            <a href="{{ route('client.collection') }}" class="uppercase text-white text-sm font-medium flex items-center space-x-1 hover:underline">
                                <span>Collection</span>
                            </a>
                        </div>
                        <div class="relative group">
                            <a href="{{ route('client.shop') }}" class="uppercase text-white text-sm font-medium flex items-center space-x-1 hover:underline">
                                <span>Shop</span>
                            </a>
                        </div>
                        <a href="{{ route('client.post') }}" class="uppercase text-white text-sm font-medium hover:underline">Blog</a>
                        @auth
                            <div class="relative">
                                <button type="button" data-dropdown-toggle="dropdown-user" class="flex items-center text-sm rounded-full focus:outline-none">
                                    <img class="w-8 h-8 rounded-full" src="{{ asset('storage/images/LoGoXoaNen.png') }}" alt="user photo" loading="lazy">
                                </button>
                                <div class="z-50 hidden text-base list-none bg-[#1A1A1A] divide-y divide-gray-600 rounded shadow" id="dropdown-user">
                                    <div class="px-4 py-3">
                                        <p class="text-sm text-white">{{ Auth::user()->name }}</p>
                                        <p class="text-sm font-medium text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    <ul class="py-1 text-left">
                                        <li>
                                            <button data-modal-target="popup-modal-logout" data-modal-toggle="popup-modal-logout" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-black">Logout</button>
                                        </li>
                                        <li>
                                            <a href="{{ route('client.exhibition.ticket.history') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-black">Ticket History</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('client.user.setting') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-black">Account Settings</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('client.post.history') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-black">Post View History</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('order.history') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-black">Order History</a>
                                        </li>
                                        @if (Auth::user()->is_admin)
                                            <li>
                                                <a href="{{ route('admin.post') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-black">Admin Dashboard</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="uppercase text-white text-sm font-medium hover:underline">Login</a>
                        @endguest
                    </div>
                    <!-- Mobile button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" data-collapse-toggle="mobile-menu" class="text-gray-400 hover:text-white focus:outline-none focus:text-white">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="hidden md:hidden px-4 pt-4 pb-6 space-y-4" id="mobile-menu">
                <a href="{{ route('home') }}" class="block text-white text-base font-medium uppercase py-2">Home</a>
                <a href="{{ route('client.exhibition') }}" class="block text-white text-base font-medium uppercase py-2">Exhibition</a>
                <a href="{{ route('client.collection') }}" class="block text-white text-base font-medium uppercase py-2">Collection</a>
                @auth
                    <a href="{{ route('client.post') }}" class="block text-white text-base font-medium uppercase py-2">Blog</a>
                @endauth
                <a href="{{ route('client.shop') }}" class="block text-white text-base font-medium uppercase py-2">Shop</a>
                @guest
                    <a href="{{ route('login') }}" class="block text-white text-base font-medium uppercase py-2">Login</a>
                @endguest
            </div>
        </nav>

        @yield('content')

        <!-- Footer -->
<footer class="flex flex-col md:flex-row justify-between items-start mt-12 bg-black from-gray-800 to-blue-900 p-8 text-white">
    <!-- Logo Section (Left) -->
    <div class="w-full md:w-1/4 mb-8 md:mb-0">
        <div class="flex flex-col items-center md:items-start mb-6">
            <img class="w-16 h-auto transform hover:scale-105 transition-transform duration-300" alt="Museum logo" src="{{ asset('storage/images/LoGoXoaNen.png') }}" loading="lazy">
            <div class="font-baskervville font-normal text-sm text-center md:text-left mt-2">
                <a href="{{ route('home') }}" class="hover:text-gray-300 transition-colors duration-300">MUSEUM</a>
            </div>
        </div>
    </div>

    <!-- Follow Us Section (Center) -->
    <div class="w-full md:w-1/2 mb-8 md:mb-0 flex justify-center">
        <div class="text-center">
            <h3 class="font-baskervville font-normal text-2x1 mb-3 text-gray-100">{{ __('Follow Us') }}</h3>
            <div class="flex justify-center space-x-5">
                @php
                    $fb = $configurations['facebook']->value ?? '#';
                    $ig = $configurations['instagram']->value ?? '#';
                    $tt = $configurations['tiktok']->value ?? '#';
                    $yt = $configurations['youtube']->value ?? '#';
                @endphp
                <a href="{{ $fb }}" class="text-white hover:text-gray-300 transform hover:scale-110 transition-all duration-300">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.987C18.343 21.128 22 16.991 22 12z"/>
                    </svg>
                </a>
                <a href="{{ $ig }}" class="text-white hover:text-gray-300 transform hover:scale-110 transition-all duration-300">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.326 3.608 1.301.975.975 1.24 2.242 1.301 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.326 2.633-1.301 3.608-.975.975-2.242 1.24-3.608 1.301-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.326-3.608-1.301-.975-.975-1.24-2.242-1.301-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.326-2.633 1.301-3.608.975-.975 2.242-1.24 3.608-1.301 1.266-.058 1.646-.07 4.85-.07zm0-2.163C8.735 0 8.332.013 7.052.072 5.771.132 4.407.41 3.225 1.592 2.043 2.774 1.765 4.138 1.705 5.419 1.646 6.699 1.633 7.102 1.633 12s.013 5.301.072 6.581c.06 1.281.338 2.645 1.52 3.827 1.182 1.182 2.546 1.46 3.827 1.52 1.28.059 1.683.072 6.581.072s5.301-.013 6.581-.072c.06 1.281-.338 2.645-1.52 3.827-1.182 1.182-2.546 1.46-3.827 1.52C16.301.013 15.898 0 12 0z"/>
                        <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z"/>
                    </svg>
                </a>
                <a href="{{ $tt }}" class="text-white hover:text-gray-300 transform hover:scale-110 transition-all duration-300">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.89 2.89 0 011.14.23V9.34a6.34 6.34 0 00-1.14-.1A6.34 6.34 0 004 15.68a6.34 6.34 0 0010.72 4.58A6.34 6.34 0 0016 15.68V9.83a8.31 8.31 0 003.82 1V7.31a4.83 4.83 0 01-.23-.62z"/>
                    </svg>
                </a>
                <a href="{{ $yt }}" class="text-white hover:text-gray-300 transform hover:scale-110 transition-all duration-300">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.016 3.016 0 00.502 6.186 31.63 31.63 0 000 12a31.63 31.63 0 00.502 5.814 3.016 3.016 0 002.122 2.136c1.872.505 9.377.505 9.377.505s7.505 0 9.377-.505a3.016 3.016 0 002.122-2.136A31.63 31.63 0 0024 12a31.63 31.63 0 00-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Museum Information Section (Right) -->
    <div class="w-full md:w-1/4 text-right">
        <div class="space-y-3">
        <h2 class="font-poppins font-semibold text-3xl text-gray-100">{{ __('Museum Information') }}</h2>
            <span class="block font-poppins font-light text-lg text-gray-300 hover:text-white transition-colors duration-300">{{ get_system_config('contact_email', 'leminhtien020202@gmail.com') }}</span>
            <span class="block font-poppins font-light text-lg text-gray-300 hover:text-white transition-colors duration-300">{{ $configurations['address']->value ?? 'Ninh Kieu, Can Tho' }}</span>
        </div>
    </div>
</footer>

<!-- Copyright Section -->
<section class="flex flex-col items-center text-center mt-12 py-8 bg-black from-gray-800 to-blue-900">
    <div>
        <div class="flex flex-col items-center">
            <img class="w-[54px] h-[54px] object-cover transform hover:scale-105 transition-transform duration-300" alt="UXM logo" src="https://c.animaapp.com/m8peu9m38cRc1i/img/fav-icon-1.png" loading="lazy">
        </div>
        <div class="font-poppins font-light text-gray-300 text-sm mt-4 max-w-md mx-auto">
            Free to use for commercial and personal purposes. If you need to develop websites or Amazon apps, please contact the email above.
        </div>
        <div class="font-poppins font-light text-gray-300 text-sm mt-3">
            If you're using it, please give us some <a href="#" class="text-white hover:underline transition-all duration-300">feedback</a>.
        </div>
    </div>
</section>

<!-- Logout Modal -->
<div id="popup-modal-logout" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] backdrop-blur-lg justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-gradient-to-br from-gray-800 to-blue-900/80 backdrop-blur-md rounded-xl shadow-lg border border-gray-600/50">
            <button type="button" class="absolute top-4 end-4 text-gray-300 bg-transparent hover:bg-gray-600 hover:text-white rounded-full text-sm w-10 h-10 ms-auto inline-flex justify-center items-center transition-all duration-300" data-modal-hide="popup-modal-logout">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 md:p-8 text-center">
                <svg class="mx-auto mb-5 text-gray-400 w-14 h-14 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-6 text-xl font-medium text-gray-200 dark:text-gray-100">Are you sure you want to logout?</h3>
                <div class="flex justify-center gap-4">
                    <button data-modal-hide="popup-modal-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" type="button" class="text-white bg-gradient-to-r from-gray-600 to-blue-800 hover:from-gray-500 hover:to-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-6 py-3 transition-all duration-300">Confirm</button>
                    <button data-modal-hide="popup-modal-logout" type="button" class="text-gray-200 bg-transparent border border-gray-500 hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm px-6 py-3 transition-all duration-300">Cancel</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            disable: window.innerWidth < 768
        });
    </script>
</body>
</html>