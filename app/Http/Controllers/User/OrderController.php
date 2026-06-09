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

    public function create(Product $product)
    {
        if (!$product->status || $product->stock <= 0) {
            return redirect()->route('user.catalog')->with('error', 'Maaf, produk tidak tersedia.');
        }

        return view('user.checkout', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_address' => 'required|string',
            'payment_method' => 'required|in:qris,transfer',
            'notes' => 'nullable|string'
        ]);

        $dayOfWeek = date('N', strtotime($request->delivery_date));
        if ($dayOfWeek != 1 && $dayOfWeek != 4) {
            return back()->withErrors(['delivery_date' => 'Pengiriman hanya tersedia pada hari Senin dan Kamis.'])->withInput();
        }

        try {
            DB::beginTransaction();

            $totalAmount = $product->price * $request->quantity;

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_date' => $request->delivery_date,
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'subtotal' => $totalAmount,
            ]);

            Transaction::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'method' => $request->payment_method,
                'status' => 'menunggu',
            ]);

            DB::commit();

            return redirect()->route('user.payment', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')->withInput();
        }
    }
}
