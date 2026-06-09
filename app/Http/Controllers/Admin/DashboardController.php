<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        // 1. Statistik Pesanan
        $ordersToday = Order::whereDate('created_at', $today)->count();
        $ordersThisWeek = Order::where('created_at', '>=', $startOfWeek)->count();
        $ordersThisMonth = Order::where('created_at', '>=', $startOfMonth)->count();

        // 2. Pesanan Pending yang perlu tindakan validasi
        $pendingOrdersCount = Order::where('status', 'pending')->count();

        // 3. Pelanggan Aktif (Role user & status aktif)
        $activeCustomersCount = User::where('role', 'user')
            ->where('status', 'aktif')
            ->count();

        // 4. Stok Benur Kritis (Stok kurang dari atau sama dengan batas minimal)
        $criticalStockCount = Product::whereRaw('stock <= min_stock')->count();

        // 5. Total Pendapatan (Pesanan yang sudah dikonfirmasi/proses/selesai)
        $totalRevenue = Order::whereIn('status', ['dikonfirmasi', 'disiapkan', 'dikirim', 'selesai'])
            ->sum('total_amount');

        // 6. Data untuk Grafik Bulanan (Pendapatan 6 Bulan Terakhir)
        $revenueData = Order::whereIn('status', ['dikonfirmasi', 'disiapkan', 'dikirim', 'selesai'])
            ->select(
                DB::raw('SUM(total_amount) as total'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month")
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            // UBAH BARIS INI: Menggunakan MIN() agar lolos validasi Strict Mode MySQL
            ->orderByRaw('MIN(created_at) ASC')
            ->get();

        $chartLabels = $revenueData->pluck('month')->toArray();
        $chartTotals = $revenueData->pluck('total')->toArray();

        // Jika data grafik kosong, beri nilai default agar grafik tidak error
        if (empty($chartLabels)) {
            $chartLabels = [Carbon::now()->format('b Y')];
            $chartTotals = [0];
        }

        return view('admin.dashboard', compact(
            'ordersToday',
            'ordersThisWeek',
            'ordersThisMonth',
            'pendingOrdersCount',
            'activeCustomersCount',
            'criticalStockCount',
            'totalRevenue',
            'chartLabels',
            'chartTotals'
        ));
    }
}
