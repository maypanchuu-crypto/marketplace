<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Intervention\Image\Laravel\Facades\Image;

class VendorProductController extends Controller
{

    public function index()
    {
        // Fetch only products uploaded by the logged-in Vendor
        $products = \App\Models\Product::where('user_id', auth()->id())->get();

        // Pass the products to vendor dashboard
        return view('vendor.dashboard', compact('products'));
    }


    public function create()
    {
        return view('vendor.create-product');
    }

    // 
    public function store(Request $request)
    {
        // Simplified validation to easily track errors
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|max:5120', // Temporarily removed mimes check to avoid bugs
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Move file directly to public/uploads/products
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        // Insert to Database
        \App\Models\Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'user_id' => auth()->id(), // Ensure you are logged in as Vendor
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Product created successfully!');
    }
}
