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
}
