@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h1>
        <p class="text-gray-600 text-sm">Filter, lihat, dan ekspor data transaksi yang valid.</p>
    </div>
    <div class="flex space-x-2 w-full sm:w-auto">
        <a href="{{ route('admin.reports.export.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex-1 sm:flex-none justify-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition text-sm flex items-center">
            📄 Export Excel
        </a>
        <a href="{{ route('admin.reports.export.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex-1 sm:flex-none justify-center bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition text-sm flex items-center">
            📑 Export PDF
        </a>
    </div>
</div>

<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between md:items-center">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="w-full md:w-auto grid grid-cols-2 sm:flex sm:items-end gap-4">
        <div class="col-span-1">
            <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-sm">
        </div>
        <div class="col-span-1">
            <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-sm">
        </div>
        <div class="col-span-2 sm:col-span-1">
            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition text-sm sm:h-[38px] h-10">
                Filter
            </button>
        </div>
    </form>
    
    <div class="mt-5 md:mt-0 text-center md:text-right w-full md:w-auto border-t border-gray-100 md:border-0 pt-4 md:pt-0">
        <p class="text-xs text-gray-500">Total Pendapatan (Filter)</p>
        <p class="text-xl font-bold text-[#1A6B3C]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50/70 border-b border-gray-200 text-gray-500 font-semibold text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">ID Transaksi</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Total Pesanan</th>
                    <th class="px-6 py-4">Tanggal Pesanan</th>
                    <th class="px-6 py-4">Jadwal Kirim</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-[#1A6B3C]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-md
                            {{ $order->status === 'selesai' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                            {{ $order->status === 'diproses' || $order->status === 'dikirim' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                            {{ $order->status === 'pending' ? 'bg-orange-100 text-orange-700 border border-orange-200' : '' }}
                            {{ $order->status === 'dibatalkan' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="ph ph-file-text text-4xl text-gray-300 mb-3 block"></i>
                        <p class="text-sm">Belum ada data transaksi yang sesuai filter.</p>
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
            <div class="flex justify-between items-start">
                <div>
                    <span class="font-mono font-bold text-gray-900 text-sm">{{ $order->order_number }}</span>
                    <p class="text-[10px] text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
                </div>
                <span class="px-2.5 py-1 text-[10px] font-bold rounded-md shrink-0
                    {{ $order->status === 'selesai' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                    {{ $order->status === 'diproses' || $order->status === 'dikirim' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                    {{ $order->status === 'pending' ? 'bg-orange-100 text-orange-700 border border-orange-200' : '' }}
                    {{ $order->status === 'dibatalkan' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="flex justify-between items-end pt-1">
                <div>
                    <p class="font-bold text-gray-800 text-sm">{{ $order->user->name }}</p>
                    <p class="text-xs text-gray-500">Kirim: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold mb-0.5">Total</p>
                    <p class="font-bold text-[#1A6B3C] text-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500 text-sm">
            <i class="ph ph-file-text text-4xl text-gray-300 mb-3 block"></i>
            Belum ada data transaksi yang sesuai filter.
        </div>
        @endforelse
    </div>

    <div class="p-4 border-t">
        {{ $orders->appends(['start_date' => $startDate, 'end_date' => $endDate])->links() }}
    </div>
</div>
@endsection
