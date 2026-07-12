@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Admin</h1>
        <p class="text-gray-600 text-sm mt-1">Daftarkan akun administrator baru ke dalam sistem.</p>
    </div>
    <a href="{{ route('admin.admins.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 hover:bg-gray-50 px-4 py-2 rounded-lg transition-colors">
        <i class="ph ph-arrow-left mr-2 text-lg"></i>
        Kembali
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-3xl">
    <form action="{{ route('admin.admins.store') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-user text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}" required class="pl-10 w-full border-gray-300 rounded-lg focus:ring-[#1A6B3C] focus:border-[#1A6B3C] @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Masukkan nama admin">
                </div>
                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-envelope-simple text-gray-400 text-lg"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required class="pl-10 w-full border-gray-300 rounded-lg focus:ring-[#1A6B3C] focus:border-[#1A6B3C] @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" placeholder="email@contoh.com">
                </div>
                @error('email')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-lock-key text-gray-400 text-lg"></i>
                        </div>
                        <input type="password" name="password" required class="pl-10 w-full border-gray-300 rounded-lg focus:ring-[#1A6B3C] focus:border-[#1A6B3C] @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-lock-key text-gray-400 text-lg"></i>
                        </div>
                        <input type="password" name="password_confirmation" required class="pl-10 w-full border-gray-300 rounded-lg focus:ring-[#1A6B3C] focus:border-[#1A6B3C]" placeholder="Ulangi password">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-[#1A6B3C] text-white font-semibold rounded-lg hover:bg-[#13542f] transition-colors shadow-sm inline-flex items-center">
                <i class="ph ph-floppy-disk text-lg mr-2"></i>
                Simpan Admin
            </button>
        </div>
    </form>
</div>
@endsection
