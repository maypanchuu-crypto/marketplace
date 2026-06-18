<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    //
    public function index()
    {        
        $trendingProducts = Product::withCount([
            'orderItems' => function ($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            }
        ])
            ->orderByDesc('order_items_count')
            ->take(4) 
            ->get();

        $moreProducts = Product::inRandomOrder()->get();

        return view('dashboard', compact('trendingProducts', 'moreProducts'));
    }

    public function show($id)
    {
        $product = Product::with(['vendor', 'images'])->findOrFail($id);

        return view('product-detail', compact('product'));
    }
}
