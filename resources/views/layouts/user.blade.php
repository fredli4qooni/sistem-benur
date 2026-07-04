<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SENTRA BENUR | Platform Pemesanan Benur</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 pb-28 md:pb-0 selection:bg-[#1A6B3C] selection:text-white">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <a href="{{ Auth::check() ? route('profile.edit') : url('/#katalog') }}" class="flex items-center space-x-2">
                <i class="ph-fill ph-shrimp text-2xl text-[#1A6B3C]"></i>
                <span class="text-xl font-extrabold text-gray-900 tracking-tight">SENTRA BENUR</span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('user.catalog') }}" class="flex items-center space-x-1.5 transition-colors {{ request()->routeIs('user.catalog') || request()->routeIs('user.checkout*') ? 'text-[#1A6B3C] font-semibold' : 'text-gray-500 hover:text-gray-900' }}">
                    <i class="{{ request()->routeIs('user.catalog') || request()->routeIs('user.checkout*') ? 'ph-fill' : 'ph' }} ph-storefront text-lg"></i>
                    <span>Katalog Benur</span>
                </a>
                <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-1.5 transition-colors {{ request()->routeIs('user.dashboard') ? 'text-[#1A6B3C] font-semibold' : 'text-gray-500 hover:text-gray-900' }}">
                    <i class="{{ request()->routeIs('user.dashboard') ? 'ph-fill' : 'ph' }} ph-trend-up text-lg"></i>
                    <span>Tren Harga</span>
                </a>
                <a href="{{ route('user.orders.index') }}" class="flex items-center space-x-1.5 transition-colors {{ request()->routeIs('user.orders.*') ? 'text-[#1A6B3C] font-semibold' : 'text-gray-500 hover:text-gray-900' }}">
                    <i class="{{ request()->routeIs('user.orders.*') ? 'ph-fill' : 'ph' }} ph-receipt text-lg"></i>
                    <span>Pesanan Saya</span>
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('profile.edit') }}" class="hidden md:flex items-center space-x-2 border-r border-gray-200 pr-4 hover:bg-gray-50 px-2 py-1 rounded-lg transition-colors group">
                    <div class="w-8 h-8 rounded-full bg-green-50 text-[#1A6B3C] group-hover:bg-green-100 flex items-center justify-center font-bold text-sm border border-green-100">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-700 leading-tight group-hover:text-gray-900">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-gray-400 font-medium uppercase">Pelanggan</span>
                    </div>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600 hover:bg-red-50 border border-gray-200 hover:border-red-100 rounded-lg px-3 py-1.5 transition-all flex items-center space-x-1.5" title="Keluar">
                        <i class="ph ph-sign-out text-lg"></i>
                        <span class="text-xs font-semibold">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around items-center h-16 z-50">
        <a href="{{ route('user.catalog') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->routeIs('user.catalog') || request()->routeIs('user.checkout*') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('user.catalog') || request()->routeIs('user.checkout*') ? 'ph-fill' : 'ph' }} ph-storefront text-2xl"></i>
            <span class="text-[10px] font-semibold">Katalog</span>
        </a>
        
        <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->routeIs('user.dashboard') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('user.dashboard') ? 'ph-fill' : 'ph' }} ph-trend-up text-2xl"></i>
            <span class="text-[10px] font-semibold">Tren Harga</span>
        </a>
        
        <a href="{{ route('user.orders.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->routeIs('user.orders.*') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('user.orders.*') ? 'ph-fill' : 'ph' }} ph-receipt text-2xl"></i>
            <span class="text-[10px] font-semibold">Pesanan</span>
        </a>

        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->routeIs('profile.*') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('profile.*') ? 'ph-fill' : 'ph' }} ph-user text-2xl"></i>
            <span class="text-[10px] font-semibold">Profil</span>
        </a>
    </div>

    @stack('scripts')
</body>
</html>
