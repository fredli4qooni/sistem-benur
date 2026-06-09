@extends('layouts.user')

@section('content')
<div class="max-w-4xl mx-auto mb-6 mt-4">
    <a href="{{ route('user.orders.index') }}" class="text-sm text-gray-500 hover:text-[#1A6B3C] mb-2 inline-block">&larr; Kembali ke Riwayat Pesanan</a>
    <h1 class="text-2xl font-bold text-gray-800">Pelacakan Pesanan</h1>
    <p class="text-sm text-gray-500 mt-0.5">ID Pesanan: <span class="font-mono font-bold text-gray-800">{{ $order->order_number }}</span></p>
</div>

@php
    $statuses = ['pending', 'dikonfirmasi', 'disiapkan', 'dikirim', 'selesai'];
    $currentStep = array_search($order->status, $statuses);
    if($order->status === 'dibatalkan') $currentStep = -1; 
@endphp

<div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border md:col-span-1">
        <h2 class="text-base font-bold text-gray-800 border-b pb-3 mb-6">Status Perjalanan</h2>
        
        @if($order->status === 'dibatalkan')
            <div class="bg-red-50 text-red-800 p-4 rounded-lg text-center font-medium text-sm">
                ❌ Pesanan Ini Telah Dibatalkan
            </div>
        @else
            <div class="relative pl-6 space-y-8 before:absolute before:bottom-2 before:top-2 before:left-2 before:w-0.5 before:bg-gray-200">
                
                <div class="relative before:absolute before:left-[-22px] before:top-1 before:w-3.5 before:h-3.5 before:rounded-full {{ $currentStep >= 0 ? 'before:bg-[#1A6B3C]' : 'before:bg-gray-300' }}">
                    <h3 class="text-sm font-bold {{ $currentStep >= 0 ? 'text-gray-900' : 'text-gray-400' }}">Pesanan Masuk</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Menunggu validasi pembayaran oleh admin.</p>
                </div>

                <div class="relative before:absolute before:left-[-22px] before:top-1 before:w-3.5 before:h-3.5 before:rounded-full {{ $currentStep >= 1 ? 'before:bg-[#1A6B3C]' : 'before:bg-gray-300' }}">
                    <h3 class="text-sm font-bold {{ $currentStep >= 1 ? 'text-gray-900' : 'text-gray-400' }}">Dikonfirmasi</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Pembayaran valid, stok benur berhasil dipesan.</p>
                </div>

                <div class="relative before:absolute before:left-[-22px] before:top-1 before:w-3.5 before:h-3.5 before:rounded-full {{ $currentStep >= 2 ? 'before:bg-[#1A6B3C]' : 'before:bg-gray-300' }}">
                    <h3 class="text-sm font-bold {{ $currentStep >= 2 ? 'text-gray-900' : 'text-gray-400' }}">Sedang Disiapkan</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Benur sedang dihitung dan dikemas dalam boks khusus.</p>
                </div>

                <div class="relative before:absolute before:left-[-22px] before:top-1 before:w-3.5 before:h-3.5 before:rounded-full {{ $currentStep >= 3 ? 'before:bg-[#1A6B3C]' : 'before:bg-gray-300' }}">
                    <h3 class="text-sm font-bold {{ $currentStep >= 3 ? 'text-gray-900' : 'text-gray-400' }}">Dalam Pengiriman</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kurir sedang menuju ke lokasi tambak Anda.</p>
                </div>

                <div class="relative before:absolute before:left-[-22px] before:top-1 before:w-3.5 before:h-3.5 before:rounded-full {{ $currentStep >= 4 ? 'before:bg-[#1A6B3C]' : 'before:bg-gray-300' }}">
                    <h3 class="text-sm font-bold {{ $currentStep >= 4 ? 'text-gray-900' : 'text-gray-400' }}">Selesai</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Benur telah sampai dan diterima dengan baik.</p>
                </div>

            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border md:col-span-2 space-y-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Detail Pengiriman</h2>
            <div class="text-sm text-gray-600 space-y-1">
                <p><span class="text-gray-400">Alamat Kirim:</span></p>
                <p class="font-medium text-gray-800">{{ $order->delivery_address }}</p>
                <p class="pt-2"><span class="text-gray-400">Estimasi Tiba:</span> <span class="font-bold text-green-700">{{ date('d M Y', strtotime($order->delivery_date)) }}</span></p>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Item Pembelian</h2>
            <div class="divide-y">
                @foreach($order->items as $item)
                <div class="py-3 flex justify-between items-center text-sm">
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $item->product->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $item->quantity }} {{ $item->product->unit }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                    </div>
                    <span class="font-extrabold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
            
            <div class="border-t pt-3 flex justify-between items-center">
                <span class="text-sm font-medium text-gray-500">Total Pembayaran</span>
                <span class="font-extrabold text-lg text-[#1A6B3C]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection