@extends('layouts.admin')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Ringkasan Bisnis</h1>
        <p class="text-gray-500 text-sm mt-0.5">Pantau metrik utama, performa penjualan, dan status operasional tambak.</p>
    </div>
    <div class="flex items-center space-x-3 text-xs font-semibold text-gray-500 bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm">
        <span class="w-2 h-2 rounded-full bg-green-500"></span>
        <span>Sistem Sinkron</span>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-start justify-between">
        <div class="space-y-2">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</span>
            <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <span class="text-xs text-green-700 font-medium bg-green-50 px-2 py-0.5 rounded-md">Semua waktu</span>
        </div>
        <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700">
            <i class="ph ph-hand-coins text-xl text-[#1A6B3C]"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-start justify-between">
        <div class="space-y-2">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan Aktif</span>
            <p class="text-2xl font-extrabold text-gray-900">{{ $activeCustomersCount }}</p>
            <span class="text-xs text-gray-500 font-medium bg-gray-100 px-2 py-0.5 rounded-md">Pembudidaya</span>
        </div>
        <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700">
            <i class="ph ph-users-three text-xl text-blue-600"></i>
        </div>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-start justify-between hover:border-amber-300 transition-colors group block">
        <div class="space-y-2">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-amber-700 transition-colors">Pending Validasi</span>
            <p class="text-2xl font-extrabold {{ $pendingOrdersCount > 0 ? 'text-amber-600' : 'text-gray-900' }}">{{ $pendingOrdersCount }} Orders</p>
            <span class="text-xs {{ $pendingOrdersCount > 0 ? 'bg-amber-50 text-amber-700' : 'bg-gray-100 text-gray-500' }} font-medium px-2 py-0.5 rounded-md">Butuh konfirmasi</span>
        </div>
        <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700 group-hover:bg-amber-50 transition-colors">
            <i class="ph ph-clock-counter-clockwise text-xl text-amber-500"></i>
        </div>
    </a>

    <a href="{{ route('admin.products.index') }}" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-start justify-between hover:border-red-300 transition-colors group block">
        <div class="space-y-2">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-red-700 transition-colors">Stok Menipis</span>
            <p class="text-2xl font-extrabold {{ $criticalStockCount > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $criticalStockCount }} Produk</p>
            <span class="text-xs {{ $criticalStockCount > 0 ? 'bg-red-50 text-red-700' : 'bg-gray-100 text-gray-500' }} font-medium px-2 py-0.5 rounded-md">Di bawah batas</span>
        </div>
        <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700 group-hover:bg-red-50 transition-colors">
            <i class="ph ph-warning-circle text-xl text-red-500"></i>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm lg:col-span-2">
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

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
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