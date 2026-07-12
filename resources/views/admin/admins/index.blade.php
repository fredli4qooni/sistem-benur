@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Admin</h1>
        <p class="text-gray-600 text-sm mt-1">Kelola akun administrator sistem.</p>
    </div>
    <a href="{{ route('admin.admins.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-[#1A6B3C] text-white text-sm font-semibold rounded-lg hover:bg-[#13542f] transition-colors shadow-sm">
        <i class="ph ph-plus text-lg mr-2"></i>
        Tambah Admin
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-[#1A6B3C] text-green-700 p-4 mb-6 rounded shadow-sm flex items-center">
    <i class="ph-fill ph-check-circle text-xl mr-2"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm flex items-center">
    <i class="ph-fill ph-x-circle text-xl mr-2"></i>
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50/50 text-gray-700 font-semibold border-b border-gray-100 uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama Admin</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-green-100 text-[#1A6B3C] flex items-center justify-center font-bold text-xs mr-3 border border-green-200">
                                {{ substr($admin->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-gray-800">{{ $admin->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $admin->email }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            Administrator
                        </span>
                        @if($admin->id === auth()->id())
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200 ml-1">
                                Anda
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors" title="Edit Admin">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </a>
                            
                            @if($admin->id !== auth()->id())
                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini secara permanen?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus Admin">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                            @else
                            <button type="button" disabled class="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-50 text-gray-400 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <i class="ph ph-user-circle-minus text-4xl mb-3 text-gray-400"></i>
                        <p>Belum ada data admin lainnya.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($admins->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $admins->links() }}
    </div>
    @endif
</div>
@endsection
