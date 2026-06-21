@extends('layouts.admin')

@section('content')
<div class="mb-6 hidden md:block">
    <div class="bg-blue-50 text-blue-700 p-4 rounded-lg flex items-center shadow-sm border border-blue-100">
        <i class="ph-fill ph-info text-2xl mr-3"></i>
        <div>
            <p class="font-bold text-sm">Informasi Akses</p>
            <p class="text-xs mt-0.5">Halaman Menu khusus ini dirancang untuk tampilan Mobile. Di layar Desktop, Anda dapat menggunakan navigasi utama di Sidebar kiri.</p>
        </div>
    </div>
</div>

<div class="max-w-lg mx-auto pb-4">
    <!-- Profil Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 flex items-center space-x-4">
        <div class="w-16 h-16 rounded-full bg-green-50 text-[#1A6B3C] border border-green-100 flex items-center justify-center font-bold text-2xl">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-bold text-gray-900 leading-tight line-clamp-1">{{ Auth::user()->name }}</h2>
            <p class="text-gray-500 text-sm mb-1.5">{{ Auth::user()->email }}</p>
            <span class="inline-block px-2.5 py-0.5 bg-[#1A6B3C] text-white text-[10px] font-bold rounded-md uppercase tracking-wider">
                {{ Auth::user()->role }}
            </span>
        </div>
    </div>

    <!-- Menu Section: Analitik & Sistem -->
    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-2">Analitik & Pengaturan</h3>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6 divide-y divide-gray-50">
        <a href="{{ route('admin.reports.index') }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition active:bg-gray-100">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="ph-fill ph-chart-line-up text-xl"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">Laporan Penjualan</p>
                    <p class="text-xs text-gray-500 mt-0.5">Rekap dan ekspor data transaksi</p>
                </div>
            </div>
            <i class="ph ph-caret-right text-gray-400"></i>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition active:bg-gray-100">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i class="ph-fill ph-buildings text-xl"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">Pengaturan Perusahaan</p>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola info kontak & rekening</p>
                </div>
            </div>
            <i class="ph ph-caret-right text-gray-400"></i>
        </a>

        <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition active:bg-gray-100">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                    <i class="ph-fill ph-user-circle text-xl"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">Pengaturan Akun</p>
                    <p class="text-xs text-gray-500 mt-0.5">Ubah profil diri & kata sandi</p>
                </div>
            </div>
            <i class="ph ph-caret-right text-gray-400"></i>
        </a>
    </div>

    <!-- Keluar Section -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full bg-white border border-red-200 rounded-2xl shadow-sm p-4 flex items-center justify-center space-x-2 text-red-600 font-bold hover:bg-red-50 transition active:bg-red-100">
            <i class="ph ph-sign-out text-xl"></i>
            <span>Keluar dari Aplikasi</span>
        </button>
    </form>
    
    <div class="text-center mt-8">
        <p class="text-xs text-gray-400">Benur-Q v1.0.0</p>
    </div>
</div>
@endsection
