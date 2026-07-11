<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('transaction')
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        $order->load(['transaction', 'items.product']);

        return view('user.orders.show', compact('order'));
    }

    public function create()
    {
        $carts = Auth::user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('user.catalog')->with('error', 'Keranjang Anda kosong.');
        }

        // Cek ketersediaan stok
        foreach ($carts as $cart) {
            if (!$cart->product->status || $cart->product->stock < $cart->quantity) {
                return redirect()->route('user.cart.index')->with('error', 'Produk ' . $cart->product->name . ' tidak tersedia atau stok kurang.');
            }
        }

        $totalAmount = $carts->sum(function($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('user.checkout', compact('carts', 'totalAmount'));
    }

    public function store(Request $request)
    {
        $carts = Auth::user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('user.catalog')->with('error', 'Keranjang Anda kosong.');
        }

        $request->validate([
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_address' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:midtrans,tunai'
        ]);

        $dayOfWeek = date('N', strtotime($request->delivery_date));
        if ($dayOfWeek != 1 && $dayOfWeek != 4) {
            return back()->withErrors(['delivery_date' => 'Pengiriman hanya tersedia pada hari Senin dan Kamis.'])->withInput();
        }

        try {
            DB::beginTransaction();

            // Hitung total dan persiapkan item_details untuk Midtrans
            $totalAmount = 0;
            $itemDetails = [];

            foreach ($carts as $cart) {
                if (!$cart->product->status || $cart->product->stock < $cart->quantity) {
                    throw new \Exception('Produk ' . $cart->product->name . ' tidak tersedia dalam jumlah yang diminta.');
                }
                $subtotal = $cart->product->price * $cart->quantity;
                $totalAmount += $subtotal;

                $itemDetails[] = [
                    'id' => $cart->product->id,
                    'price' => $cart->product->price,
                    'quantity' => $cart->quantity,
                    'name' => mb_substr($cart->product->name, 0, 50),
                ];
            }

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_date' => $request->delivery_date,
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
            ]);

            // Buat OrderItems dan kurangi stok (opsional, tergantung kebijakan, di sini kita biarkan stok utuh sampai dikonfirmasi atau kita bisa kurangi sekarang)
            // Sebaiknya tidak mengurangi stok saat pending, tapi sudah terlanjur di struktur lama stok dikurangi saat dikonfirmasi admin.
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product->id,
                    'quantity' => $cart->quantity,
                    'unit_price' => $cart->product->price,
                    'subtotal' => $cart->product->price * $cart->quantity,
                ]);
            }

            $isTunai = $request->payment_method === 'tunai';

            $transaction = Transaction::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'method' => $isTunai ? 'tunai' : 'midtrans',
                'status' => 'menunggu',
            ]);

            if (!$isTunai) {
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = config('midtrans.is_sanitized');
                Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_number,
                        'gross_amount' => $totalAmount,
                    ],
                    'customer_details' => [
                        'first_name' => mb_substr(Auth::user()->name, 0, 50),
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone ?? '',
                    ],
                    'item_details' => $itemDetails
                ];

                $snapToken = Snap::getSnapToken($params);
                $transaction->update(['snap_token' => $snapToken]);
            }

            // Hapus isi keranjang
            Auth::user()->carts()->delete();

            DB::commit();

            if ($isTunai) {
                return redirect()->route('user.orders.show', $order->id)->with('success', 'Pesanan COD berhasil dibuat! Menunggu konfirmasi dari Admin.');
            }

            return redirect()->route('user.payment', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan yang belum dibayar yang dapat dibatalkan langsung.');
        }

        try {
            DB::beginTransaction();

            $order->update(['status' => 'dibatalkan']);
            
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

            // Cancel on Midtrans
            try {
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Transaction::cancel($order->order_number);
            } catch (\Exception $e) {
                // Ignore midtrans error if already expired/cancelled
            }

            DB::commit();
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

    public function requestCancel(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        if (!in_array($order->status, ['dikonfirmasi', 'disiapkan'])) {
            return back()->with('error', 'Pesanan ini tidak dapat diajukan pembatalan saat ini.');
        }

        if ($order->is_cancellation_requested) {
            return back()->with('error', 'Anda sudah mengajukan pembatalan untuk pesanan ini.');
        }

        $request->validate([
            'cancel_reason' => 'required|string|max:500'
        ]);

        $order->update([
            'is_cancellation_requested' => true,
            'cancel_reason' => $request->cancel_reason
        ]);

        return back()->with('success', 'Pengajuan pembatalan telah dikirim ke Admin untuk ditinjau.');
    }

    public function markAsCompleted(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        if ($order->status !== 'dikirim') {
            return back()->with('error', 'Pesanan ini belum dalam status pengiriman atau sudah diselesaikan.');
        }

        $order->update(['status' => 'selesai']);

        return back()->with('success', 'Terima kasih telah melakukan konfirmasi! Pesanan Anda telah selesai.');
    }
}
