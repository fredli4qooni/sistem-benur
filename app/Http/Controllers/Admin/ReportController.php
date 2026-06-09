<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::with(['user', 'items.product'])
            ->whereIn('status', ['dikonfirmasi', 'disiapkan', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->paginate(20);
            
        $totalRevenue = Order::whereIn('status', ['dikonfirmasi', 'disiapkan', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total_amount');

        return view('admin.reports.index', compact('orders', 'startDate', 'endDate', 'totalRevenue'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::with(['user', 'items.product'])
            ->whereIn('status', ['dikonfirmasi', 'disiapkan', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.reports.table', compact('orders', 'startDate', 'endDate'));
        
        return $pdf->download('Laporan_Penjualan_Benur_' . $startDate . '_sd_' . $endDate . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        return Excel::download(new SalesExport($startDate, $endDate), 'Laporan_Penjualan_Benur_' . $startDate . '_sd_' . $endDate . '.xlsx');
    }
}
