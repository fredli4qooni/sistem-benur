@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto mb-6 mt-4">
    <h1 class="text-2xl font-bold text-gray-800 text-center">Selesaikan Pembayaran</h1>
    <p class="text-gray-600 text-center text-sm mt-1">Sisa waktu pembayaran: <span class="font-bold text-red-500">23:59:59</span></p>
</div>

@if(session('success'))
<div class="max-w-3xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
    {{ session('success') }}
</div>
@endif

<div class="max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col justify-center items-center">
        <h2 class="text-lg font-bold text-gray-800 mb-4 text-center">Nominal yang harus dibayar</h2>
        <p class="text-3xl font-extrabold text-[#1A6B3C] mb-6">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>

        @if($transaction->method === 'qris')
        <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center">
            <p class="font-bold text-gray-700 mb-2">Scan QRIS Berikut:</p>
            <div class="w-48 h-48 bg-white border-4 border-gray-300 p-2 rounded shadow flex items-center justify-center">
                @if(isset($settings['qris_image']) && $settings['qris_image'])
                <img src="{{ asset('storage/' . $settings['qris_image']) }}" alt="QRIS Perusahaan" class="w-full h-full object-contain">
                @else
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Pembayaran+Pesanan+{{ $order->order_number }}" alt="QRIS Dummy">
                @endif
            </div>
            <p class="text-xs text-gray-500 mt-3 text-center">Aplikasi yang didukung: GoPay, OVO, Dana, ShopeePay, dan M-Banking.</p>
        </div>
        @else
        <div class="w-full bg-gray-50 p-4 border rounded-lg">
            <p class="text-sm text-gray-600 mb-1">Transfer tepat hingga 3 digit terakhir ke rekening:</p>
            <div class="flex items-center space-x-3 mb-3">
                <div class="bg-blue-800 text-white font-bold px-2 py-1 rounded text-xs">{{ $settings['bank_name'] ?? 'BANK' }}</div>
                <span class="font-bold text-lg tracking-wider">{{ $settings['bank_account'] ?? '0000000000' }}</span>
            </div>
            <p class="text-sm font-medium text-gray-700 uppercase">A.N. {{ $settings['bank_owner'] ?? 'PERUSAHAAN' }}</p>
        </div>
        @endif

        <div class="mt-6 w-full text-center">
            <span class="text-sm text-gray-500">ID Pesanan:</span>
            <p class="font-mono font-bold text-gray-800">{{ $order->order_number }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Konfirmasi Pembayaran</h2>

        @if($transaction->proof_image)
        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg text-center">
            <svg class="w-8 h-8 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="font-bold text-sm">Bukti pembayaran telah diunggah.</p>
            <p class="text-xs mt-1">Admin kami sedang memverifikasi pembayaran Anda.</p>
        </div>
        <a href="{{ route('user.catalog') }}" class="mt-4 block w-full text-center bg-gray-100 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-200 transition">
            Kembali ke Katalog
        </a>
        @else
        <p class="text-sm text-gray-600 mb-4">Setelah melakukan pembayaran, silakan unggah foto atau tangkapan layar (screenshot) bukti transfer Anda di sini[cite: 121].</p>

        <form action="{{ route('user.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                <input type="file" name="proof_image" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border rounded-md">
                @error('proof_image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-[#1A6B3C] text-white font-bold py-3 rounded-lg hover:bg-[#2E8B57] transition shadow-md mt-4">
                Kirim Konfirmasi Pembayaran
            </button>
        </form>
        @endif
    </div>
</div>
@endsection