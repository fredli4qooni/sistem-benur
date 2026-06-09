<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Benur-Q | Platform Distribusi Benur Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="antialiased bg-white text-gray-900 font-sans selection:bg-[#1A6B3C] selection:text-white">

    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 fixed w-full z-50 top-0 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center space-x-2">
                    <i class="ph-fill ph-shrimp text-2xl text-[#1A6B3C]"></i>
                    <span class="text-xl font-extrabold text-gray-900 tracking-tight">BENUR-Q</span>
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

    <div class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 overflow-hidden bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center relative z-10">
            <div class="lg:w-1/2 text-center lg:text-left pr-0 lg:pr-12">
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

            <div class="lg:w-1/2 mt-16 lg:mt-0 hidden md:block">
                <div class="relative w-full max-w-lg mx-auto">
                    <div class="absolute -inset-4 bg-gray-200/50 rounded-3xl transform -rotate-3 transition-transform hover:rotate-0 duration-500"></div>
                    <div class="relative bg-white border border-gray-200 shadow-xl rounded-3xl overflow-hidden p-8 flex flex-col items-center justify-center h-96">
                        <div class="w-24 h-24 bg-green-50 border border-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ph-fill ph-shrimp text-5xl text-[#1A6B3C]"></i>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 text-center">Benur Kualitas Premium</h3>
                        <p class="text-gray-500 mt-2 text-center font-medium">Bebas penyakit, pertumbuhan cepat, dan siap tebar ke tambak Anda.</p>

                        <div class="mt-8 flex items-center space-x-2 text-xs font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-full border border-green-100">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span>Sistem Pengiriman Terjadwal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Keunggulan Ekosistem Kami</h2>
                <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto font-medium">Dirancang khusus untuk memudahkan operasional pembudidaya dari pemesanan hingga barang tiba di lokasi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl border border-gray-200 hover:border-[#1A6B3C] hover:shadow-md transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 group-hover:bg-green-50 group-hover:text-[#1A6B3C] group-hover:border-green-100 transition-colors mb-6">
                        <i class="ph ph-chart-line-up text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tren Harga Real-time</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Pantau grafik pergerakan harga pasar benur secara transparan langsung dari dashboard Anda sebelum memutuskan untuk membeli.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100 transition-colors mb-6">
                        <i class="ph ph-calendar-check text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Jadwal Kirim Terstruktur</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Sistem pengiriman terjadwal (Senin & Kamis) memastikan proses aklimatisasi benur terencana dengan baik saat tiba di tambak.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-gray-200 hover:border-orange-500 hover:shadow-md transition-all duration-300 group">
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
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
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
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200 flex flex-col overflow-hidden group">

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
            <div class="mt-16 bg-[#1A6B3C] rounded-2xl p-8 sm:p-10 flex flex-col sm:flex-row items-center justify-between shadow-lg border border-green-800">
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

    <footer class="bg-white border-t border-gray-200 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 flex items-center space-x-2">
                    <i class="ph-fill ph-shrimp text-2xl text-gray-400"></i>
                    <span class="text-lg font-extrabold text-gray-900 tracking-tight">BENUR-Q</span>
                </div>
                <div class="text-sm text-gray-500 font-medium text-center md:text-right">
                    <p>&copy; {{ date('Y') }} PT Benur Digital Indonesia. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>