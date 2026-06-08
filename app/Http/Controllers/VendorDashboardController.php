<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class VendorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();

        $allProducts = Product::where('user_id', $vendor->id)->get();
        $totalProducts = $allProducts->count();
        $totalOrders = 0;
        $totalEarnings = 0;

        $query = Product::where('user_id', $vendor->id);

        $stock_status = $request->input('stock_status');

        if ($stock_status != '') {
            if ($stock_status === 'in_stock') {
                $query->where('stock', '>', 5);
            } elseif ($stock_status === 'low_stock') {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            } elseif ($stock_status === 'out_of_stock') {
                $query->where('stock', '=', 0);
            }
        }

        $products = $query->latest()->get();

        // $products = $query->latest()->paginate(10); 

        return view('vendor.dashboard', compact('vendor', 'totalProducts', 'totalOrders', 'totalEarnings', 'products', 'stock_status'));
    }


    // to show the form for creating a new product
    public function createProduct()
    {
        $vendor = Auth::user();
        return view('vendor.create-product', compact('vendor'));
    }


    // store the new product in the database
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|min:5',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
        ]);

        $productData = [
            'user_id' => Auth::id(), // current vendor ID
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        // store product image at public/products 
        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $productData['image'] = $path;
        }

        Product::create($productData);

        return redirect()->route('vendor.dashboard')->with('success', 'Product uploaded successfully!');
    }


    // edit product data and show the form with existing data
    public function edit($id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($product);
    }


    // update product data in the database
    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'price', 'stock', 'description']);

        // store new image if uploaded and delete the old one from storage
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        // find the product for the current vendor
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        // delete the product image from storage if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // delete the product from the database
        $product->delete();

        // show success message
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}
