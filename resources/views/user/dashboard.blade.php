@extends('layouts.user')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 flex flex-col md:flex-row items-center justify-between">
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-[#1A6B3C] shrink-0 border border-green-100">
            <i class="ph-fill ph-hand-waving text-2xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Selamat datang, {{ Auth::user()->name }}!</h2>
            <p class="text-sm text-gray-500 mt-0.5">Pantau pergerakan harga pasar benur hari ini untuk keuntungan maksimal tambak Anda.</p>
        </div>
    </div>
    <a href="{{ route('user.catalog') }}" class="mt-6 md:mt-0 px-6 py-2.5 bg-[#1A6B3C] text-white text-sm font-bold rounded-lg hover:bg-[#2E8B57] transition-colors shadow-sm flex items-center shrink-0">
        Pesan Benur Sekarang
        <i class="ph ph-arrow-right ml-2 text-lg"></i>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 lg:col-span-2 flex flex-col">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
            <div class="flex items-center space-x-2">
                <i class="ph ph-chart-line-up text-lg text-gray-400"></i>
                <h2 class="text-base font-bold text-gray-900">Grafik Tren Harga Pasar</h2>
            </div>
            <span class="text-xs font-medium text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-md flex items-center">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span> Live Update
            </span>
        </div>
        <div class="flex-1 h-72 min-h-[18rem]">
            <canvas id="priceTrendChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col">
        <div class="flex items-center space-x-2 border-b border-gray-100 pb-4 mb-4">
            <i class="ph-fill ph-fire text-lg text-orange-500"></i>
            <h2 class="text-base font-bold text-gray-900">Paling Sering Dipesan</h2>
        </div>
        <div class="space-y-2 flex-1">
            @forelse($topProducts as $top)
            <a href="{{ route('user.checkout', $top->id) }}" class="flex items-center group p-2 -mx-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                @if($top->image)
                    <img src="{{ asset('storage/' . $top->image) }}" class="w-12 h-12 rounded-md object-cover border border-gray-200 shrink-0">
                @else
                    <div class="w-12 h-12 rounded-md bg-gray-100 border border-gray-200 flex flex-col items-center justify-center text-gray-400 shrink-0">
                        <i class="ph ph-image text-xl"></i>
                    </div>
                @endif
                <div class="ml-3 flex-1 overflow-hidden">
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-[#1A6B3C] transition-colors truncate">{{ $top->name }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5 font-medium">Rp {{ number_format($top->price, 0, ',', '.') }} / {{ $top->unit }}</p>
                </div>
                <i class="ph ph-caret-right text-gray-400 group-hover:text-[#1A6B3C] transition-colors ml-2"></i>
            </a>
            @empty
            <div class="h-full flex flex-col items-center justify-center text-gray-400 pb-4">
                <i class="ph ph-package text-3xl mb-2 text-gray-300"></i>
                <p class="text-sm">Belum ada data penjualan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-100 flex items-center space-x-2">
        <i class="ph ph-tag text-lg text-gray-400"></i>
        <h2 class="text-base font-bold text-gray-900">Daftar Harga Terkini</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50/70 border-b border-gray-200 text-gray-500 font-medium text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama Benur</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Status Stok</th>
                    <th class="px-6 py-4 text-right">Harga Satuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach($currentPrices as $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $item->category ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($item->stock > 0)
                            <span class="inline-flex items-center text-green-700 font-medium text-xs">
                                <i class="ph-fill ph-check-circle mr-1"></i> {{ $item->stock }} {{ ucfirst($item->unit) }}
                            </span>
                        @else
                            <span class="inline-flex items-center text-red-500 font-medium text-xs">
                                <i class="ph-fill ph-x-circle mr-1"></i> Habis
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-[#1A6B3C]">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('priceTrendChart').getContext('2d');
        
        const labels = JSON.parse('{!! json_encode($allDates) !!}');
        let datasets = JSON.parse('{!! json_encode($chartData) !!}');

        if(labels.length === 0) {
            labels.push('Belum ada data');
        }

        // Modifikasi dataset agar seragam dengan desain minimalis
        datasets = datasets.map(dataset => {
            dataset.borderWidth = 2;
            dataset.pointRadius = 4;
            dataset.pointHoverRadius = 6;
            dataset.pointBackgroundColor = dataset.borderColor;
            dataset.pointBorderColor = '#ffffff';
            dataset.pointBorderWidth = 1.5;
            dataset.tension = 0; // Garis lurus tegas tanpa lengkungan
            return dataset;
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { boxWidth: 12, usePointStyle: true, font: { size: 11 } }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#9ca3af' }
                    },
                    y: {
                        grid: { color: '#f3f4f6' },
                        border: { dash: [4, 4] },
                        beginAtZero: false,
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