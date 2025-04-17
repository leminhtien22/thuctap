@extends('layouts.app')

@section('title')
    {{ __('Trang chủ') }}
@endsection

@section('content')


   <!-- Giới thiệu bảo tàng nâng cấp -->
<section class="relative bg-gradient-to-b from-[#1c1c1c] via-[#2F2F2F] to-[#1c1c1c] py-20 px-4 md:px-12 lg:px-24 overflow-hidden">
    <div class="max-w-7xl mx-auto text-white">
        <!-- Tiêu đề -->
        <h1 class="text-4xl md:text-6xl font-bellefair text-center mb-16 text-[#f7c873] animate-fade-up duration-1000">
        {{ __('CHÀO MỪNG ĐẾN VỚI BẢO TÀNG TƯỢNG DÂN GIAN') }}</h1>

        <!-- Grid chia ảnh và nội dung -->
        <div class="grid md:grid-cols-2 gap-14 items-center">
            <!-- Ảnh tượng -->
            <div class="relative animate-fade-left duration-1000">
                <div class="overflow-hidden rounded-2xl border border-gray-700 shadow-xl group hover:shadow-2xl transition-all duration-500">
                    <div class="overflow-hidden w-full max-w-[600px] mx-auto rounded-2xl">
                        <img src="{{ asset('storage/images/AnDuongVuongXoaNen.png') }}" 
                             alt="Featured statue" 
                             class="w-full h-[600px] object-cover animate-pan rounded-2xl" />
                    </div>
                </div>

                <!-- Glow hiệu ứng -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-[#f7c873] opacity-10 rounded-full blur-3xl"></div>
            </div>

            <!-- Nội dung giới thiệu -->
            <div class="space-y-8 animate-fade-right duration-1000 text-[17px] leading-loose font-poppins">
                <div class="space-y-4">
                    <h2 class="text-2xl md:text-3xl font-bellefair text-[#f7c873] uppercase">Welcome to the Folk Statue Museum</h2>
                    <p>
                        Museums are important cultural and educational institutions in society, where artifacts of historical, 
                        cultural, scientific and artistic value are preserved, researched and displayed to serve the needs of learning, 
                        research and enjoyment of the public.
                    </p>
                    <p>
                        Museums are not simply places to store objects of the past but also bridges between history and the present, 
                        between people and knowledge.
                    </p>
                </div>

                <div class="space-y-3 border-t pt-6 border-gray-600">
                    <p>
                        Bảo tàng là thiết chế văn hóa giáo dục quan trọng trong xã hội, nơi lưu giữ, nghiên cứu và trưng bày 
                        các hiện vật có giá trị lịch sử, văn hóa, khoa học và nghệ thuật nhằm phục vụ cho nhu cầu học tập, 
                        nghiên cứu và thưởng thức của công chúng.
                    </p>
                    <p>
                        Bảo tàng không chỉ đơn thuần là nơi cất giữ những vật thể quá khứ mà còn là cầu nối giữa lịch sử và hiện tại, 
                        giữa con người và tri thức.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hiệu ứng CSS thêm vào -->
<style>
@keyframes flicker {
  0% { opacity: 1; filter: brightness(1) contrast(1); }
  25% { opacity: 0.8; filter: brightness(1.3) contrast(1.2); }
  50% { opacity: 0.5; filter: brightness(0.9) contrast(1.1); }
  75% { opacity: 0.9; filter: brightness(1.4) contrast(1.3); }
  100% { opacity: 1; filter: brightness(1) contrast(1); }
}

.flicker-glow:hover {
  animation: flicker 0.6s infinite alternate;
  box-shadow: 0 0 30px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.2);
  filter: saturate(1.4) brightness(1.2);
}

/* Auto pan effect on image */
@keyframes pan {
  0% { transform: scale(1.05) translateX(0); }
  50% { transform: scale(1.05) translateX(-10px); }
  100% { transform: scale(1.05) translateX(0); }
}

.animate-pan {
  animation: pan 8s ease-in-out infinite;
}
</style>







<!-- Triển lãm nghệ thuật hiện đại -->
<section class="mt-24 px-4 md:px-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Triển lãm nghệ thuật trong tuần</h2>
            <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
        </div>
        <a href="{{ route('client.exhibition') }}">
            <button
                class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
                Xem tất cả
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'ConHo.jpg', 'title' => 'Triển lãm đặc biệt', 'date' => '08:00 - Thứ Hai', 'desc' => 'Bảo tàng là nơi giao thoa giữa quá khứ và hiện tại, nơi lưu giữ những giá trị nghệ thuật vĩnh cửu.'],
            ['image' => 'LinhVat.jpg', 'title' => 'Chiều sâu văn hóa', 'date' => '08:00 - Thứ Ba', 'desc' => 'Mỗi buổi triển lãm là một hành trình khám phá chiều sâu văn hóa và nghệ thuật thế giới.'],
            ['image' => 'ConRong.jpg', 'title' => 'Không gian nghệ thuật', 'date' => '08:00 - Thứ Tư', 'desc' => 'Trải nghiệm không gian nghệ thuật đỉnh cao với các tác phẩm được tuyển chọn kỹ lưỡng.'],
        ] as $event)
        <div class="bg-[#1c1c1c] rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group border border-gray-800">
            <div class="overflow-hidden">
                <img src="{{ asset('storage/images/' . $event['image']) }}"
                     alt="{{ $event['title'] }}"
                     class="w-full h-[500px] object-cover transition-transform duration-500 group-hover:scale-110" />
            </div>
            <div class="p-6 space-y-3 text-white">
                <h3 class="text-2xl font-bellefair text-[#f7c873]">{{ $event['title'] }}</h3>
                <p class="text-sm font-light text-gray-400">{{ $event['date'] }}</p>
                <p class="text-[15px] font-poppins leading-relaxed">{{ $event['desc'] }}</p>
                <a href="{{ route('client.exhibition') }}"
                   class="inline-block mt-4 text-sm text-[#f7c873] font-medium hover:underline hover:text-white transition">
                    Đặt vé →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>




<section class="mt-24 px-4 md:px-12">
<div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Triển lãm và sự kiện nổi bật</h2>
            <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
        </div>
        <a href="{{ route('client.exhibition') }}">
            <button
                class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
                Xem tất cả
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach ([
            [
                'image' => 'HoPhap.jpg',
                'title' => 'Hiroshige',
                'subtitle' => 'Nghệ sĩ của những cung đường',
                'date' => '1 May – 7 September 2025',
                'button_color' => 'bg-gray-300 text-black'
            ],
            [
                'image' => 'PhatBaQuanAm.jpg',
                'title' => 'Ấn Độ cổ đại',
                'subtitle' => 'truyền thống sống mãi',
                'date' => '22 May – 19 October 2025',
                'button_color' => 'bg-yellow-400 text-black'
            ]
        ] as $item)
        <div class="flex bg-[#1a1a1a] rounded-xl overflow-hidden border border-gray-700">
            <div class="w-1/2 p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-white">{{ $item['title'] }}</h3>
                    <p class="text-lg text-[#f7c873] mb-4">{{ $item['subtitle'] }}</p>
                    <p class="text-sm text-gray-400 mb-2">Triển lãm</p>
                    <p class="text-sm text-white">{{ $item['date'] }}</p>
                </div>
                <a href="{{ route('client.exhibition') }}"
                   class="inline-block mt-4 text-sm text-[#f7c873] font-medium hover:underline hover:text-white transition">
                    Đặt vé →
                </a>
            </div>
            <div class="w-1/2 h-full">
                <img src="{{ asset('storage/images/' . $item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover" />
            </div>
        </div>
        @endforeach
    </div>
</section>





<!-- Bài viết hiện đại -->
<section class="mt-24 px-4 md:px-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Bài viết nổi bật</h2>
            <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
        </div>
        <a href="{{ route('client.post') }}">
            <button
                class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
                Xem tất cả
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'HoPhap.jpg', 'title' => 'Linh thiêng giữa đời thường', 'date' => '', 'desc' => 'Khám phá không gian tín ngưỡng dân gian qua từng bức tượng được gìn giữ kỹ lưỡng.'],
            ['image' => 'PhatBaQuanAm.jpg', 'title' => 'Phật Bà Quan Âm & văn hóa Việt', 'date' => '', 'desc' => 'Tìm hiểu về tín ngưỡng thờ Mẹ trong văn hóa người Việt xưa và nay.'],
            ['image' => 'LinhVat.jpg', 'title' => 'Linh vật và tâm linh', 'date' => '', 'desc' => 'Sự hiện diện của linh vật trong đời sống và tín ngưỡng dân gian.'],
        ] as $post)
        <div class="bg-[#1c1c1c] rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group border border-gray-800">
            <div class="overflow-hidden">
                <img src="{{ asset('storage/images/' . $post['image']) }}"
                     alt="{{ $post['title'] }}"
                     class="w-full h-[500px] object-cover transition-transform duration-500 group-hover:scale-110" />
            </div>
            <div class="p-6 space-y-3 text-white">
                <h3 class="text-2xl font-bellefair text-[#f7c873]">{{ $post['title'] }}</h3>
                <p class="text-sm font-light text-gray-400">{{ $post['date'] }}</p>
                <p class="text-[15px] font-poppins leading-relaxed">{{ $post['desc'] }}</p>
                <a href="{{ route('client.post') }}"
                   class="inline-block mt-4 text-sm text-[#f7c873] font-medium hover:underline hover:text-white transition">
                    Đọc thêm →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>





<div class="space-y-3 border-t pt-6 border-[#2F2F2F]"></div>
   <!-- Carousel Section -->
<section class="relative bg-gradient-to-b from-[#1c1c1c] via-[#2F2F2F] to-[#1c1c1c] py-10 px-4 md:px-12 lg:px-24 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12 text-center">
            <h2 class="text-4xl md:text-5xl font-bellefair text-[#f7c873] mb-2">Bộ sưu tập tiêu biểu</h2>
            <p class="text-gray-400 font-light text-lg">Hành trình qua các tác phẩm nổi bật của bảo tàng</p>
        </div>

        <!-- Swiper Container -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ([
                    ['image' => 'HoPhap.jpg', 'caption' => 'Hộ Pháp – Biểu tượng bảo vệ'],
                    ['image' => 'PhatBaQuanAm.jpg', 'caption' => 'Phật Bà Quan Âm – Lòng từ bi và che chở'],
                    ['image' => 'LinhVat.jpg', 'caption' => 'Linh Vật – Sức mạnh tâm linh'],
                    ['image' => 'AnDuongVuongXoaNen.png', 'caption' => 'An Dương Vương – Huyền thoại dựng nước']
                ] as $slide)
                <div class="swiper-slide group bg-[#1a1a1a] rounded-2xl overflow-hidden shadow-lg border border-gray-700">
                    <div class="overflow-hidden">
                        <img src="{{ asset('storage/images/' . $slide['image']) }}" alt="{{ $slide['caption'] }}"
                             class="w-full h-[1200px] object-cover transition-transform duration-500 group-hover:scale-105" />
                    </div>
                    <div class="p-4 text-white font-poppins text-center">
                        <p class="text-lg text-[#f7c873] font-bellefair">{{ $slide['caption'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-center gap-4 mt-6">
                <div class="swiper-button-prev text-[#f7c873] !static"></div>
                <div class="swiper-button-next text-[#f7c873] !static"></div>
            </div>
        </div>
    </div>
</section>







    <!-- Bộ sưu tập hiện đại -->
<section class="mt-24 px-4 md:px-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Bộ sưu tập</h2>
            <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
        </div>
        <a href="{{ route('client.collection') }}">
            <button
                class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
                Xem tất cả
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'PhatBaQuanAm.jpg', 'title' => 'Phật Bà Quan Âm', 'desc' => 'Biểu tượng của lòng từ bi và sự che chở trong tín ngưỡng dân gian.'],
            ['image' => 'TuPhap.jpg', 'title' => 'Tứ Pháp', 'desc' => 'Bốn vị nữ thần đại diện cho mưa, sấm, chớp và mây – cội nguồn của nông nghiệp.'],
            ['image' => 'ThanhGiong.jpg', 'title' => 'Thánh Gióng', 'desc' => 'Hình tượng người anh hùng làng quê đứng lên đánh giặc giữ nước.'],
        ] as $item)
        <div class="bg-[#1c1c1c] rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group border border-gray-800">
            <div class="overflow-hidden">
                <img src="{{ asset('storage/images/' . $item['image']) }}"
                     alt="{{ $item['title'] }}"
                     class="w-full h-[500px] object-cover transition-transform duration-500 group-hover:scale-110" />
            </div>
            <div class="p-6 space-y-3 text-white">
                <h3 class="text-2xl font-bellefair text-[#f7c873]">{{ $item['title'] }}</h3>
                <p class="text-[15px] font-poppins leading-relaxed">{{ $item['desc'] }}</p>
                <a href="{{ route('client.collection') }}"
                   class="inline-block mt-4 text-sm text-[#f7c873] font-medium hover:underline hover:text-white transition">
                    Xem chi tiết →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>


@endsection
