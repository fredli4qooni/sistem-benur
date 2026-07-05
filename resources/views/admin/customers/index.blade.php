@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Pelanggan</h1>
        <p class="text-gray-600 text-sm">Kelola informasi data pembudidaya dan hak akses akun mereka.</p>
    </div>
    
    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="relative w-full sm:w-64">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#1A6B3C] focus:border-[#1A6B3C]">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <i class="ph ph-magnifying-glass text-lg"></i>
            </div>
        </form>
        <a href="{{ route('admin.customers.create') }}" class="inline-flex justify-center items-center px-4 py-2 bg-[#1A6B3C] text-white text-sm font-semibold rounded-lg hover:bg-[#13542f] transition-colors shadow-sm whitespace-nowrap">
            <i class="ph ph-plus-circle text-lg mr-2"></i>
            Tambah Pelanggan
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 p-4 mb-6 rounded-lg text-sm flex items-center">
    <i class="ph-fill ph-check-circle text-xl mr-2"></i>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50/70 border-b border-gray-200 text-gray-500 font-medium text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama & Email</th>
                    <th class="px-6 py-4">No. Telepon / WA</th>
                    <th class="px-6 py-4">Alamat Tambak</th>
                    <th class="px-6 py-4">Status Akun</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($customers as $customer)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-9 h-9 rounded-full bg-gray-100 text-gray-700 font-bold text-xs flex items-center justify-center border border-gray-200">
                                {{ substr($customer->name, 0, 2) }}
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                                <p class="text-xs text-gray-400 font-mono">{{ $customer->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-medium">
                        {{ $customer->phone ?? 'Belum diisi' }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate" title="{{ $customer->address }}">
                        {{ $customer->address ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($customer->status === 'aktif')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> Aktif
                            </span>
                        @elseif($customer->status === 'nonaktif')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5"></span> Nonaktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Diblokir
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Edit">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </a>
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini? Semua data terkait (termasuk pesanan) mungkin ikut terhapus atau bermasalah.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="ph ph-users-quad text-3xl mb-2 block text-gray-300"></i>
                        Tidak ada data pelanggan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden divide-y divide-gray-100">
        @forelse($customers as $customer)
        <div class="p-4 space-y-3">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-bold text-sm flex items-center justify-center border border-gray-200 shrink-0">
                    {{ substr($customer->name, 0, 2) }}
                </div>
                <div class="ml-3 flex-1 overflow-hidden">
                    <p class="font-bold text-gray-900 leading-tight truncate">{{ $customer->name }}</p>
                    <p class="text-[11px] text-gray-500 font-mono truncate">{{ $customer->email }}</p>
                </div>
                <div class="shrink-0 ml-2">
                    @if($customer->status === 'aktif')
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-green-50 text-green-700">
                            Aktif
                        </span>
                    @elseif($customer->status === 'nonaktif')
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-gray-100 text-gray-600">
                            Nonaktif
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-red-50 text-red-700">
                            Diblokir
                        </span>
                    @endif
                </div>
            </div>
            <div class="text-xs text-gray-600 space-y-1 pl-13">
                <p class="flex items-start"><i class="ph ph-phone mr-1.5 mt-0.5 text-gray-400"></i> {{ $customer->phone ?? 'Belum diisi' }}</p>
                <p class="flex items-start"><i class="ph ph-map-pin mr-1.5 mt-0.5 text-gray-400"></i> <span class="line-clamp-2">{{ $customer->address ?? '-' }}</span></p>
            </div>
            <div class="pt-3 border-t border-gray-50 flex items-center justify-end space-x-2">
                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="flex-1 flex justify-center items-center p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors text-xs font-semibold">
                    <i class="ph ph-pencil-simple mr-1.5 text-sm"></i> Edit
                </a>
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex justify-center items-center p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors text-xs font-semibold">
                        <i class="ph ph-trash mr-1.5 text-sm"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-400">
            <i class="ph ph-users-quad text-4xl mb-2 block text-gray-300"></i>
            <p class="text-sm">Tidak ada data pelanggan ditemukan.</p>
        </div>
        @endforelse
    </div>
    
    @if($customers->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
        {{ $customers->appends(['search' => $search])->links() }}
    </div>
    @endif
</div>
@endsection
