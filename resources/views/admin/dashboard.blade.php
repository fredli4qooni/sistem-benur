@extends('layouts.admin')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Ringkasan Bisnis</h1>
        <p class="text-gray-500 text-sm mt-0.5">Pantau metrik utama, performa penjualan, dan status operasional tambak.</p>
    </div>
    <div class="flex items-center space-x-3 text-xs font-semibold text-gray-500 bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm self-start sm:self-auto">
        <span class="w-2 h-2 rounded-full bg-green-500"></span>
        <span>Sistem Sinkron</span>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-8">
    
    <div class="bg-white p-4 sm:p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row items-start justify-between">
        <div class="space-y-1.5 sm:space-y-2 order-2 sm:order-1 mt-2 sm:mt-0">
            <span class="block text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider leading-tight line-clamp-1">Pendapatan</span>
            <p class="text-base sm:text-2xl font-extrabold text-gray-900 leading-none">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <span class="hidden sm:inline-block text-xs text-green-700 font-medium bg-green-50 px-2 py-0.5 rounded-md">Semua waktu</span>
        </div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700 order-1 sm:order-2">
            <i class="ph ph-hand-coins text-base sm:text-xl text-[#1A6B3C]"></i>
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row items-start justify-between">
        <div class="space-y-1.5 sm:space-y-2 order-2 sm:order-1 mt-2 sm:mt-0">
            <span class="block text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider leading-tight line-clamp-1">Pelanggan</span>
            <p class="text-base sm:text-2xl font-extrabold text-gray-900 leading-none">{{ $activeCustomersCount }}</p>
            <span class="hidden sm:inline-block text-xs text-gray-500 font-medium bg-gray-100 px-2 py-0.5 rounded-md">Aktif</span>
        </div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700 order-1 sm:order-2">
            <i class="ph ph-users-three text-base sm:text-xl text-blue-600"></i>
        </div>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="bg-white p-4 sm:p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row items-start justify-between hover:border-amber-300 transition-colors group block">
        <div class="space-y-1.5 sm:space-y-2 order-2 sm:order-1 mt-2 sm:mt-0">
            <span class="block text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-amber-700 transition-colors leading-tight line-clamp-1">Validasi</span>
            <p class="text-base sm:text-2xl font-extrabold leading-none {{ $pendingOrdersCount > 0 ? 'text-amber-600' : 'text-gray-900' }}">{{ $pendingOrdersCount }} <span class="text-xs font-normal sm:font-extrabold">Pesanan</span></p>
            <span class="hidden sm:inline-block text-xs {{ $pendingOrdersCount > 0 ? 'bg-amber-50 text-amber-700' : 'bg-gray-100 text-gray-500' }} font-medium px-2 py-0.5 rounded-md">Pending</span>
        </div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700 group-hover:bg-amber-50 transition-colors order-1 sm:order-2">
            <i class="ph ph-clock-counter-clockwise text-base sm:text-xl text-amber-500"></i>
        </div>
    </a>

    <a href="{{ route('admin.products.index') }}" class="bg-white p-4 sm:p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row items-start justify-between hover:border-red-300 transition-colors group block">
        <div class="space-y-1.5 sm:space-y-2 order-2 sm:order-1 mt-2 sm:mt-0">
            <span class="block text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-red-700 transition-colors leading-tight line-clamp-1">Stok Menipis</span>
            <p class="text-base sm:text-2xl font-extrabold leading-none {{ $criticalStockCount > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $criticalStockCount }} <span class="text-xs font-normal sm:font-extrabold">Produk</span></p>
            <span class="hidden sm:inline-block text-xs {{ $criticalStockCount > 0 ? 'bg-red-50 text-red-700' : 'bg-gray-100 text-gray-500' }} font-medium px-2 py-0.5 rounded-md">Kritis</span>
        </div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700 group-hover:bg-red-50 transition-colors order-1 sm:order-2">
            <i class="ph ph-warning-circle text-base sm:text-xl text-red-500"></i>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
    
    <div class="bg-white p-4 sm:p-6 rounded-xl border border-gray-200 shadow-sm lg:col-span-2">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
            <div class="flex items-center space-x-2">
                <i class="ph ph-chart-line text-lg text-gray-400"></i>
                <h2 class="text-base font-bold text-gray-900">Performa Pendapatan</h2>
            </div>
            <span class="text-xs font-medium text-gray-500 bg-gray-50 border border-gray-100 px-2 py-1 rounded-md">6 Bulan Terakhir</span>
        </div>
        <div class="h-72">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center space-x-2 border-b border-gray-100 pb-4 mb-4">
                <i class="ph ph-shopping-bag text-lg text-gray-400"></i>
                <h2 class="text-base font-bold text-gray-900">Volume Transaksi</h2>
            </div>
            
            <div class="divide-y divide-gray-100">
                <div class="py-3.5 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Pesanan Masuk Hari Ini</span>
                    <span class="font-bold text-gray-900 text-sm bg-gray-50 border border-gray-200/60 px-2.5 py-0.5 rounded-md">{{ $ordersToday }}</span>
                </div>
                <div class="py-3.5 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Pesanan Minggu Ini</span>
                    <span class="font-bold text-gray-900 text-sm bg-gray-50 border border-gray-200/60 px-2.5 py-0.5 rounded-md">{{ $ordersThisWeek }}</span>
                </div>
                <div class="py-3.5 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Pesanan Bulan Ini</span>
                    <span class="font-bold text-gray-900 text-sm bg-gray-50 border border-gray-200/60 px-2.5 py-0.5 rounded-md">{{ $ordersThisMonth }}</span>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 mt-6">
            <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-center w-full bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold py-2.5 rounded-lg border border-gray-200 transition-colors">
                Kelola Semua Pesanan
                <i class="ph ph-arrow-right ml-1.5"></i>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Proteksi Linter VS Code
        const labels = JSON.parse('{!! json_encode($chartLabels) !!}');
        const dataTotals = JSON.parse('{!! json_encode($chartTotals) !!}');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: dataTotals,
                    borderColor: '#1A6B3C', // Hijau Primer Solid
                    borderWidth: 2,
                    pointBackgroundColor: '#1A6B3C',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 1.5,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: false, // Menghilangkan gradasi di bawah garis untuk gaya minimalis crisp
                    tension: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false }, // Hilangkan garis kotak vertikal
                        ticks: { font: { size: 11 }, color: '#9ca3af' }
                    },
                    y: {
                        grid: { color: '#f3f4f6' }, // Garis horizontal tipis abu-abu lembut
                        border: { dash: [4, 4] },   // Membuat garis pembantu putus-putus
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 },
                            color: '#9ca3af',
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
