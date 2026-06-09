@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Data Benur</h1>
    <p class="text-gray-600">Perbarui informasi produk benur: <span class="font-bold">{{ $product->name }}</span></p>
</div>

<div class="bg-white rounded-lg shadow-sm p-6 max-w-3xl">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('button[type=submit]').innerHTML = 'Menyimpan...';">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Benur <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                <select name="unit" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
                    <option value="ekor" {{ old('unit', $product->unit) == 'ekor' ? 'selected' : '' }}>Ekor</option>
                    <option value="boks" {{ old('unit', $product->unit) == 'boks' ? 'selected' : '' }}>Boks</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stok Saat Ini <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Batas Minimal Stok <span class="text-red-500">*</span></label>
                <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Update Foto (Opsional)</label>
                @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" class="h-20 w-20 object-cover rounded border">
                </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Produk <span class="text-red-500">*</span></label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="1" {{ old('status', $product->status) == '1' ? 'checked' : '' }} class="text-[#1A6B3C] focus:ring-[#1A6B3C]">
                        <span class="ml-2">Aktif</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="0" {{ old('status', $product->status) == '0' ? 'checked' : '' }} class="text-[#1A6B3C] focus:ring-[#1A6B3C]">
                        <span class="ml-2 text-gray-600">Nonaktif</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#1A6B3C] text-white rounded-md hover:bg-[#2E8B57] transition">Update Produk</button>
        </div>
    </form>
</div>
@endsection