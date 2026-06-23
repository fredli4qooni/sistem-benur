<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PriceHistory;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', '7H'); // Default 7 Hari

        // Menentukan batas waktu awal berdasarkan filter
        $startDate = now();
        if ($filter === '7H') {
            $startDate = now()->subDays(6);
        } elseif ($filter === '1B') {
            $startDate = now()->subMonth();
        } elseif ($filter === '3B') {
            $startDate = now()->subMonths(3);
        } else {
            $filter = '7H';
            $startDate = now()->subDays(6);
        }

        // 1. Ambil 4 Produk Terpopuler (Berdasarkan jumlah terjual terbanyak)
        $topProducts = Product::where('status', 1)
            ->withSum('orderItems as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();

        // 2. Ambil Harga Terkini Semua Produk Aktif
        $currentPrices = Product::where('status', 1)->get();

        // 3. Siapkan Data untuk Grafik Tren Harga (Mengambil produk aktif saja)
        $products = Product::where('status', 1)->has('priceHistories')->with('priceHistories')->get();
        
        $chartData = [];
        $allDates = [];

        // Masukkan tanggal awal ke sumbu X agar chart membentang dari titik mulai yang tepat
        $allDates[] = $startDate->format('d M');

        // Mengumpulkan semua tanggal unik dari perubahan harga dalam rentang waktu filter
        $histories = PriceHistory::where('recorded_at', '>=', $startDate->startOfDay())
                        ->orderBy('recorded_at', 'asc')->get();

        foreach ($histories as $history) {
            $dateFormatted = \Carbon\Carbon::parse($history->recorded_at)->format('d M');
            if (!in_array($dateFormatted, $allDates)) {
                $allDates[] = $dateFormatted;
            }
        }

        // Tambahkan hari ini agar tren harga yang baru ditambah tetap jadi garis
        $todayFormatted = now()->format('d M');
        if (!in_array($todayFormatted, $allDates)) {
            $allDates[] = $todayFormatted;
        }

        // Palette warna yang lebih cerah & modern (Biru, Hijau, Ungu, Orange, Merah)
        $colors = ['#0ea5e9', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444'];
        $colorIndex = 0;

        // Menyusun data Y (Harga) per produk
        foreach ($products as $product) {
            $productPrices = [];
            
            // Cari harga baseline: harga terakhir yang tercatat sebelum atau pada tanggal awal filter
            $baselineHistory = $product->priceHistories()
                                ->where('recorded_at', '<=', $startDate->endOfDay())
                                ->orderBy('recorded_at', 'desc')
                                ->first();

            // Jika tidak ada riwayat sebelum filter, ambil riwayat pertama kalinya
            if (!$baselineHistory) {
                $baselineHistory = $product->priceHistories->sortBy('recorded_at')->first();
            }

            $lastKnownPrice = $baselineHistory ? $baselineHistory->price : 0;
            $baselinePrice = $lastKnownPrice;

            foreach ($allDates as $date) {
                // Cari apakah ada perubahan harga di tanggal ini
                $historyOnDate = $product->priceHistories->filter(function($item) use ($date) {
                    return \Carbon\Carbon::parse($item->recorded_at)->format('d M') === $date;
                })->last();

                if ($historyOnDate) {
                    $lastKnownPrice = $historyOnDate->price;
                }
                
                $productPrices[] = $lastKnownPrice;
            }

            // Hitung selisih harga (naik/turun) berdasarkan baseline di awal rentang filter
            $currentPrice = $product->price;
            $priceDiff = $currentPrice - $baselinePrice;

            $color = $colors[$colorIndex % count($colors)];
            $colorIndex++;

            $chartData[] = [
                'label' => $product->name,
                'data' => $productPrices,
                'borderColor' => $color,
                'backgroundColor' => $color, // Disimpan untuk gradient di JS
                'currentPrice' => $product->price,
                'priceDiff' => $priceDiff
            ];
        }

        return view('user.dashboard', compact('topProducts', 'currentPrices', 'allDates', 'chartData', 'filter'));
    }
}
