<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to process notification'], 400);
        }

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transaction = $order->transaction;

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->update(['status' => 'menunggu']);
            } else if ($fraudStatus == 'accept') {
                $transaction->update(['status' => 'terkonfirmasi', 'confirmed_at' => now()]);
                $order->update(['status' => 'dikonfirmasi']);
                
                // Potong stok karena sudah dibayar
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->decrement('stock', $item->quantity);
                    }
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->update(['status' => 'terkonfirmasi', 'confirmed_at' => now()]);
            $order->update(['status' => 'dikonfirmasi']);
            
            // Potong stok karena sudah dibayar
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $transaction->update(['status' => 'gagal']);
            $order->update(['status' => 'dibatalkan']);
            
            // Note: If expire, return stock is NOT needed if we haven't deducted it. 
            // We only deduct on 'capture' or 'settlement' above.
        } else if ($transactionStatus == 'pending') {
            $transaction->update(['status' => 'menunggu']);
        }

        return response()->json(['message' => 'Callback handled successfully']);
    }
}
