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

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex transition-all duration-300">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <i class="ph-fill ph-shrimp text-2xl text-[#1A6B3C] mr-2"></i>
            <span class="text-xl font-extrabold text-gray-900 tracking-tight">BENUR-Q <span class="text-[#1A6B3C] text-sm">PRO</span></span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-4">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="ph {{ request()->routeIs('admin.dashboard') ? 'ph-squares-four-fill' : 'ph-squares-four' }} text-xl mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Dashboard
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Manajemen Operasional</p>

            <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.products.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="ph {{ request()->routeIs('admin.products.*') ? 'ph-package-fill' : 'ph-package' }} text-xl mr-3 {{ request()->routeIs('admin.products.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Katalog Benur
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.orders.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="ph {{ request()->routeIs('admin.orders.*') ? 'ph-shopping-cart-fill' : 'ph-shopping-cart' }} text-xl mr-3 {{ request()->routeIs('admin.orders.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Pesanan Masuk
                <span class="ml-auto bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px] font-bold">Baru</span>
            </a>

            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.customers.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="ph {{ request()->routeIs('admin.customers.*') ? 'ph-users-fill' : 'ph-users' }} text-xl mr-3 {{ request()->routeIs('admin.customers.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Data Pelanggan
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Analitik & Sistem</p>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.reports.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="ph {{ request()->routeIs('admin.reports.*') ? 'ph-chart-line-up-fill' : 'ph-chart-line-up' }} text-xl mr-3 {{ request()->routeIs('admin.reports.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                Laporan Penjualan
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.settings.*') ? 'bg-green-50 text-[#1A6B3C] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="ph {{ request()->routeIs('admin.settings.*') ? 'ph-gear-fill' : 'ph-gear' }} text-xl mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-[#1A6B3C]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
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
                <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none p-2 -ml-2 rounded-lg hover:bg-gray-100 mr-2">
                    <i class="ph ph-list text-2xl"></i>
                </button>

                <div class="hidden sm:flex items-center text-sm text-gray-500">
                    <i class="ph ph-house mr-2"></i>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900 font-medium capitalize">{{ str_replace('admin.', '', request()->route()->getName() ?? 'Dashboard') }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button class="text-gray-400 hover:text-gray-600 transition relative">
                    <i class="ph ph-bell text-xl"></i>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>