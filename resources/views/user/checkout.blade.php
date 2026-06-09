@extends('layouts.user')

@section('content')
<div class="mb-6">
    <a href="{{ route('user.catalog') }}" class="text-sm text-gray-500 hover:text-[#1A6B3C] mb-2 inline-block">&larr; Kembali ke Katalog</a>
    <h1 class="text-2xl font-bold text-gray-800">Checkout Pesanan</h1>
</div>

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
    {{ session('error') }}
</div>
@endif

<form action="{{ route('user.checkout.store', $product->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Informasi Pengiriman</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Tambak / Pengiriman <span class="text-red-500">*</span></label>
                    <textarea name="delivery_address" rows="3" required class="w-full border-gray-300 rounded-md focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">{{ old('delivery_address', Auth::user()->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Pengiriman <span class="text-red-500">*</span></label>
                    <input type="date" name="delivery_date" id="delivery_date" value="{{ old('delivery_date') }}" required class="w-full border-gray-300 rounded-md focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
                    <p class="text-xs text-gray-500 mt-1">Kami hanya melayani pengiriman pada hari <span class="font-bold text-[#1A6B3C]">Senin</span> dan <span class="font-bold text-[#1A6B3C]">Kamis</span>.</p>
                    @error('delivery_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: Titip di pos penjagaan" class="w-full border-gray-300 rounded-md focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Metode Pembayaran</h2>
            <div class="space-y-3">
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="payment_method" value="qris" required class="text-[#1A6B3C] focus:ring-[#1A6B3C]" {{ old('payment_method') == 'qris' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium">QRIS (Otomatis / Upload Bukti)</span>
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="payment_method" value="transfer" class="text-[#1A6B3C] focus:ring-[#1A6B3C]" {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium">Transfer Bank Manual</span>
                </label>
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 sticky top-24">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Ringkasan Pesanan</h2>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pricePerUnit = Number("{{ $product->price }}");
        const quantityInput = document.getElementById('quantity');
        const totalPriceEl = document.getElementById('total_price');

        quantityInput.addEventListener('input', function() {
            let qty = this.value;
            if (qty < 1) {
                qty = 1;
                this.value = 1;
            }
            const total = qty * pricePerUnit;
            totalPriceEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        });

        const dateInput = document.getElementById('delivery_date');

        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);

        dateInput.addEventListener('input', function(e) {
            const selectedDate = new Date(this.value);
            const day = selectedDate.getDay();

            if (this.value !== "" && day !== 1 && day !== 4) {
                alert('Pilihan tidak valid! Pengiriman hanya dilakukan pada hari Senin dan Kamis.');
                this.value = '';
            }
        });
    });
</script>
@endsection