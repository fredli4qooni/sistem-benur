<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SENTRA BENUR | Platform Distribusi Benur Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Custom Scroll Reveal CSS -->
    <style>
        [data-aos] {
            opacity: 0;
            transition-property: opacity, transform;
            transition-duration: 800ms;
            transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
        }
        [data-aos].aos-animate {
            opacity: 1;
            transform: translate(0) scale(1);
        }
        [data-aos="fade-up"]:not(.aos-animate) { transform: translateY(40px); }
        [data-aos="fade-down"]:not(.aos-animate) { transform: translateY(-40px); }
        [data-aos="fade-left"]:not(.aos-animate) { transform: translateX(40px); }
        [data-aos="fade-right"]:not(.aos-animate) { transform: translateX(-40px); }
        [data-aos="zoom-in"]:not(.aos-animate) { transform: scale(0.9); }

        /* Aquarium Bubbles Animation */
        .bubbles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Di bawah konten utama (z-10) */
            pointer-events: none;
            overflow: hidden;
        }
        .bubble {
            position: absolute;
            bottom: -80px;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Efek 3D Gelembung */
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.6), rgba(26, 107, 60, 0.05) 50%, rgba(26, 107, 60, 0.2) 100%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            box-shadow: inset -5px -5px 15px rgba(26, 107, 60, 0.1), 
                        inset 5px 5px 10px rgba(255, 255, 255, 0.6), 
                        0 4px 10px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(2px);
            animation: rise linear infinite, sway ease-in-out infinite alternate;
        }
        .bubble i {
            color: rgba(26, 107, 60, 0.5); /* Warna hijau udang transparan */
            filter: drop-shadow(0 2px 2px rgba(255,255,255,0.8));
        }
        /* Ukuran Gelembung */
        .bubble-sm { width: 35px; height: 35px; font-size: 16px; }
        .bubble-md { width: 55px; height: 55px; font-size: 26px; }
        .bubble-lg { width: 75px; height: 75px; font-size: 38px; }
        
        @keyframes rise {
            0% { bottom: -80px; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { bottom: 110%; opacity: 0; }
        }
        @keyframes sway {
            0% { transform: translateX(0); }
            100% { transform: translateX(30px); }
        }
    </style>
</head>

<body class="antialiased bg-white text-gray-900 font-sans selection:bg-[#1A6B3C] selection:text-white">

    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 fixed w-full z-50 top-0 transition-all" data-aos="fade-down" data-aos-duration="600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center space-x-2">
                    <i class="ph-fill ph-shrimp text-2xl text-[#1A6B3C]"></i>
                    <span class="text-xl font-extrabold text-gray-900 tracking-tight">SENTRA BENUR</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                    @auth
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-[#1A6B3C] flex items-center transition">
                        <i class="ph ph-squares-four mr-1.5 text-lg"></i> Dashboard Admin
                    </a>
                    @else
                    <a href="{{ route('user.catalog') }}" class="text-sm font-bold text-gray-600 hover:text-[#1A6B3C] flex items-center transition">
                        <i class="ph ph-storefront mr-1.5 text-lg"></i> Katalog Saya
                    </a>
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-[#1A6B3C] transition">Masuk</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-[#1A6B3C] rounded-lg hover:bg-[#2E8B57] transition-colors shadow-sm">Daftar</a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 overflow-hidden border-b border-gray-200 bg-gray-100" style="background-image: url('{{ asset('images/bg-hero.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay to ensure text readability -->
        <div class="absolute inset-0 bg-white/85 backdrop-blur-[1px]"></div>

        <!-- Aquarium Bubbles Effect -->
        <div class="bubbles-container">
            <div class="bubble bubble-sm" style="left: 10%; animation-duration: 8s, 3s; animation-delay: 0s, 0s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-lg" style="left: 20%; animation-duration: 11s, 4s; animation-delay: 1s, 1s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-sm" style="left: 35%; animation-duration: 6s, 2s; animation-delay: 2s, 0.5s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-md" style="left: 50%; animation-duration: 14s, 5s; animation-delay: 0s, 2s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-lg" style="left: 65%; animation-duration: 9s, 3.5s; animation-delay: 3s, 1.5s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-sm" style="left: 80%; animation-duration: 7s, 3s; animation-delay: 1.5s, 0s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-md" style="left: 90%; animation-duration: 10s, 4s; animation-delay: 4s, 2s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-sm" style="left: 5%; animation-duration: 5s, 2.5s; animation-delay: 3s, 1s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-md" style="left: 45%; animation-duration: 12s, 4.5s; animation-delay: 5s, 0.5s;"><i class="ph-fill ph-shrimp"></i></div>
            <div class="bubble bubble-lg" style="left: 75%; animation-duration: 8.5s, 3.2s; animation-delay: 2.5s, 1.2s;"><i class="ph-fill ph-shrimp"></i></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center relative z-10">
            <div class="lg:w-1/2 text-center lg:text-left pr-0 lg:pr-12" data-aos="fade-right" data-aos-delay="200">
                <span class="inline-flex items-center py-1 px-3 rounded-full bg-white border border-green-200 text-green-700 text-xs font-bold tracking-wide mb-6 shadow-sm">
                    <i class="ph-fill ph-rocket-launch mr-1.5"></i> B2B & B2C PLATFORM
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight">
                    Solusi Cerdas Kebutuhan <span class="text-[#1A6B3C]">Benur Tambak</span> Anda
                </h1>
                <p class="text-lg text-gray-500 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                    Tinggalkan cara manual! Pesan benih udang dan ikan air payau berkualitas secara online. Pantau tren harga pasar, jadwalkan pengiriman, dan bayar dengan mudah.
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-3 sm:space-y-0 sm:space-x-4">
                    @auth
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.catalog') }}" class="px-8 py-3.5 text-base font-bold text-white bg-[#1A6B3C] rounded-lg hover:bg-[#2E8B57] transition-colors shadow-sm flex items-center justify-center">
                        Mulai Belanja <i class="ph ph-arrow-right ml-2"></i>
                    </a>
                    @else
                    <a href="#katalog" class="px-8 py-3.5 text-base font-bold text-white bg-[#1A6B3C] rounded-lg hover:bg-[#2E8B57] transition-colors shadow-sm text-center flex items-center justify-center">
                        Lihat Katalog <i class="ph ph-arrow-down ml-2"></i>
                    </a>
                    <a href="{{ route('register') }}" class="px-8 py-3.5 text-base font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm text-center">
                        Daftar Gratis
                    </a>
                    @endauth
                </div>
            </div>

            <div class="lg:w-1/2 mt-16 lg:mt-0 hidden md:block relative z-20" data-aos="fade-left" data-aos-delay="400">
                <div class="relative w-full max-w-lg mx-auto">
                    <!-- Ornamen Dekoratif di Belakang Slider -->
                    <div class="absolute -inset-4 bg-gradient-to-tr from-[#1A6B3C]/20 to-emerald-400/20 rounded-3xl transform rotate-3 blur-sm"></div>
                    <div class="absolute -inset-4 bg-gray-200/50 rounded-3xl transform -rotate-3 transition-transform hover:rotate-0 duration-500"></div>
                    
                    <!-- Swiper Container -->
                    <div class="swiper heroSwiper relative bg-white border border-gray-200 shadow-2xl rounded-3xl overflow-hidden h-[400px]">
                        <div class="swiper-wrapper">
                            @forelse($featuredProducts as $product)
                            <div class="swiper-slide relative h-full bg-gray-100 group">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $product->name }}">
                                @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                                    <i class="ph ph-image text-6xl mb-3 text-gray-300"></i>
                                </div>
                                @endif
                                
                                <!-- Overlay Text -->
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent flex flex-col justify-end p-8 sm:p-10 text-left z-10">
                                    <span class="inline-block self-start px-3 py-1.5 bg-[#1A6B3C] text-white text-[11px] font-black rounded-md mb-3 uppercase tracking-widest shadow-lg">{{ $product->category ?? 'Produk Unggulan' }}</span>
                                    <h3 class="text-white text-3xl sm:text-4xl font-extrabold line-clamp-2 leading-tight drop-shadow-xl">{{ $product->name }}</h3>
                                    <p class="text-emerald-400 font-extrabold text-2xl sm:text-3xl mt-3 drop-shadow-xl">Rp {{ number_format($product->price, 0, ',', '.') }} <span class="text-base sm:text-lg text-gray-300 font-medium">/ {{ $product->unit }}</span></p>
                                </div>
                            </div>
                            @empty
                            <div class="swiper-slide relative bg-white flex flex-col items-center justify-center h-full p-8">
                                <div class="w-24 h-24 bg-green-50 border border-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="ph-fill ph-shrimp text-5xl text-[#1A6B3C]"></i>
                                </div>
                                <h3 class="text-2xl font-extrabold text-gray-900 text-center">Benur Kualitas Premium</h3>
                                <p class="text-gray-500 mt-2 text-center font-medium">Bebas penyakit, pertumbuhan cepat, dan siap tebar ke tambak Anda.</p>
                            </div>
                            @endforelse
                        </div>
                        
                        <!-- Add Pagination -->
                        <div class="swiper-pagination mb-2" style="--swiper-theme-color: #fff; --swiper-pagination-bullet-inactive-color: #aaa; --swiper-pagination-bullet-size: 10px;"></div>
                        <!-- Add Navigation -->
                        <div class="swiper-button-next !text-white after:!text-sm w-12 h-12 bg-black/40 hover:bg-[#1A6B3C] rounded-full backdrop-blur-md transition-all right-4 border border-white/20"></div>
                        <div class="swiper-button-prev !text-white after:!text-sm w-12 h-12 bg-black/40 hover:bg-[#1A6B3C] rounded-full backdrop-blur-md transition-all left-4 border border-white/20"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Keunggulan Ekosistem Kami</h2>
                <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto font-medium">Dirancang khusus untuk memudahkan operasional pembudidaya dari pemesanan hingga barang tiba di lokasi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl border border-gray-200 hover:border-[#1A6B3C] hover:shadow-md transition-all duration-300 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 group-hover:bg-green-50 group-hover:text-[#1A6B3C] group-hover:border-green-100 transition-colors mb-6">
                        <i class="ph ph-chart-line-up text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tren Harga Real-time</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Pantau grafik pergerakan harga pasar benur secara transparan langsung dari dashboard Anda sebelum memutuskan untuk membeli.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100 transition-colors mb-6">
                        <i class="ph ph-calendar-check text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Jadwal Kirim Terstruktur</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Sistem pengiriman terjadwal (Senin & Kamis) memastikan proses aklimatisasi benur terencana dengan baik saat tiba di tambak.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-gray-200 hover:border-orange-500 hover:shadow-md transition-all duration-300 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 group-hover:bg-orange-50 group-hover:text-orange-500 group-hover:border-orange-100 transition-colors mb-6">
                        <i class="ph ph-qr-code text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pembayaran Digital QRIS</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Proses checkout yang cepat dan transparan dengan dukungan pembayaran QRIS serta konfirmasi transfer bank otomatis.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="katalog" class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12" data-aos="fade-up">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Katalog Unggulan Kami</h2>
                    <p class="mt-2 text-gray-500 font-medium">Pilihan benur terbaik dengan harga pasar update hari ini.</p>
                </div>
                <div class="mt-4 md:mt-0 hidden sm:block">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-[#1A6B3C] hover:text-[#2E8B57] flex items-center transition-colors bg-white border border-gray-200 px-4 py-2 rounded-lg hover:shadow-sm">
                        Masuk untuk lihat semua <i class="ph ph-arrow-right ml-1.5"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200 flex flex-col overflow-hidden group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">

                    <div class="relative h-48 bg-gray-50 border-b border-gray-100 flex-shrink-0 overflow-hidden">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $product->name }}">
                        @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <i class="ph ph-image text-4xl mb-2 text-gray-300"></i>
                        </div>
                        @endif
                        @if($product->category)
                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-bold px-2.5 py-1 rounded-md shadow-sm border border-gray-200 uppercase tracking-wider">
                            {{ $product->category }}
                        </span>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-base font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-[#1A6B3C] transition-colors mb-4">{{ $product->name }}</h3>

                        <div class="mt-auto">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Harga per {{ $product->unit }}</p>
                            <p class="text-xl font-extrabold text-[#1A6B3C] tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <div class="mt-5">
                            @auth
                            @if($product->stock > 0)
                            <a href="{{ route('user.checkout', $product->id) }}" class="w-full flex items-center justify-center bg-white border-2 border-[#1A6B3C] text-[#1A6B3C] font-bold py-2 rounded-lg hover:bg-[#1A6B3C] hover:text-white transition-colors duration-200 text-sm">
                                Pesan Sekarang
                            </a>
                            @else
                            <button disabled class="w-full flex items-center justify-center bg-gray-50 border border-gray-200 text-gray-400 font-bold py-2 rounded-lg cursor-not-allowed text-sm">
                                Stok Habis
                            </button>
                            @endif
                            @else
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center bg-white border-2 border-gray-200 text-gray-600 font-bold py-2 rounded-lg hover:border-[#1A6B3C] hover:text-[#1A6B3C] transition-colors duration-200 text-sm">
                                <i class="ph ph-lock-key mr-2 text-lg"></i> Login untuk Pesan
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white border border-gray-200 rounded-xl p-12 text-center text-gray-500 text-sm flex flex-col items-center">
                    <i class="ph ph-package text-4xl text-gray-300 mb-3"></i>
                    Katalog sedang dalam proses update.
                </div>
                @endforelse
            </div>

            @guest
            <div class="mt-16 bg-[#1A6B3C] rounded-2xl p-8 sm:p-10 flex flex-col sm:flex-row items-center justify-between shadow-lg border border-green-800" data-aos="zoom-in">
                <div class="text-center sm:text-left mb-6 sm:mb-0">
                    <h3 class="text-2xl font-extrabold text-white tracking-tight">Siap Memulai Budidaya?</h3>
                    <p class="text-green-100 mt-2 text-sm max-w-md font-medium">Bergabunglah dengan ekosistem digital kami dan nikmati kemudahan transaksi benur yang transparan.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('register') }}" class="px-8 py-3.5 bg-white text-[#1A6B3C] font-extrabold rounded-lg shadow-sm hover:bg-gray-50 transition-colors inline-flex items-center">
                        Buat Akun Gratis <i class="ph-bold ph-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endguest

        </div>
    </div>

    <div class="py-16 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10" data-aos="fade-up">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Lokasi Kami</h2>
                    <p class="mt-2 text-gray-500 font-medium">Kunjungi pusat operasi dan pembenihan kami secara langsung.</p>
                </div>
            </div>

            <div class="relative w-full h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-xl border border-gray-200 bg-gray-50 group" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute inset-0 pointer-events-none z-10 shadow-[inset_0_0_20px_rgba(0,0,0,0.05)] rounded-3xl"></div>
                
                <!-- Iframe Google Maps -->
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126442.2709669527!2d110.58434676100109!3d-6.592534571991871!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e711efa10fcd379%3A0xc3c582531cd869b2!2sJepara%2C%20Kabupaten%20Jepara%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                    class="w-full h-full border-0 filter contrast-100 group-hover:contrast-125 transition-all duration-500" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                
                <!-- Info Card Floating di Atas Map -->
                <div class="absolute bottom-6 md:bottom-8 left-1/2 transform -translate-x-1/2 md:left-8 md:translate-x-0 bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-gray-100 w-[90%] md:w-[380px] z-20">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-green-50 border border-green-100 rounded-xl flex items-center justify-center">
                            <i class="ph-fill ph-buildings text-2xl text-[#1A6B3C]"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Kunjungi Fasilitas Kami</h3>
                            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Sentra Akuakultur</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4 pt-4 border-t border-gray-100">
                        <div class="flex items-start">
                            <div class="mt-0.5 bg-gray-50 p-1.5 rounded text-gray-400 mr-3 border border-gray-100">
                                <i class="ph-fill ph-map-pin text-[#1A6B3C]"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 leading-snug">Jl. Pesisir Tambak Udang No. 88, Kawasan Industri Akuakultur, Jawa Tengah</span>
                        </div>
                        <div class="flex items-start">
                            <div class="mt-0.5 bg-gray-50 p-1.5 rounded text-gray-400 mr-3 border border-gray-100">
                                <i class="ph-fill ph-phone text-[#1A6B3C]"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">+62 812-3456-7890</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 flex items-center space-x-2">
                    <i class="ph-fill ph-shrimp text-2xl text-gray-400"></i>
                    <span class="text-lg font-extrabold text-gray-900 tracking-tight">SENTRA BENUR</span>
                </div>
                <div class="text-sm text-gray-500 font-medium text-center md:text-right">
                    <p>&copy; {{ date('Y') }} PT Sentra Benur Indonesia. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Swiper
            var swiper = new Swiper(".heroSwiper", {
                effect: "fade",
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                loop: true,
            });

            // Custom Intersection Observer (Animate on Both Directions)
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 // Memicu animasi saat 15% elemen terlihat
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const el = entry.target;
                    
                    // Terapkan delay jika ada
                    if (el.hasAttribute('data-aos-delay')) {
                        el.style.transitionDelay = el.getAttribute('data-aos-delay') + 'ms';
                    }

                    if (entry.isIntersecting) {
                        el.classList.add('aos-animate');
                    } else {
                        // Kunci utama: hilangkan class agar hilang kembali saat scroll ke luar
                        el.classList.remove('aos-animate');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('[data-aos]').forEach(el => observer.observe(el));

            // Force 100% Scale on Desktop/Laptop (Counteract Windows Display Scaling 125% / 150%)
            function forceNativeScale() {
                const isWindows = navigator.userAgent.toLowerCase().indexOf('windows') !== -1;
                if (isWindows && window.innerWidth >= 1024) {
                    const ratio = window.devicePixelRatio || 1;
                    // Jika layar user di-zoom oleh sistem (misal 150% = 1.5), kita set CSS zoom ke kebalikannya
                    document.body.style.zoom = 1 / ratio;
                } else {
                    document.body.style.zoom = 1;
                }
            }
            // Terapkan saat pertama kali dimuat dan saat layar di-resize (atau zoom diubah)
            forceNativeScale();
            window.addEventListener('resize', forceNativeScale);
        });
    </script>
</body>

</html>
