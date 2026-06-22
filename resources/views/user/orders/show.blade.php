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
            <div class="text-sm text-gray-600 space-y-2">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-bold mb-0.5">Alamat Kirim:</p>
                    <p class="font-medium text-gray-800">{{ $order->delivery_address }}</p>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    <span class="text-gray-500 font-medium">Estimasi Tiba</span>
                    <span class="font-bold text-gray-900">{{ date('d M Y', strtotime($order->delivery_date)) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 font-medium">Ongkos Kirim</span>
                    <span class="font-extrabold text-[#1A6B3C] bg-green-50 px-2 py-1 rounded text-xs uppercase tracking-wider">Gratis (Free)</span>
                </div>
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
            
            @if($order->status === 'pending')
                <div class="border-t pt-4 mt-4">
                    <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        <button type="submit" class="w-full bg-white border border-red-200 text-red-600 font-bold py-2.5 rounded-lg hover:bg-red-50 transition-colors text-sm">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @elseif(in_array($order->status, ['dikonfirmasi', 'disiapkan']))
                @if($order->is_cancellation_requested)
                    <div class="border-t pt-4 mt-4">
                        <div class="bg-yellow-50 text-yellow-800 p-3 rounded-lg text-sm border border-yellow-200 text-center font-medium">
                            <i class="ph-fill ph-clock text-lg mb-1 block"></i>
                            Pengajuan pembatalan Anda sedang ditinjau oleh Admin.
                        </div>
                    </div>
                @else
                    <div class="border-t pt-4 mt-4">
                        <button type="button" onclick="document.getElementById('cancelModal').classList.remove('hidden')" class="w-full bg-white border border-orange-200 text-orange-600 font-bold py-2.5 rounded-lg hover:bg-orange-50 transition-colors text-sm">
                            Ajukan Pembatalan
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Modal Ajukan Pembatalan -->
<div id="cancelModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Ajukan Pembatalan</h3>
            <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="ph ph-x text-xl"></i></button>
        </div>
        <p class="text-sm text-gray-500 mb-4 leading-relaxed">Harap masukkan alasan pembatalan. Admin akan meninjau pengajuan Anda. Karena pesanan ini sudah dibayar, dana akan dikembalikan (refund) secara manual oleh admin jika pengajuan disetujui.</p>
        <form action="{{ route('user.orders.request-cancel', $order->id) }}" method="POST">
            @csrf
            <textarea name="cancel_reason" rows="3" required class="w-full border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 mb-4 text-sm" placeholder="Contoh: Salah pilih benur / Ingin ubah alamat / Berubah pikiran"></textarea>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition-colors">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>
@endsection
