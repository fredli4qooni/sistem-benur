@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Data Benur</h1>
        <p class="text-gray-600">Kelola katalog produk benur Anda di sini.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-[#1A6B3C] text-white px-4 py-2 rounded-md hover:bg-[#2E8B57] transition">
        + Tambah Benur
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="w-full whitespace-nowrap">
        <thead class="bg-gray-50 border-b">
            <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <th class="px-6 py-4">Produk</th>
                <th class="px-6 py-4">Kategori</th>
                <th class="px-6 py-4">Harga / Satuan</th>
                <th class="px-6 py-4">Stok</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 flex items-center">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded object-cover mr-3" alt="Foto">
                    @else
                    <div class="w-10 h-10 rounded bg-gray-200 mr-3 flex items-center justify-center text-gray-500 text-xs">No Pic</div>
                    @endif
                    <span class="font-medium text-gray-800">{{ $product->name }}</span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $product->category ?? '-' }}</td>
                <td class="px-6 py-4 text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }} <span class="text-xs text-gray-400">/ {{ $product->unit }}</span></td>
                <td class="px-6 py-4">
                    <span class="{{ $product->stock <= $product->min_stock ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($product->status)
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                    @else
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data produk benur.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 border-t">
        {{ $products->links() }}
    </div>
</div>
@endsection