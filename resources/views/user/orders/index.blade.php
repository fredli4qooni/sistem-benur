@extends('layouts.user')

@section('content')
<div class="mb-6 mt-4">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Pesanan Saya</h1>
    <p class="text-gray-600 text-sm mt-1">Pantau status pembayaran dan pengiriman benur Anda.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">No. Pesanan</th>
                    <th class="px-6 py-4">Tanggal Pesan</th>
                    <th class="px-6 py-4">Jadwal Kirim</th>
                    <th class="px-6 py-4">Total Pembayaran</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-mono font-bold text-gray-900">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-medium text-green-700">{{ date('d M Y', strtotime($order->delivery_date)) }}</td>
                    <td class="px-6 py-4 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($order->status === 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-medium">Pending</span>
                        @elseif($order->status === 'dikonfirmasi')
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">Dikonfirmasi</span>
                        @elseif($order->status === 'selesai')
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Selesai</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full font-medium capitalize">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('user.orders.show', $order->id) }}" class="inline-block bg-[#1A6B3C] text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-[#2E8B57] transition">
                            Lacak Pesanan
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">Anda belum pernah melakukan pemesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="block md:hidden divide-y divide-gray-100">
        @forelse($orders as $order)
        <div class="p-4 space-y-3">
            <div class="flex justify-between items-center">
                <span class="font-mono font-bold text-gray-900 text-sm">{{ $order->order_number }}</span>
                @if($order->status === 'pending')
                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 text-[10px] rounded-full font-medium">Pending</span>
                @elseif($order->status === 'dikonfirmasi')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-[10px] rounded-full font-medium">Dikonfirmasi</span>
                @else
                    <span class="px-2 py-0.5 bg-green-100 text-green-800 text-[10px] rounded-full font-medium capitalize">{{ $order->status }}</span>
                @endif
            </div>
            <div class="text-xs text-gray-500 space-y-1">
                <p>Jadwal Kirim: <span class="font-medium text-green-700">{{ date('d M Y', strtotime($order->delivery_date)) }}</span></p>
                <p class="text-sm font-bold text-gray-800">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('user.orders.show', $order->id) }}" class="block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
                Lacak / Detail
            </a>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500 text-sm">Anda belum pernah melakukan pemesanan.</div>
        @endforelse
    </div>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection