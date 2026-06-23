@extends('layouts.user')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 mb-6 md:mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-0">
    <div class="flex items-center space-x-3 md:space-x-4">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-green-50 rounded-full flex items-center justify-center text-[#1A6B3C] shrink-0 border border-green-100">
            <i class="ph-fill ph-hand-waving text-xl md:text-2xl"></i>
        </div>
        <div>
            <h2 class="text-lg md:text-xl font-extrabold text-gray-900 tracking-tight leading-tight">Selamat datang, {{ Auth::user()->name }}!</h2>
            <p class="text-xs md:text-sm text-gray-500 mt-0.5">Pantau pergerakan harga pasar benur hari ini.</p>
        </div>
    </div>
    <a href="{{ route('user.catalog') }}" class="w-full md:w-auto justify-center px-6 py-2.5 bg-[#1A6B3C] text-white text-sm font-bold rounded-lg hover:bg-[#2E8B57] transition-colors shadow-sm flex items-center shrink-0">
        Pesan Benur Sekarang
        <i class="ph ph-arrow-right ml-2 text-lg"></i>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200 lg:col-span-2 flex flex-col">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 md:pb-4 mb-3 md:mb-4">
            <div class="flex items-center space-x-2">
                <i class="ph ph-chart-line-up text-lg text-gray-400"></i>
                <h2 class="text-sm md:text-base font-bold text-gray-900">Grafik Tren Harga</h2>
            </div>
            <div class="flex items-center space-x-2">
                <div class="flex items-center bg-gray-50 border border-gray-100 rounded-lg p-0.5 hidden sm:flex">
                    <button class="px-2.5 py-1 text-xs font-bold bg-white text-gray-800 shadow-sm rounded-md">7H</button>
                    <button class="px-2.5 py-1 text-xs font-medium text-gray-500 hover:text-gray-700">1B</button>
                    <button class="px-2.5 py-1 text-xs font-medium text-gray-500 hover:text-gray-700">3B</button>
                </div>
                <span class="text-[10px] md:text-xs font-medium text-green-700 bg-green-50 border border-green-100 px-2 py-1 rounded-md flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span> Live
                </span>
            </div>
        </div>

        <!-- Custom HTML Legend -->
        <div class="flex flex-wrap gap-3 mb-4">
            @foreach($chartData as $dataset)
                <div class="flex items-center px-3 py-1.5 rounded-full border text-xs font-semibold" style="border-color: {{ $dataset['borderColor'] }}30; background-color: {{ $dataset['borderColor'] }}0A;">
                    <span class="w-2.5 h-2.5 rounded-full mr-2" style="background-color: {{ $dataset['borderColor'] }};"></span>
                    <span class="text-gray-700 mr-2">{{ $dataset['label'] }}</span>
                    <span style="color: {{ $dataset['borderColor'] }};">Rp {{ number_format($dataset['currentPrice'], 0, ',', '.') }}</span>
                    
                    @if($dataset['priceDiff'] < 0)
                        <span class="ml-2 text-red-500 font-bold"><i class="ph-bold ph-caret-down text-[10px]"></i> Rp {{ number_format(abs($dataset['priceDiff']), 0, ',', '.') }}</span>
                    @elseif($dataset['priceDiff'] > 0)
                        <span class="ml-2 text-green-500 font-bold"><i class="ph-bold ph-caret-up text-[10px]"></i> Rp {{ number_format($dataset['priceDiff'], 0, ',', '.') }}</span>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex-1 h-56 md:h-72 min-h-[14rem] md:min-h-[18rem]">
            <canvas id="priceTrendChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col">
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
    <div class="p-4 md:p-6 border-b border-gray-100 flex items-center space-x-2">
        <i class="ph ph-tag text-lg text-gray-400"></i>
        <h2 class="text-sm md:text-base font-bold text-gray-900">Daftar Harga Terkini</h2>
    </div>

    <!-- Mobile View (Card List) -->
    <div class="block md:hidden divide-y divide-gray-100">
        @foreach($currentPrices as $item)
        <div class="p-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ $item->name }}</h3>
                    <p class="text-[10px] text-gray-500 mt-0.5">{{ $item->category ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-extrabold text-[#1A6B3C]">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-gray-400">per {{ $item->unit }}</p>
                </div>
            </div>
            <div class="mt-2">
                @if($item->stock > 0)
                    <span class="inline-flex items-center text-green-700 font-medium text-[10px] bg-green-50 px-2 py-0.5 rounded border border-green-100">
                        <i class="ph-fill ph-check-circle mr-1"></i> Stok: {{ $item->stock }}
                    </span>
                @else
                    <span class="inline-flex items-center text-red-600 font-medium text-[10px] bg-red-50 px-2 py-0.5 rounded border border-red-100">
                        <i class="ph-fill ph-x-circle mr-1"></i> Stok Habis
                    </span>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Desktop View (Table) -->
    <div class="hidden md:block overflow-x-auto">
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
            dataset.borderWidth = 2.5;
            
            // Buat gradient untuk area di bawah garis
            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, dataset.backgroundColor + '33'); // 20% opacity
            gradient.addColorStop(1, dataset.backgroundColor + '00'); // 0% opacity
            
            dataset.backgroundColor = gradient;
            dataset.fill = true;
            dataset.tension = 0.4; // Melengkung halus seperti referensi

            // Titik hanya tampil saat di-hover atau di ujung akhir
            dataset.pointRadius = function(context) {
                const index = context.dataIndex;
                const count = context.dataset.data.length;
                return index === count - 1 ? 5 : 0; 
            };
            dataset.pointHoverRadius = 6;
            dataset.pointBackgroundColor = '#ffffff';
            dataset.pointBorderColor = dataset.borderColor;
            dataset.pointBorderWidth = 2.5;
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
                        display: false // Sembunyikan legenda bawaan karena kita pakai HTML kustom
                    },
                    tooltip: {
                        backgroundColor: '#ffffff',
                        titleColor: '#1f2937',
                        bodyColor: '#4b5563',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 4,
                        usePointStyle: true,
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
                        border: { dash: [4, 4], display: false },
                        beginAtZero: false,
                        ticks: {
                            font: { size: 11 },
                            color: '#9ca3af',
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'rb'; // Format 'Rp 26rb'
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
