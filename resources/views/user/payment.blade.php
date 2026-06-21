@extends('layouts.user')

@section('content')
<div class="max-w-2xl mx-auto mb-6 mt-4 text-center">
    <h1 class="text-2xl font-bold text-gray-800">Selesaikan Pembayaran</h1>
    <p class="text-gray-600 text-sm mt-1">Selesaikan pembayaran Anda menggunakan metode pembayaran yang aman.</p>
</div>

@if(session('success'))
<div class="max-w-2xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
    {{ session('success') }}
</div>
@endif

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6 md:p-8 border border-gray-100 flex flex-col justify-center items-center text-center">
        
        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-4 border border-blue-100">
            <i class="ph-fill ph-credit-card text-3xl"></i>
        </div>

        <h2 class="text-lg font-bold text-gray-800 mb-2">Total Tagihan</h2>
        <p class="text-4xl font-extrabold text-[#1A6B3C] mb-6">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>

        <div class="w-full bg-gray-50 border border-gray-100 p-4 rounded-lg mb-8 text-left flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">ID Pesanan</p>
                <p class="font-mono font-bold text-gray-800 text-lg">{{ $order->order_number }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Status</p>
                <p class="font-bold text-yellow-600 capitalize">{{ $transaction->status }}</p>
            </div>
        </div>

        @if($transaction->status === 'menunggu')
            <button id="pay-button" class="w-full bg-[#1A6B3C] text-white font-bold py-4 rounded-xl hover:bg-[#2E8B57] transition shadow-lg text-lg flex justify-center items-center">
                <i class="ph-fill ph-lock-key mr-2 text-xl"></i> Bayar Sekarang dengan Midtrans
            </button>
            <p class="text-xs text-gray-400 mt-4"><i class="ph-fill ph-shield-check text-green-500"></i> Pembayaran Anda dijamin aman dan terenkripsi.</p>
        @else
            <div class="w-full bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg text-center flex flex-col items-center">
                <i class="ph-fill ph-check-circle text-4xl text-green-500 mb-2"></i>
                <p class="font-bold text-lg">Pembayaran Berhasil!</p>
                <p class="text-sm mt-1">Pesanan Anda sedang diproses oleh admin.</p>
            </div>
            <a href="{{ route('user.orders.index') }}" class="mt-6 block w-full text-center bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 transition">
                Lihat Pesanan Saya
            </a>
        @endif
    </div>
</div>

@if($transaction->status === 'menunggu' && $transaction->snap_token)
@push('scripts')
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        // SnapToken acquired from previous step
        snap.pay('{{ $transaction->snap_token }}', {
            // Optional
            onSuccess: function(result){
                window.location.href = "{{ route('user.orders.index') }}";
            },
            // Optional
            onPending: function(result){
                window.location.reload();
            },
            // Optional
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    };
</script>
@endpush
@endif
@endsection
