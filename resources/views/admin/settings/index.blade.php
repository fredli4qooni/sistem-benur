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

<form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-2xl space-y-6">
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
                <textarea name="company_address" rows="4" required class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">{{ $settings['company_address'] ?? '' }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-2">
        <button type="submit" class="bg-[#1A6B3C] text-white font-bold py-3 px-8 rounded-lg hover:bg-[#2E8B57] transition shadow-md">
            Simpan Pengaturan
        </button>
    </div>
</form>
@endsection
