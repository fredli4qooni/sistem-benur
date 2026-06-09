<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->latest()->paginate(12);
        
        return view('user.catalog', compact('products'));
    }
}
