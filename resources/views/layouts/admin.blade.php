<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="font-sans antialiased bg-gray-50 flex h-screen overflow-hidden selection:bg-[#1A6B3C] selection:text-white">

    <!-- Sidebar Desktop Only -->
    <aside id="admin-sidebar" class="hidden md:flex flex-col w-64 bg-white border-r border-gray-200 z-50 transition-transform duration-300 ease-in-out">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <i class="ph-fill ph-shrimp text-2xl text-[#1A6B3C] mr-2"></i>
            <span class="text-xl font-extrabold text-gray-900 tracking-tight">SENTRA BENUR <span class="text-[#1A6B3C] text-sm">PRO</span></span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-4">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="{{ request()->routeIs('admin.dashboard') ? 'ph-fill' : 'ph' }} ph-squares-four text-xl mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Dashboard
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Manajemen Operasional</p>

            <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.products.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="{{ request()->routeIs('admin.products.*') ? 'ph-fill' : 'ph' }} ph-package text-xl mr-3 {{ request()->routeIs('admin.products.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Katalog Benur
            </a>

            @php
                $lastSeen = session('admin_last_seen_orders');
                $newOrdersCount = \App\Models\Order::whereIn('status', ['pending', 'dikonfirmasi'])
                    ->when($lastSeen, function($query) use ($lastSeen) {
                        $query->where('created_at', '>', $lastSeen);
                    })
                    ->count();
            @endphp
            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.orders.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="{{ request()->routeIs('admin.orders.*') ? 'ph-fill' : 'ph' }} ph-shopping-cart text-xl mr-3 {{ request()->routeIs('admin.orders.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Pesanan Masuk
                @if($newOrdersCount > 0)
                <span class="ml-auto bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px] font-bold">{{ $newOrdersCount }} Baru</span>
                @endif
            </a>

            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.customers.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="{{ request()->routeIs('admin.customers.*') ? 'ph-fill' : 'ph' }} ph-users text-xl mr-3 {{ request()->routeIs('admin.customers.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Data Pelanggan
            </a>

            <a href="{{ route('admin.admins.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.admins.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="{{ request()->routeIs('admin.admins.*') ? 'ph-fill' : 'ph' }} ph-user-circle-gear text-xl mr-3 {{ request()->routeIs('admin.admins.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Data Admin
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Analitik & Sistem</p>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.reports.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="{{ request()->routeIs('admin.reports.*') ? 'ph-fill' : 'ph' }} ph-chart-line-up text-xl mr-3 {{ request()->routeIs('admin.reports.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Laporan Penjualan
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.settings.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="{{ request()->routeIs('admin.settings.*') ? 'ph-fill' : 'ph' }} ph-gear text-xl mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Pengaturan Profil
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            <div class="flex items-center px-3 py-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#1A6B3C] text-white flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors group">
                    <i class="ph ph-sign-out text-lg mr-2 text-red-500 group-hover:text-red-700"></i>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
            <div class="flex items-center">
                <!-- Branding untuk Mobile -->
                <div class="md:hidden flex items-center mr-4">
                    <i class="ph-fill ph-shrimp text-2xl text-[#1A6B3C] mr-2"></i>
                    <span class="text-lg font-extrabold text-gray-900 tracking-tight">SENTRA BENUR</span>
                </div>

                <div class="hidden sm:flex items-center text-sm text-gray-500">
                    <i class="ph ph-house mr-2"></i>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900 font-medium capitalize">{{ str_replace('admin.', '', request()->route()->getName() ?? 'Dashboard') }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                @php
                    $headerPendingOrders = \App\Models\Order::whereIn('status', ['pending', 'dikonfirmasi'])->count();
                @endphp
                <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-gray-600 transition relative" title="Pesanan Pending">
                    <i class="ph ph-bell text-xl"></i>
                    @if($headerPendingOrders > 0)
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    @endif
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 pb-28 md:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around items-center h-16 z-50 pb-safe">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('admin.dashboard') ? 'ph-fill' : 'ph' }} ph-squares-four text-2xl"></i>
            <span class="text-[10px] font-semibold">Home</span>
        </a>
        
        <a href="{{ route('admin.products.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->routeIs('admin.products.*') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('admin.products.*') ? 'ph-fill' : 'ph' }} ph-package text-2xl"></i>
            <span class="text-[10px] font-semibold">Benur</span>
        </a>
        
        <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors relative {{ request()->routeIs('admin.orders.*') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('admin.orders.*') ? 'ph-fill' : 'ph' }} ph-shopping-cart text-2xl"></i>
            <span class="text-[10px] font-semibold">Pesanan</span>
            @php
                $pendingOrders = \App\Models\Order::whereIn('status', ['pending', 'dikonfirmasi'])->count();
            @endphp
            @if($pendingOrders > 0)
                <span class="absolute top-1 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border border-white"></span>
            @endif
        </a>

        <a href="{{ route('admin.customers.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->routeIs('admin.customers.*') ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ request()->routeIs('admin.customers.*') ? 'ph-fill' : 'ph' }} ph-users text-2xl"></i>
            <span class="text-[10px] font-semibold">Pelanggan</span>
        </a>

        @php
            $isMenuActive = request()->routeIs('admin.menu') || request()->routeIs('profile.*') || request()->routeIs('admin.settings.*') || request()->routeIs('admin.reports.*');
        @endphp
        <a href="{{ route('admin.menu') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ $isMenuActive ? 'text-[#1A6B3C]' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="{{ $isMenuActive ? 'ph-fill' : 'ph' }} ph-list text-2xl"></i>
            <span class="text-[10px] font-semibold">Menu</span>
        </a>
    </div>
</body>

</html>
