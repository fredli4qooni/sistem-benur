<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = User::where('role', 'user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers', 'search'));
    }

    public function updateStatus(Request $request, User $customer)
    {
        if ($customer->role !== 'user') {
            abort(403, 'Tindakan tidak diizinkan.');
        }

        $validated = $request->validate([
            'status' => 'required|in:aktif,nonaktif,blokir'
        ]);

        $customer->update([
            'status' => $validated['status']
        ]);

        return back()->with('success', "Status akun pelanggan {$customer->name} berhasil diubah menjadi: " . strtoupper($validated['status']));
    }
}
