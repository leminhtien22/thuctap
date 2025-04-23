@extends('layouts.app')

@section('title')
    {{ __('Bảo Tàng Tượng Dân Gian Việt Nam') }}
@endsection

@section('content')


   <!-- Giới thiệu bảo tàng nâng cấp -->
<section class="relative bg-gradient-to-b from-[#1c1c1c] via-[#2F2F2F] to-[#1c1c1c] py-20 px-4 md:px-12 lg:px-24 overflow-hidden">
    <div class="max-w-7xl mx-auto text-white">
        <!-- Tiêu đề -->
        <h1 class="text-4xl md:text-6xl font-bellefair text-center mb-16 text-[#f7c873] animate-fade-up duration-1000">
        {{ __('WELCOM TO THE FOLK MUSEUM') }}</h1>

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
                    
                <p class="rounded-full text-[#f7c873] transition font-semibold">
        Welcome to the Folk Museum - the soul and cultural identity of the nation for centuries! Here, you will be immersed in the vivid space of traditional values, where each artifact, each story recounts the journey of history and daily life of Vietnamese people through periods.
      </p>
      <p class="rounded-full text-[#f7c873] transition font-semibold">
        From the ancient wooden houses with mossy tile roofs, rudimentary but creative labor tools, to the colorful traditional costumes and unique customs - all are re-enacted in a sophisticated and authentic manner.
      </p>
      <p class="rounded-full text-[#f7c873] transition font-semibold">
        The museum is not only a place to display artifacts but also a bridge between the past and the present, helping you to better understand the origin of the culture, customs and solidarity of the community.
      </p>
      <p class="rounded-full text-[#f7c873] transition font-semibold">
        In addition, you also have the opportunity to participate in interactive activities such as handicraft experience, enjoying folk songs or learning about traditional rituals.
      </p>
      <p class="rounded-full text-[#f7c873] transition font-semibold">
        We hope that the tour at the Folk Museum will bring you meaningful moments, unforgettable memories and a deeper look at the rich cultural heritage of the Vietnamese people.
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
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Art Exhibition of the Week</h2>
            <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
        </div>
        <a href="{{ route('client.exhibition') }}">
            <button
                class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
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
                   Book tickets →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>





<section class="mt-24 px-4 md:px-12">
  <div class="flex justify-between items-center mb-10">
    <div>
      <h2 class="text-4xl md:text-5xl font-bellefair text-white">Exhibitions and Featured Events</h2>
      <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
    </div>
    <a href="{{ route('client.exhibition') }}">
      <button
        class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
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
        'button_color' => 'bg-yellow-400 text-black'
      ]
    ] as $item)
    <div class="flex bg-[#1a1a1a] rounded-xl overflow-hidden border border-gray-700">
      <div class="w-1/2 p-6 flex flex-col justify-between">
        <div>
          <h3 class="text-2xl font-semibold text-white">{{ $item['title'] }}</h3>
          <p class="text-lg text-[#f7c873] mb-4">{{ $item['subtitle'] }}</p>
          <p class="text-sm text-gray-400 mb-2">Exhibition</p>
          <p class="text-sm text-white">{{ $item['date'] }}</p>
        </div>
        <a href="{{ route('client.exhibition') }}"
           class="inline-block mt-4 text-sm text-[#f7c873] font-medium hover:underline hover:text-white transition">
           Book tickets →
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
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Featured Articles</h2>
            <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
        </div>
        <a href="{{ route('client.post') }}">
            <button
                class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
                See all
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'HoPhap.jpg', 'title' => 'Sacredness in Everyday Life', 'date' => '', 'desc' => 'Explore the space of folk beliefs through meticulously preserved statues.'],
            ['image' => 'PhatBaQuanAm.jpg', 'title' => 'Goddess of Mercy & Vietnamese Culture', 'date' => '', 'desc' => 'Learn about the worship of the Mother Goddess in both ancient and modern Vietnamese culture.'],
            ['image' => 'LinhVat.jpg', 'title' => 'Spiritual Creatures and Belief', 'date' => '', 'desc' => 'The presence of sacred animals in daily life and folk spirituality.'],
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
                    Read more →
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
            <h2 class="text-4xl md:text-5xl font-bellefair text-[#f7c873] mb-2">Featured Collection</h2>
            <p class="text-gray-400 font-light text-lg">A journey through the museum's most iconic masterpieces</p>
        </div>

        <!-- Swiper Container -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ([
                    ['image' => 'HoPhap.jpg', 'caption' => 'Guardian Deity – Symbol of Protection'],
                    ['image' => 'PhatBaQuanAm.jpg', 'caption' => 'Goddess of Mercy – Compassion and Shelter'],
                    ['image' => 'LinhVat.jpg', 'caption' => 'Sacred Creature – Spiritual Power'],
                    ['image' => 'AnDuongVuongXoaNen.png', 'caption' => 'King An Dương – Legend of Nation Building']
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
            <h2 class="text-4xl md:text-5xl font-bellefair text-white">Collection</h2>
            <div class="mt-2 h-1 w-28 bg-[#f7c873]"></div>
        </div>
        <a href="{{ route('client.collection') }}">
            <button
                class="px-6 py-3 rounded-full border border-[#f7c873] text-[#f7c873] hover:bg-[#f7c873] hover:text-black transition font-semibold">
                See all
            </button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ([
            ['image' => 'PhatBaQuanAm.jpg', 'title' => 'Goddess of Mercy', 'desc' => 'A symbol of compassion and protection in folk beliefs.'],
            ['image' => 'TuPhap.jpg', 'title' => 'Four Goddesses', 'desc' => 'Four female deities representing rain, thunder, lightning, and clouds – the origins of agriculture.'],
            ['image' => 'ThanhGiong.jpg', 'title' => 'Saint Gióng', 'desc' => 'The image of a village hero who rose up to fight invaders and defend the country.'],
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
                    View details →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
