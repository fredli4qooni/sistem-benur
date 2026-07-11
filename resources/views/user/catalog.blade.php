@extends('layouts.user')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Katalog Benur</h1>
        <p class="text-gray-500 text-sm mt-0.5">Pilih dan pesan benih udang & ikan air payau berkualitas tinggi untuk tambak Anda.</p>
    </div>
    <div class="flex items-center space-x-2 text-xs font-semibold text-gray-500 bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm">
        <i class="ph-fill ph-check-circle text-green-500 text-base"></i>
        <span>Stok Terverifikasi</span>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 p-4 mb-8 rounded-xl text-sm flex items-center shadow-sm">
    <i class="ph-fill ph-check-circle text-xl mr-2"></i>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
    @forelse($products as $product)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-200 flex flex-col overflow-hidden group">
            
            <div class="relative h-32 sm:h-48 bg-gray-50 border-b border-gray-100 flex-shrink-0 overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $product->name }}">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                        <i class="ph ph-image text-4xl mb-2 text-gray-300"></i>
                        <span class="text-xs font-medium">Tanpa Gambar</span>
                    </div>
                @endif

                @if($product->category)
                    <span class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-white/90 backdrop-blur-sm text-gray-700 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-md shadow-sm border border-gray-200 uppercase tracking-wider">
                        {{ $product->category }}
                    </span>
                @endif
            </div>

            <div class="p-3 sm:p-5 flex flex-col flex-1">
                <div class="mb-1 sm:mb-2">
                    <h2 class="text-sm sm:text-lg font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-[#1A6B3C] transition-colors">{{ $product->name }}</h2>
                    @if($product->description)
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                    @endif
                </div>

                <div class="mt-auto pt-2 sm:pt-4 border-t border-gray-50">
                    <p class="text-[9px] sm:text-xs text-gray-400 font-medium mb-0.5 sm:mb-1 uppercase tracking-wider">Harga per {{ $product->unit }}</p>
                    <p class="text-sm sm:text-xl font-extrabold text-[#1A6B3C] tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="mt-2 sm:mt-3 flex items-center text-[10px] sm:text-xs font-medium">
                    @if($product->stock > 0)
                        <i class="ph-fill ph-check-circle text-green-500 mr-1 sm:mr-1.5 text-xs sm:text-sm"></i>
                        <span class="text-gray-600 line-clamp-1">Sisa stok: <span class="text-gray-900 font-bold">{{ $product->stock }}</span> {{ $product->unit }}</span>
                    @else
                        <i class="ph-fill ph-x-circle text-red-500 mr-1 sm:mr-1.5 text-xs sm:text-sm"></i>
                        <span class="text-red-600 font-bold line-clamp-1">Stok Habis</span>
                    @endif
                </div>

                <div class="mt-3 sm:mt-5">
                    @if($product->stock > 0)
                        <form action="{{ route('user.cart.store', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full flex items-center justify-center bg-white border border-[#1A6B3C] sm:border-2 text-[#1A6B3C] font-bold py-1.5 sm:py-2.5 rounded-md sm:rounded-lg hover:bg-[#1A6B3C] hover:text-white transition-colors duration-200 text-[11px] sm:text-sm">
                                <i class="ph ph-shopping-cart text-sm sm:text-lg mr-1.5 sm:mr-2"></i>
                                Tambah
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full flex items-center justify-center bg-gray-50 border border-gray-100 sm:border-2 text-gray-400 font-bold py-1.5 sm:py-2.5 rounded-md sm:rounded-lg cursor-not-allowed text-[11px] sm:text-sm">
                            <i class="ph ph-prohibit text-sm sm:text-lg mr-1.5 sm:mr-2"></i>
                            Habis
                        </button>
                    @endif
                </div>
            </div>
            
        </div>
    @empty
        <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 flex flex-col items-center justify-center text-center shadow-sm">
            <div class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="ph ph-package text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Katalog Masih Kosong</h3>
            <p class="text-gray-500 text-sm mt-1 max-w-md">Saat ini belum ada produk benur yang tersedia atau aktif. Silakan periksa kembali beberapa saat lagi.</p>
        </div>
    @endforelse
</div>

@if($products->hasPages())
    <div class="mt-8 pt-6 border-t border-gray-200">
        {{ $products->links() }}
    </div>
@endif
@endsection
