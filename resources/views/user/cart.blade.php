@extends('layouts.user')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h1>
    <p class="text-gray-500 text-sm mt-1">Periksa kembali daftar produk yang ingin Anda pesan.</p>
</div>

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 p-4 mb-6 rounded text-sm flex items-center shadow-sm">
    <i class="ph-fill ph-check-circle text-xl mr-2"></i>
    {{ session('success') }}
</div>
@endif

@if($carts->isEmpty())
<div class="bg-white rounded-xl border border-gray-200 p-12 flex flex-col items-center justify-center text-center shadow-sm">
    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
        <i class="ph ph-shopping-cart text-4xl text-gray-400"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-800 mb-2">Keranjang Anda Kosong</h3>
    <p class="text-gray-500 text-sm mb-6">Sepertinya Anda belum memilih produk apa pun. Yuk, lihat katalog kami!</p>
    <a href="{{ route('user.catalog') }}" class="px-6 py-2.5 bg-[#1A6B3C] text-white font-semibold rounded-lg hover:bg-[#13542f] transition-colors shadow-sm">
        Lihat Katalog
    </a>
</div>
@else
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        @php $totalPrice = 0; @endphp
        @foreach($carts as $cart)
            @php 
                $subtotal = $cart->product->price * $cart->quantity;
                $totalPrice += $subtotal;
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                    @if($cart->product->image)
                        <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="ph ph-image text-2xl"></i>
                        </div>
                    @endif
                </div>
                
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 line-clamp-1">{{ $cart->product->name }}</h3>
                    <p class="text-sm text-[#1A6B3C] font-semibold mt-1">Rp {{ number_format($cart->product->price, 0, ',', '.') }} <span class="text-xs text-gray-500 font-normal">/ {{ $cart->product->unit }}</span></p>
                    
                    <div class="flex items-center justify-between mt-3">
                        <!-- Quantity Controller -->
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden w-28">
                            <form action="{{ route('user.cart.update', $cart->id) }}" method="POST" class="flex-1 text-center bg-gray-50 hover:bg-gray-100 transition">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $cart->quantity - 1 }}">
                                <button type="submit" class="w-full py-1 text-gray-600 hover:text-gray-900" {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                    <i class="ph ph-minus"></i>
                                </button>
                            </form>
                            
                            <div class="flex-1 text-center py-1 text-sm font-semibold border-x border-gray-200 bg-white">
                                {{ $cart->quantity }}
                            </div>

                            <form action="{{ route('user.cart.update', $cart->id) }}" method="POST" class="flex-1 text-center bg-gray-50 hover:bg-gray-100 transition">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $cart->quantity + 1 }}">
                                <button type="submit" class="w-full py-1 text-gray-600 hover:text-gray-900" {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}>
                                    <i class="ph ph-plus"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('user.cart.destroy', $cart->id) }}" method="POST" class="ml-4" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus dari keranjang">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sticky top-24">
            <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-3">Ringkasan Belanja</h2>
            
            <div class="space-y-3 mb-5">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Total Item</span>
                    <span class="font-semibold text-gray-800">{{ $carts->sum('quantity') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Total Harga</span>
                    <span class="font-semibold text-gray-800">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-4 mb-6 flex justify-between items-center">
                <span class="font-bold text-gray-800">Total Pembayaran</span>
                <span class="text-xl font-extrabold text-[#1A6B3C]">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
            
            <a href="{{ route('user.checkout') }}" class="w-full flex items-center justify-center px-4 py-3 bg-[#1A6B3C] text-white font-bold rounded-lg hover:bg-[#13542f] transition-colors shadow-sm">
                Lanjut ke Pembayaran <i class="ph ph-arrow-right ml-2 text-lg"></i>
            </a>
            
            <a href="{{ route('user.catalog') }}" class="block text-center mt-3 text-sm text-[#1A6B3C] font-semibold hover:underline">
                Beli Produk Lainnya
            </a>
        </div>
    </div>
</div>
@endif
@endsection
