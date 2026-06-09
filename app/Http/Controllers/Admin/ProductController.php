<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PriceHistory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Server-Side
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|in:ekor,boks',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // 2. Proses Upload Foto (jika ada)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan ke Database (PASTIKAN HANYA ADA SATU BARIS INI)
        $product = Product::create($validated);

        // 4. Catat harga awal ke riwayat harga
        \App\Models\PriceHistory::create([
            'product_id' => $product->id,
            'price' => $product->price,
            'recorded_at' => now(),
        ]);

        // 5. Redirect dengan pesan sukses
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk benur berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|in:ekor,boks',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $oldPrice = $product->price;
        $product->update($validated);

        if ($oldPrice != $product->price) {
            PriceHistory::create([
                'product_id' => $product->id,
                'price' => $product->price,
                'recorded_at' => now(),
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Data produk benur berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk benur berhasil dihapus dari sistem!');
    }
}
