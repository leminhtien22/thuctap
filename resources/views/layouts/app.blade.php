<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Museum') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Baskervville:400|Bellefair:400|Poppins:300,400|Roboto:300,500"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-gradient-hero {
            background: linear-gradient(32deg, rgba(17, 17, 17, 1) 0%, rgba(0, 0, 0, 0) 100%);
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

</head>
<body class="bg-[#2F2F2F]"> <!--đổi màu bg chổ này -->
    <div class="w-[1440px] mx-auto overflow-hidden">
        <!-- Navigation -->
        <!-- Navigation -->
<nav class="bg-[#2F2F2F] relative z-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img class="h-10 w-auto" src="{{ asset('storage/images/LoGoXoaNen.png') }}" alt="Museum logo">
                    <span class="font-baskervville text-white text-sm tracking-wide">MUSEUM</span>
                </a>
            </div>


            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('home') }}" class="uppercase text-white text-xs font-baskervville hover:underline">{{ __('Trang chủ') }}</a>
                <a href="{{ route('client.exhibition') }}" class="uppercase text-white text-xs font-baskervville hover:underline">{{ __('Buổi triển lãm') }}</a>

                @guest
                    
                @endguest

                <a href="{{ route('client.post') }}" class="uppercase text-white text-xs font-baskervville hover:underline">{{ __('Bài viết') }}</a>
                @auth
                    
                    
                @endauth
                <a href="{{ route('client.collection') }}" class="uppercase text-white text-xs font-baskervville hover:underline">{{ __('Bộ sưu tập') }}</a>
                <a href="{{ route('cart') }}" class="uppercase text-white text-xs font-baskervville hover:underline">{{ __('Giỏ hàng') }}</a>
                <div class="relative group">
    <!-- Nút hiển thị quốc kỳ hiện tại -->
    <button type="button"
        class="w-8 h-8 rounded-full overflow-hidden border-2 border-gray-300 hover:ring-2 hover:ring-white focus:outline-none">
        @php
            $locale = get_locale();
            $flag = $locale === 'vi' ? 'CoVN.jpg' : 'CoUK.png'; // đổi tên file ảnh theo đúng thư mục bạn lưu
        @endphp
        <img src="{{ asset('storage/images/' . $flag) }}" alt="Flag" class="w-full h-full object-cover">
    </button>

    <!-- Dropdown chọn ngôn ngữ -->
    <div
        class="absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transform -translate-y-2 transition-all duration-200 z-50">
        <a href="{{ route('change.language', 'vi') }}"
            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
            vi Tiếng Việt
        </a>
        <a href="{{ route('change.language', 'en') }}"
            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
            en English
        </a>
        
    </div>
</div>


                @guest
                    <a href="{{ route('login') }}" class="uppercase text-white text-xs font-baskervville hover:underline">{{ __('Đăng nhập') }}</a>
                    
                @else
                    <div class="relative">
                        <button type="button" data-dropdown-toggle="dropdown-user" class="flex items-center text-sm rounded-full focus:outline-none">
                            <img class="w-8 h-8 rounded-full" src="{{ asset('storage/images/QuanCong.jpg') }}" alt="user photo">
                        </button>
                        <div class="z-50 hidden text-base list-none bg-[#2F2F2F] divide-y divide-gray-100 rounded shadow" id="dropdown-user">
                            <div class="px-4 py-3">
                                <p class="text-sm text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm font-medium text-gray-300 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <ul class="py-1 text-left">
                                <li>
                                    <button data-modal-target="popup-modal-logout" data-modal-toggle="popup-modal-logout" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Đăng xuất</button>
                                </li>
                                <li>
                                    <a href="{{ route('client.exhibition.ticket.history') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Lịch sử đặt vé</a>
                                </li>
                             
                                <li>
                                    <a href="{{ route('order.history') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Lịch sử đặt hàng</a>
                                </li>
                                @if (Auth::user()->is_admin)
                                    <li>
                                        <a href="{{ route('admin.post') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Quản trị website</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile button -->
            <div class="md:hidden flex items-center">
                <button type="button" data-collapse-toggle="mobile-menu" class="text-gray-400 hover:text-white focus:outline-none focus:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden md:hidden px-4 pt-4 pb-6 space-y-2" id="mobile-menu">
        <a href="{{ route('home') }}" class="block text-white text-sm font-baskervville">{{ __('Trang chủ') }}</a>
        <a href="{{ route('client.exhibition') }}" class="block text-white text-sm font-baskervville">{{ __('Buổi triển lãm') }}</a>
        <a href="{{ route('client.collection') }}" class="block text-white text-sm font-baskervville">{{ __('Bộ sưu tập') }}</a>
        @auth
            <a href="{{ route('client.post') }}" class="block text-white text-sm font-baskervville">{{ __('Bài viết') }}</a>
        @endauth
        <a href="{{ route('cart') }}" class="block text-white text-sm font-baskervville">{{ __('Giỏ hàng') }}</a>
        @guest
            <a href="{{ route('login') }}" class="block text-white text-sm font-baskervville">{{ __('Đăng nhập') }}</a>
        @endguest
    </div>
</nav>


        @yield('content')

        <!-- Footer -->
        <footer class="flex flex-col md:flex-row justify-between items-start mt-12 bg-[#2F2F2F] p-8 text-white">
    <!-- Cột bên trái - Logo và menu -->
    <div class="w-full md:w-auto mb-8 md:mb-0">
        <!-- Logo nhỏ -->
        <div class="flex flex-col items-center md:items-start mb-6">
            <img class="w-12 h-auto" alt="Museum logo" src="{{ asset('storage/images/LoGoXoaNen.png') }}">
            <div class="font-baskervville font-normal text-xs text-center md:text-left mt-1">
                MUSEUM
            </div>
        </div>

        <!-- Các liên kết menu -->
        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
            <a href="#" class="font-baskervville font-normal text-xs hover:underline transition">
                TRANG CHỦ
            </a>
            <a href="{{ route('client.exhibition') }}" class="font-baskervville font-normal text-xs hover:underline transition">
                SỰ KIỆN
            </a>
            <a href="{{ route('client.collection') }}" class="font-baskervville font-normal text-xs hover:underline transition">
                BỘ SƯU TẬP
            </a>
            <a href="{{ route('client.post') }}" class="font-baskervville font-normal text-xs hover:underline transition">
                BÀI VIẾT
            </a>
            <a href="#" class="font-baskervville font-normal text-xs hover:underline transition">
                LỊCH SỬ
            </a>
            <a href="#" class="font-baskervville font-normal text-xs hover:underline transition">
                LIÊN HỆ
            </a>
        </div>
    </div>

    <!-- Cột bên phải - Thông tin liên hệ -->
    <div class="w-full md:w-1/2">
        <h3 class="font-baskervville font-normal text-xl mb-3">
            BẢN TIN
        </h3>
        
        <p class="font-poppins font-light text-xs mb-6">
            NHẬN TIN CẬP NHẬT HÀNG NGÀY VỀ SỰ KIỆN, SẢN PHẨM VÀ NHIỀU THÔNG TIN KHÁC
        </p>

        <div class="space-y-4">
            <h4 class="font-poppins font-light text-xs">
                LIÊN HỆ VỚI CHÚNG TÔI
            </h4>

            <div class="flex items-center gap-3">
                <img class="w-4 h-4" alt="Email icon" src="https://c.animaapp.com/m8peu9m38cRc1i/img/frame-1.svg">
                <span class="font-poppins font-light text-xs">
                    leminhtien020202@gmail.com
                </span>
            </div>

            <div class="flex items-center gap-3">
                <img class="w-4 h-4" alt="Location icon" src="https://c.animaapp.com/m8peu9m38cRc1i/img/frame-5.svg">
                <span class="font-poppins font-light text-xs">
                    Ninh Kiều, Cần Thơ
                </span>
            </div>
        </div>
    </div>
</footer>

        <!-- Copyright Section -->
        <section class="flex flex-col items-center text-center mt-12 py-8">
            <div>
                <div class="">
                    <div class="flex flex-col items-center">
                        <div class="font-poppins font-light text-white text-[11.6px] tracking-[0] leading-[normal]">
                        Thiết kế và phát triển bởi Lê Minh Tiến
                        </div>
                        <img class="w-[54px] h-[54px] object-cover" alt="UXM logo"
                            src="https://c.animaapp.com/m8peu9m38cRc1i/img/fav-icon-1.png">
                    </div>

                    <div class="font-poppins font-light text-white text-[11.6px] tracking-[0] leading-[normal]">
                    miễn phí sử dụng cho mục đích thương mại và cá nhân. nếu bạn cần phát triển trang web và ứng 
                    dụng amazon hãy kết nối với id email ở trên
                    </div>
                </div>

                <div class="font-poppins font-light text-white text-[11.6px] tracking-[0] leading-[normal] mt-4">
                nếu bạn đang sử dụng nó xin vui lòng cho chúng tôi một số thông tin
                </div>
            </div>
        </section>
    </div>

    <div id="popup-modal-logout" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] #FFFFFF backdrop-blur-sm justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative #FFFFFF rounded-lg shadow-sm dark:bg-[#2F2F2F]">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-[#FFFFFF] hover:bg-[#2F2F2F] hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal-logout">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Bạn có chắc muốn đăng xuất không?</h3>
                    <button data-modal-hide="popup-modal-logout"
                        onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"
                        type="button"
                        class="text-white bg-[#2F2F2F] hover:bg-[#2F2F2F] focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Đồng ý
                    </button>

                    <button data-modal-hide="popup-modal-logout" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-[#2F2F2F] rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Huỷ
                        bỏ</button>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script> 
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>

</html>
