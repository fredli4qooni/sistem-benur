@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Perusahaan</h1>
    <p class="text-gray-600 text-sm">Kelola informasi kontak dan rekening pembayaran pelanggan.</p>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @csrf
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Informasi Bisnis</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" required class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon / WA</label>
                <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" required class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor/Tambak Pusat</label>
                <textarea name="company_address" rows="3" required class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">{{ $settings['company_address'] ?? '' }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Informasi Pembayaran</h2>
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank (Cth: BCA)</label>
                    <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? '' }}" required class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                    <input type="text" name="bank_account" value="{{ $settings['bank_account'] ?? '' }}" required class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Atas Nama Rekening</label>
                <input type="text" name="bank_owner" value="{{ $settings['bank_owner'] ?? '' }}" required class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>
            
            <div class="pt-4 border-t">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar QRIS Baru</label>
                @if(isset($settings['qris_image']) && $settings['qris_image'])
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $settings['qris_image']) }}" class="h-32 border rounded p-1" alt="QRIS Aktif">
                        <p class="text-xs text-green-600 mt-1">✓ Gambar QRIS telah terpasang.</p>
                    </div>
                @endif
                <input type="file" name="qris_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border rounded-md">
                <p class="text-xs text-gray-500 mt-1">Hanya format JPG/PNG (Maks. 2MB). Biarkan kosong jika tidak ingin mengubah.</p>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 flex justify-end mt-2">
        <button type="submit" class="bg-[#1A6B3C] text-white font-bold py-3 px-8 rounded-lg hover:bg-[#2E8B57] transition shadow-md">
            Simpan Pengaturan
        </button>
    </div>
</form>
@endsection