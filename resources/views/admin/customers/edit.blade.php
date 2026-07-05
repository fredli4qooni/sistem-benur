@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Pelanggan</h1>
        <p class="text-gray-600 text-sm">Perbarui informasi data pelanggan {{ $customer->name }}.</p>
    </div>
    <a href="{{ route('admin.customers.index') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
        <i class="ph ph-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="p-6 sm:p-8">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] focus:bg-white transition-all text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] focus:bg-white transition-all text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" minlength="8" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] focus:bg-white transition-all text-sm @error('password') border-red-500 @enderror" placeholder="Biarkan kosong jika tidak ingin mengubah">
                    <p class="text-xs text-gray-500 mt-1.5">Minimal 8 karakter.</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp/Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] focus:bg-white transition-all text-sm @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Tambak</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] focus:bg-white transition-all text-sm resize-none @error('address') border-red-500 @enderror">{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.customers.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#1A6B3C] hover:bg-[#13542f] rounded-lg shadow-sm transition-colors flex items-center">
                <i class="ph ph-floppy-disk mr-2 text-lg"></i> Perbarui Data
            </button>
        </div>
    </form>
</div>
@endsection
