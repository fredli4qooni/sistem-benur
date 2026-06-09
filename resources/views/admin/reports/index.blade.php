@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h1>
        <p class="text-gray-600 text-sm">Filter, lihat, dan ekspor data transaksi yang valid.</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('admin.reports.export.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition text-sm flex items-center">
            📄 Export Excel
        </a>
        <a href="{{ route('admin.reports.export.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition text-sm flex items-center">
            📑 Export PDF
        </a>
    </div>
</div>

<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-center">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-end space-x-4 w-full md:w-auto">
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 rounded focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-sm">
        </div>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition text-sm h-[38px]">
            Filter
        </button>
    </form>
    
    <div class="mt-4 md:mt-0 text-right">
        <p class="text-xs text-gray-500">Total Pendapatan (Filter)</p>
        <p class="text-xl font-bold text-[#1A6B3C]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full text-left text-sm whitespace-nowrap">
        <thead class="bg-gray-50 text-gray-500 font-medium">
            <tr>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3">No. Order</th>
                <th class="px-6 py-3">Pelanggan</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3 text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody class="divide-y text-gray-700">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-6 py-3 font-mono">{{ $order->order_number }}</td>
                <td class="px-6 py-3">{{ $order->user->name }}</td>
                <td class="px-6 py-3 uppercase text-xs">{{ $order->status }}</td>
                <td class="px-6 py-3 text-right font-bold text-[#1A6B3C]">{{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada transaksi di rentang tanggal ini.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $orders->appends(['start_date' => $startDate, 'end_date' => $endDate])->links() }}
    </div>
</div>
@endsection