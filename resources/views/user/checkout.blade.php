@extends('layouts.user')

@section('content')
<div class="mb-4 md:mb-6">
    <a href="{{ route('user.catalog') }}" class="text-xs md:text-sm text-gray-500 hover:text-[#1A6B3C] mb-2 inline-block">&larr; Kembali ke Katalog</a>
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Checkout Pesanan</h1>
</div>

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
    {{ session('error') }}
</div>
@endif

<form action="{{ route('user.checkout.store', $product->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
    @csrf

    <div class="lg:col-span-2 space-y-4 md:space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <h2 class="text-base md:text-lg font-bold text-gray-800 border-b pb-2 md:pb-3 mb-3 md:mb-4">Informasi Pengiriman</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Tambak / Pengiriman <span class="text-red-500">*</span></label>
                    <textarea name="delivery_address" rows="3" required class="w-full border-gray-300 rounded-md focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">{{ old('delivery_address', Auth::user()->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Pengiriman <span class="text-red-500">*</span></label>
                    <input type="text" name="delivery_date" id="delivery_date" value="{{ old('delivery_date') }}" placeholder="Pilih tanggal..." required class="w-full border-gray-300 rounded-md focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
                    <p class="text-xs text-gray-500 mt-1">Kami hanya melayani pengiriman pada hari <span class="font-bold text-[#1A6B3C]">Senin</span> dan <span class="font-bold text-[#1A6B3C]">Kamis</span>.</p>
                    @error('delivery_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: Titip di pos penjagaan" class="w-full border-gray-300 rounded-md focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <h2 class="text-base md:text-lg font-bold text-gray-800 border-b pb-2 md:pb-3 mb-3 md:mb-4">Metode Pembayaran</h2>
            <div class="space-y-3">
                <label class="flex items-center p-3 border border-green-200 bg-green-50 rounded-lg cursor-pointer hover:bg-green-100 transition-colors">
                    <input type="radio" name="payment_method" value="midtrans" checked class="w-5 h-5 text-[#1A6B3C] border-gray-300 focus:ring-[#1A6B3C]">
                    <div class="ml-3 flex items-center">
                        <i class="ph-fill ph-shield-check text-green-600 text-2xl mr-3"></i>
                        <div>
                            <span class="block font-bold text-gray-800">Pembayaran Online (Midtrans)</span>
                            <span class="block text-xs text-gray-500 mt-0.5">Mendukung QRIS, Virtual Account, E-Wallet, dan lainnya.</span>
                        </div>
                    </div>
                </label>

                <label class="flex items-center p-3 border border-gray-200 hover:border-orange-300 hover:bg-orange-50 bg-white rounded-lg cursor-pointer transition-colors">
                    <input type="radio" name="payment_method" value="tunai" class="w-5 h-5 text-orange-500 border-gray-300 focus:ring-orange-500">
                    <div class="ml-3 flex items-center">
                        <i class="ph-fill ph-money text-orange-500 text-2xl mr-3"></i>
                        <div>
                            <span class="block font-bold text-gray-800">Uang Tunai (COD / Bayar di Tempat)</span>
                            <span class="block text-xs text-gray-500 mt-0.5">Bayar tunai langsung kepada kurir saat pesanan tiba.</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 sticky top-20 md:top-24">
            <h2 class="text-base md:text-lg font-bold text-gray-800 border-b pb-2 md:pb-3 mb-3 md:mb-4">Ringkasan Pesanan</h2>

            <div class="flex items-center space-x-4 mb-4">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 rounded object-cover">
                @else
                <div class="w-16 h-16 rounded bg-gray-200 flex items-center justify-center text-xs text-gray-500">No Pic</div>
                @endif
                <div>
                    <h3 class="font-bold text-sm line-clamp-1">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }} / {{ $product->unit }}</p>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pesanan ({{ $product->unit }})</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stock }}" required class="w-full border-gray-300 rounded-md focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
                <p class="text-xs text-gray-500 mt-1">Stok tersedia: {{ $product->stock }}</p>
            </div>

            <div class="border-t pt-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Total Pembayaran</span>
                    <span class="font-bold text-xl text-[#1A6B3C]" id="total_price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#1A6B3C] text-white font-bold py-3 rounded-lg hover:bg-[#2E8B57] transition shadow-md">
                Buat Pesanan Sekarang
            </button>
        </div>
    </div>
</form>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pricePerUnit = Number("{{ $product->price }}");
        const quantityInput = document.getElementById('quantity');
        const totalPriceEl = document.getElementById('total_price');

        quantityInput.addEventListener('input', function() {
            let qty = parseInt(this.value);
            if (isNaN(qty) || qty < 0) qty = 0;
            
            const total = qty * pricePerUnit;
            totalPriceEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        });

        quantityInput.addEventListener('blur', function() {
            let qty = parseInt(this.value);
            if (isNaN(qty) || qty < 1) {
                this.value = 1;
                qty = 1;
            }
            
            const total = qty * pricePerUnit;
            totalPriceEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        });

        flatpickr("#delivery_date", {
            minDate: "today",
            dateFormat: "Y-m-d",
            disable: [
                function(date) {
                    // Disable semua hari kecuali Senin (1) dan Kamis (4)
                    return (date.getDay() !== 1 && date.getDay() !== 4);
                }
            ]
        });
    });
</script>
@endpush
@endsection
