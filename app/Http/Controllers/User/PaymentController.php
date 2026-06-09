<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $transaction = $order->transaction;
        $settings = \App\Models\CompanySetting::pluck('value', 'key')->toArray();

        return view('user.payment', compact('order', 'transaction', 'settings'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $transaction = $order->transaction;

        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('payments', 'public');

            $transaction->update([
                'proof_image' => $path,
            ]);
        }

        return redirect()->route('user.catalog')->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu konfirmasi admin.');
    }
}
