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
            $dateFormatted = \Carbon\Carbon::parse($history->recorded_at)->format('d M Y');
            if (!in_array($dateFormatted, $allDates)) {
                $allDates[] = $dateFormatted;
            }
        }

        // Menyusun data Y (Harga) per produk
        foreach ($products as $product) {
            $productPrices = [];
            $lastKnownPrice = null;

            foreach ($allDates as $date) {
                // Cari apakah ada perubahan harga di tanggal ini
                $historyOnDate = $product->priceHistories->filter(function($item) use ($date) {
                    return \Carbon\Carbon::parse($item->recorded_at)->format('d M Y') === $date;
                })->last();

                if ($historyOnDate) {
                    $lastKnownPrice = $historyOnDate->price;
                }
                
                $productPrices[] = $lastKnownPrice;
            }

            // Generate warna random untuk setiap garis produk
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

            $chartData[] = [
                'label' => $product->name,
                'data' => $productPrices,
                'borderColor' => $color,
                'fill' => false,
                'tension' => 0.1
            ];
        }

        return view('user.dashboard', compact('topProducts', 'currentPrices', 'allDates', 'chartData'));
    }
}
