@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Data Benur</h1>
        <p class="text-gray-600">Kelola katalog produk benur Anda di sini.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex justify-center w-full sm:w-auto bg-[#1A6B3C] text-white px-4 py-2 rounded-md hover:bg-[#2E8B57] transition font-bold shadow-sm">
        + Tambah Benur
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-gray-50/70 border-b border-gray-200 text-gray-500 text-xs font-semibold uppercase tracking-wider text-left">
                <tr>
                    <th class="px-6 py-4">Nama & Kategori</th>
                    <th class="px-6 py-4">Harga & Stok</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded object-cover border border-gray-200">
                            @else
                            <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                                <i class="ph ph-image text-xl"></i>
                            </div>
                            @endif
                            <div>
                                <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->category ?? 'Tanpa Kategori' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-[#1A6B3C]">Rp {{ number_format($product->price, 0, ',', '.') }}<span class="text-xs text-gray-500 font-normal"> / {{ $product->unit }}</span></p>
                        <p class="text-xs font-medium {{ $product->stock > 0 ? 'text-gray-600' : 'text-red-500' }}">Sisa stok: {{ $product->stock }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-md {{ $product->status ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                            {{ $product->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors" title="Edit Produk">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded text-red-600 bg-red-50 hover:bg-red-100 transition-colors" title="Hapus Produk" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <i class="ph ph-package text-4xl text-gray-300 mb-3 block"></i>
                        <p class="text-sm">Belum ada produk yang ditambahkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden divide-y divide-gray-100">
        @forelse($products as $product)
        <div class="p-4 space-y-4">
            <div class="flex items-start space-x-3">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shrink-0">
                @else
                <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200 shrink-0">
                    <i class="ph ph-image text-2xl"></i>
                </div>
                @endif
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-gray-900 text-sm leading-tight">{{ $product->name }}</h3>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md shrink-0 ml-2 {{ $product->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $product->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $product->category ?? 'Tanpa Kategori' }}</p>
                    <div class="mt-2 flex justify-between items-end">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold mb-0.5">Harga</p>
                            <p class="font-bold text-[#1A6B3C] text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}<span class="text-xs text-gray-500 font-normal"> / {{ $product->unit }}</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold mb-0.5">Sisa Stok</p>
                            <p class="text-sm font-bold {{ $product->stock > 0 ? 'text-gray-700' : 'text-red-500' }}">{{ $product->stock }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex space-x-2 pt-2 border-t border-gray-50">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="flex-1 flex items-center justify-center space-x-1 py-2 rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors text-xs font-bold">
                    <i class="ph ph-pencil-simple text-sm"></i> <span>Edit</span>
                </a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center space-x-1 py-2 rounded-lg text-red-600 bg-red-50 hover:bg-red-100 transition-colors text-xs font-bold" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                        <i class="ph ph-trash text-sm"></i> <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500">
            <i class="ph ph-package text-4xl text-gray-300 mb-3 block"></i>
            <p class="text-sm">Belum ada produk yang ditambahkan.</p>
        </div>
        @endforelse
    </div>

    <div class="px-6 py-4 border-t">
        {{ $products->links() }}
    </div>
</div>
@endsection