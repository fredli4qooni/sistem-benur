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
    public function index()
    {
        // 1. Ambil 4 Produk Terpopuler (Berdasarkan jumlah terjual terbanyak)
        $topProducts = Product::where('status', 1)
            ->withSum('orderItems as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();

        // 2. Ambil Harga Terkini Semua Produk Aktif
        $currentPrices = Product::where('status', 1)->get();

        // 3. Siapkan Data untuk Grafik Tren Harga (Mengambil produk aktif saja)
        // Formatnya akan dikelompokkan per nama produk agar bisa jadi beberapa garis di Chart
        $products = Product::where('status', 1)->has('priceHistories')->with('priceHistories')->get();
        
        $chartData = [];
        $allDates = [];

        // Mengumpulkan semua tanggal unik dari perubahan harga untuk sumbu X (Bawah)
        $histories = PriceHistory::orderBy('recorded_at', 'asc')->get();
        foreach ($histories as $history) {
            $dateFormatted = \Carbon\Carbon::parse($history->recorded_at)->format('d M');
            if (!in_array($dateFormatted, $allDates)) {
                $allDates[] = $dateFormatted;
            }
        }

        // Tambahkan hari ini agar tren harga yang baru ditambah tetap jadi garis
        $todayFormatted = now()->format('d M');
        if (!in_array($todayFormatted, $allDates) && count($allDates) > 0) {
            $allDates[] = $todayFormatted;
        }

        // Palette warna yang lebih cerah & modern (Biru, Hijau, Ungu, Orange, Merah)
        $colors = ['#0ea5e9', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444'];
        $colorIndex = 0;

        // Menyusun data Y (Harga) per produk
        foreach ($products as $product) {
            $productPrices = [];
            $lastKnownPrice = null;

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

            // Hitung selisih harga (naik/turun)
            $priceDiff = 0;
            if ($product->priceHistories->count() > 1) {
                $sortedHistories = $product->priceHistories->sortBy('recorded_at')->values();
                $latest = $sortedHistories->last();
                $previous = $sortedHistories->get($sortedHistories->count() - 2);
                $priceDiff = $latest->price - $previous->price;
            }

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

        return view('user.dashboard', compact('topProducts', 'currentPrices', 'allDates', 'chartData'));
    }
}
