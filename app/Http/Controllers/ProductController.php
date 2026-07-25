<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function index()
    {
        $trendingProductIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(6)
            ->pluck('product_id');

        if ($trendingProductIds->isEmpty()) {
            $trendingProducts = Product::latest()->take(6)->get();
        } else {
            $trendingProducts = Product::whereIn('id', $trendingProductIds)
                ->orderByRaw("FIELD(id, " . implode(',', $trendingProductIds->toArray()) . ")")
                ->get();
        }

        $moreProducts = Product::inRandomOrder()->get();

        return view('dashboard', compact('trendingProducts', 'moreProducts'));
    }

    public function show($id)
    {
        $product = Product::with(['vendor', 'images'])->findOrFail($id);

        return view('product-detail', compact('product'));
    }
}
