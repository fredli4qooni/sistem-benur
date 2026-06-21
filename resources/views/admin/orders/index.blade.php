@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Pesanan Masuk</h1>
    <p class="text-gray-600">Validasi pembayaran dan kelola status pengiriman benur.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-gray-50/70 border-b border-gray-200 text-gray-500 text-xs font-semibold uppercase tracking-wider text-left">
                <tr>
                    <th class="px-6 py-4">No. Pesanan</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status Pesanan</th>
                    <th class="px-6 py-4">Jadwal Kirim</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-[#1A6B3C]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-md
                            {{ $order->status === 'selesai' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                            {{ $order->status === 'diproses' || $order->status === 'dikirim' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                            {{ $order->status === 'pending' ? 'bg-orange-100 text-orange-700 border border-orange-200' : '' }}
                            {{ $order->status === 'dibatalkan' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 rounded text-sm font-bold text-[#1A6B3C] bg-green-50 hover:bg-green-100 border border-green-200 transition-colors">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="ph ph-receipt text-4xl text-gray-300 mb-3 block"></i>
                        <p class="text-sm">Belum ada pesanan masuk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden divide-y divide-gray-100">
        @forelse($orders as $order)
        <div class="p-4 space-y-3">
            <div class="flex justify-between items-center">
                <span class="font-mono font-bold text-gray-900 text-sm">{{ $order->order_number }}</span>
                <span class="px-2.5 py-1 text-[10px] font-bold rounded-md
                    {{ $order->status === 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $order->status === 'diproses' || $order->status === 'dikirim' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $order->status === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                    {{ $order->status === 'dibatalkan' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="text-xs text-gray-600 space-y-1">
                <p>Pelanggan: <span class="font-bold text-gray-800">{{ $order->user->name }}</span></p>
                <p>Jadwal Kirim: <span class="font-medium text-green-700">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</span></p>
                <p class="text-sm font-bold text-[#1A6B3C] mt-2 block">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-[#1A6B3C] py-2 rounded-lg text-xs font-bold hover:bg-green-50 transition">
                Detail & Validasi
            </a>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500 text-sm">
            <i class="ph ph-receipt text-4xl text-gray-300 mb-3 block"></i>
            Belum ada pesanan masuk.
        </div>
        @endforelse
    </div>

    <div class="px-6 py-4 border-t">
        {{ $orders->links() }}
    </div>
</div>
@endsection
