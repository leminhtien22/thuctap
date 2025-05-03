@extends('layouts.app')

@section('title')
    {{ __('FOLKLORE MUSEUM') }}
@endsection

@section('content')

<?php
$title = "WELCOME TO THE FOLK SCULPTURE MUSEUM";
$subtitle = "Experience cultures across the globe, from the dawn of human history to the present.";
$button_text = "Plan your visit";
$button_link = "exhibition";
$image_url = "storage/images/AI5.png"; // Đường dẫn hình ảnh
$footer_text = "Discover two million years of human history and culture";
$info_items = [
    "Open today: 10:00–17:00",
    "Last entry: 16:45"
];
?>

<section class="relative w-full overflow-hidden bg-black">
    <div class="relative w-full h-[600px] group">
        <img src="<?php echo $image_url; ?>" alt="Museum hero image"
             class="absolute inset-0 w-full h-full object-cover brightness-75 group-hover:brightness-90 group-hover:scale-105 transition-all duration-700">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/60 to-black"></div>
        <div class="absolute top-0 left-0 flex flex-col items-start justify-center text-left px-6 md:px-12 lg:px-20 h-full">
            <div class="bg-black bg-opacity-70 p-6 rounded-lg max-w-sm"> <!-- Changed bg-gray-800 bg-opacity-90 to bg-black bg-opacity-70 -->
                <h1 class="text-white text-[28px] md:text-[36px] leading-tight mb-4 font-bold">
                    <?php echo $title; ?>
                </h1>
                <p class="text-gray-300 text-[14px] md:text-[16px] mb-6">
                    <?php echo $subtitle; ?>
                </p>
                <a href="<?php echo $button_link; ?>"
                   class="bg-white text-black font-semibold px-6 py-2 rounded-full text-md hover:bg-gray-200 transition flex items-center gap-2"> <!-- Changed bg-gray-600 text-white to bg-white text-black, hover:bg-gray-700 to hover:bg-gray-200 -->
                    <?php echo $button_text; ?>
                    <span class="w-4 h-4 rounded-full bg-gray-800 flex items-center justify-center"> <!-- Changed bg-white to bg-gray-800 -->
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"> <!-- Changed text-gray-800 to text-white -->
                            <circle cx="10" cy="10" r="10"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-80 text-white py-4 px-6 flex flex-col md:flex-row justify-between items-start md:items-center">
        <h2 class="text-[18px] md:text-[24px] font-semibold mb-2 md:mb-0">
            <?php echo $footer_text; ?>
        </h2>
        <div class="flex flex-col gap-1 text-[14px] md:text-[16px]">
            <?php foreach ($info_items as $item): ?>
                <div class="flex items-center gap-2">
                    <span class="text-gray-400">●</span>
                    <span><?php echo $item; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>




<!-- Art Exhibition of the Week -->
<section class="mt-24 px-4 md:px-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Art Exhibition of the Week</h2>
            <div class="mt-2 h-1 w-28 bg-white"></div>
        </div>
        <a href="{{ route('client.exhibition') }}">
            <button
                class="px-6 py-3 rounded-full border border-white text-white hover:bg-white hover:text-black transition font-semibold">
                See all
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'ConHo.jpg', 'title' => 'Special Exhibition', 'date' => '08:00 - Monday', 'desc' => 'The museum is a meeting point between past and present, preserving timeless artistic values.'],
            ['image' => 'LinhVat.jpg', 'title' => 'Cultural Depth', 'date' => '08:00 - Tuesday', 'desc' => 'Each exhibition is a journey to explore the depth of world culture and art.'],
            ['image' => 'ConRong.jpg', 'title' => 'Artistic Space', 'date' => '08:00 - Wednesday', 'desc' => 'Experience a top-tier artistic space with carefully curated artworks.'],
        ] as $event)
        <div class="bg-[#1c1c1c] shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group border border-gray-800">
            <div class="overflow-hidden">
                <img src="{{ asset('storage/images/' . $event['image']) }}"
                     alt="{{ $event['title'] }}"
                     class="w-full h-[400px] object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy" />
            </div>
            <div class="p-6 space-y-3 text-white">
                <h3 class="text-2xl font-bellefair text-white">{{ $event['title'] }}</h3>
                <p class="text-sm font-light text-gray-400">{{ $event['date'] }}</p>
                <p class="text-[15px] font-poppins leading-relaxed">{{ $event['desc'] }}</p>
                <a href="{{ route('client.exhibition') }}"
                   class="inline-block mt-4 text-sm text-white font-medium hover:underline transition">
                   Book tickets →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Exhibitions and Featured Events -->
<section class="mt-24 px-4 md:px-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Exhibitions and Featured Events</h2>
            <div class="mt-2 h-1 w-28 bg-white"></div>
        </div>
        <a href="{{ route('client.exhibition') }}">
            <button
                class="px-6 py-3 rounded-full border border-white text-white hover:bg-white hover:text-black transition font-semibold">
                See all
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach ([
            [
                'image' => 'HoPhap.jpg',
                'title' => 'Hiroshige',
                'subtitle' => 'The Artist of Journey',
                'date' => '1 May – 7 September 2025',
                'button_color' => 'bg-gray-300 text-black'
            ],
            [
                'image' => 'PhatBaQuanAm.jpg',
                'title' => 'Ancient India',
                'subtitle' => 'A Timeless Tradition',
                'date' => '22 May – 19 October 2025',
                'button_color' => 'bg-white text-black'
            ]
        ] as $item)
        <div class="flex bg-[#1a1a1a] overflow-hidden border border-gray-700">
            <div class="w-1/2 p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-white">{{ $item['title'] }}</h3>
                    <p class="text-lg text-white mb-4">{{ $item['subtitle'] }}</p>
                    <p class="text-sm text-gray-400 mb-2">Exhibition</p>
                    <p class="text-sm text-white">{{ $item['date'] }}</p>
                </div>
                <a href="{{ route('client.exhibition') }}"
                   class="inline-block mt-4 text-sm text-white font-medium hover:underline transition">
                   Book tickets →
                </a>
            </div>
            <div class="w-1/2 h-[400px]">
                <img src="{{ asset('storage/images/' . $item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover" loading="lazy" />
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Featured Articles -->
<section class="mt-24 px-4 md:px-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Featured Articles</h2>
            <div class="mt-2 h-1 w-28 bg-white"></div>
        </div>
        <a href="{{ route('client.post') }}">
            <button
                class="px-6 py-3 rounded-full border border-white text-white hover:bg-white hover:text-black transition font-semibold">
                See all
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'HoPhap.jpg', 'title' => 'Sacredness in Everyday Life', 'date' => '', 'desc' => 'The Dharma Protectors – vigilance, and justice in Buddhist tradition, embodying the sacred duty of safeguarding faith and guiding devotees towards righteousness.'],
            ['image' => 'PhatBaQuanAm.jpg', 'title' => 'Goddess of Mercy & Vietnamese Culture', 'date' => '', 'desc' => 'Learn about the worship of the Mother Goddess in both ancient and modern Vietnamese culture.'],
            ['image' => 'LinhVat.jpg', 'title' => 'Spiritual Creatures and Belief', 'date' => '', 'desc' => 'Sacred animals such as dragons, unicorns, turtles, and phoenixes are deeply woven into daily life and folk beliefs and spiritual connection in Vietnamese culture.'],
        ] as $post)
        <div class="bg-[#1c1c1c] shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group border border-gray-800">
            <div class="overflow-hidden">
                <img src="{{ asset('storage/images/' . $post['image']) }}"
                     alt="{{ $post['title'] }}"
                     class="w-full h-[400px] object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy" />
            </div>
            <div class="p-6 space-y-3 text-white">
                <h3 class="text-2xl font-bellefair text-white">{{ $post['title'] }}</h3>
                <p class="text-sm font-light text-gray-400">{{ $post['date'] }}</p>
                <p class="text-[15px] font-poppins leading-relaxed">{{ $post['desc'] }}</p>
                <a href="{{ route('client.post') }}"
                   class="inline-block mt-4 text-sm text-white font-medium hover:underline transition">
                    Read more →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

<div class="space-y-3 border-t pt-6 border-bg-black"></div>
<!-- Featured Collection (Carousel Section) -->
<section class="relative bg-[#1c1c1c] from-[#1c1c1c] via-[#2F2F2F] to-[#1c1c1c] py-10 px-4 md:px-12 lg:px-24 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12 text-center">
            <h2 class="text-4xl md:text-5xl font-bellefair text-white mb-2">Featured Collection</h2>
            <p class="text-gray-400 font-light text-lg">A journey through the museum's most iconic masterpieces</p>
        </div>

        <!-- Swiper Container -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ([
                    ['image' => 'OngToBaNguyet.jpg', 'caption' => 'Matchmakers of Fate – Symbols of Love and Marriage'],
                    ['image' => 'OngThienAc.jpg', 'caption' => 'Good and Evil Deities – Guardians of Morality and Justice'],
                    ['image' => 'LinhVat.jpg', 'caption' => 'Sacred Creature – Spiritual Power'],
                    ['image' => 'HoangHau.jpg', 'caption' => 'Princess My Chau – A Tragic Symbol of Love and Betrayal']
                ] as $slide)
                <div class="swiper-slide group bg-[#1a1a1a] overflow-hidden shadow-lg border border-gray-700">
                    <div class="overflow-hidden">
                        <img src="{{ asset('storage/images/' . $slide['image']) }}" alt="{{ $slide['caption'] }}"
                             class="w-full h-[1000px] object-cover transition-transform duration-500 group-hover:scale-105"
                             loading="lazy" />
                    </div>
                    <div class="p-4 text-white font-poppins text-center">
                        <p class="text-lg font-bellefair text-white">{{ $slide['caption'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-center gap-4 mt-6">
                <div class="swiper-button-prev text-white !static"></div>
                <div class="swiper-button-next text-white !static"></div>
            </div>
        </div>
    </div>
</section>

<!-- Collection -->
<section class="mt-24 px-4 md:px-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Collection</h2>
            <div class="mt-2 h-1 w-28 bg-white"></div>
        </div>
        <a href="{{ route('client.collection') }}">
            <button
                class="px-6 py-3 rounded-full border border-white text-white hover:bg-white hover:text-black transition font-semibold">
                See all
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'PhatBaQuanAm.jpg', 'title' => 'Goddess of Mercy', 'desc' => 'The Goddess of Mercy, known as Phật Bà Quan Âm in Vietnamese culture, embodies infinite and protection'],
            ['image' => 'TuPhap.jpg', 'title' => 'Four Goddesses', 'desc' => 'Four female deities representing rain, thunder, lightning, and clouds – the origins of agriculture.'],
            ['image' => 'ThanhGiong.jpg', 'title' => 'Saint Gióng', 'desc' => 'The image of a village hero who rose up to fight invaders and defend the country.'],
        ] as $item)
        <div class="bg-[#1c1c1c] shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group border border-gray-800">
            <div class="overflow-hidden">
                <img src="{{ asset('storage/images/' . $item['image']) }}"
                     alt="{{ $item['title'] }}"
                     class="w-full h-[400px] object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy" />
            </div>
            <div class="p-6 space-y-3 text-white">
                <h3 class="text-2xl font-bellefair text-white">{{ $item['title'] }}</h3>
                <p class="text-[15px] font-poppins leading-relaxed">{{ $item['desc'] }}</p>
                <a href="{{ route('client.collection') }}"
                   class="inline-block mt-4 text-sm text-white font-medium hover:underline transition">
                    View details →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
