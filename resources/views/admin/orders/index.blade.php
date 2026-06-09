@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Pesanan Masuk</h1>
    <p class="text-gray-600">Validasi pembayaran dan kelola status pengiriman benur.</p>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="w-full whitespace-nowrap">
        <thead class="bg-gray-50 border-b">
            <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <th class="px-6 py-4">No. Pesanan</th>
                <th class="px-6 py-4">Pelanggan</th>
                <th class="px-6 py-4">Total Bayar</th>
                <th class="px-6 py-4">Metode</th>
                <th class="px-6 py-4">Status Pesanan</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-mono font-bold text-gray-800">{{ $order->order_number }}</td>
                <td class="px-6 py-4 text-gray-700">{{ $order->user->name }}</td>
                <td class="px-6 py-4 text-gray-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 uppercase text-xs font-medium text-gray-500">{{ $order->transaction->method ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($order->status === 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-medium">Pending</span>
                    @elseif($order->status === 'dikonfirmasi')
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">Dikonfirmasi</span>
                    @else
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">{{ $order->status }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-medium hover:bg-gray-200 transition">Detail & Validasi</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan masuk saat ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $orders->links() }}
    </div>
</div>
@endsection