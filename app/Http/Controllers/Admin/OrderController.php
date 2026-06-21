<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'transaction'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'transaction', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan ini sudah diproses sebelumnya.');
        }

        try {
            DB::beginTransaction();

            $order->update(['status' => 'dikonfirmasi']);

            if ($order->transaction) {
                $order->transaction->update([
                    'status' => 'terkonfirmasi',
                    'confirmed_at' => now()
                ]);
            }

            foreach ($order->items as $item) {
                $product = $item->product;

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Gagal konfirmasi! Stok untuk {$product->name} tidak mencukupi.");
                }

                $product->decrement('stock', $item->quantity);
            }

            DB::commit();
            return redirect()->route('admin.orders.show', $order->id)->with('success', 'Pesanan berhasil dikonfirmasi dan stok otomatis dipotong!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,disiapkan,dikirim,selesai,dibatalkan'
        ]);

        if (in_array($order->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Status pesanan yang sudah Selesai atau Dibatalkan tidak dapat diubah lagi.');
        }

        $order->update([
            'status' => $validated['status']
        ]);

        return back()->with('success', 'Status pengiriman pesanan berhasil diperbarui menjadi: ' . strtoupper($validated['status']));
    }

    public function cancel(Order $order)
    {
        if (in_array($order->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Pesanan yang sudah selesai atau dibatalkan tidak dapat dibatalkan lagi.');
        }

        try {
            DB::beginTransaction();

            $previousStatus = $order->status;
            $order->update([
                'status' => 'dibatalkan',
                'is_cancellation_requested' => false 
            ]);

            // Jika pesanan sudah dibayar (status sebelumnya dikonfirmasi, disiapkan, dikirim),
            // biarkan status transaksi tetap terkonfirmasi untuk proses refund manual.
            // Jika belum dibayar (pending), gagal-kan transaksi.
            if ($previousStatus === 'pending') {
                if ($order->transaction) {
                    $order->transaction->update(['status' => 'gagal']);
                }
                
                // Return stock
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }

                // Coba batalkan di Midtrans (abaikan jika gagal)
                try {
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('midtrans.is_production');
                    \Midtrans\Transaction::cancel($order->order_number);
                } catch (\Exception $e) {}
            } else {
                // Return stock since it was deducted when confirmed
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }

            DB::commit();
            
            if ($previousStatus !== 'pending') {
                return back()->with('success', 'Pesanan berhasil dibatalkan. Stok telah dikembalikan. HARAP LAKUKAN REFUND MANUAl!');
            }
            return back()->with('success', 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

    public function markAsRefunded(Order $order)
    {
        if ($order->status !== 'dibatalkan') {
            return back()->with('error', 'Pesanan ini tidak dalam status dibatalkan.');
        }

        if (!$order->transaction || $order->transaction->status !== 'terkonfirmasi') {
            return back()->with('error', 'Transaksi ini tidak membutuhkan refund atau sudah dikembalikan.');
        }

        $order->transaction->update([
            'status' => 'dikembalikan'
        ]);

        return back()->with('success', 'Dana pesanan berhasil ditandai sebagai telah dikembalikan (Refunded).');
    }
}
