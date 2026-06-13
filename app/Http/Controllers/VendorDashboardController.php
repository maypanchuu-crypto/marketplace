<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;

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
    // store the new product in the database
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|min:5',
            'sizes' => 'nullable|string', // 💡 Size အတွက် Validation ထည့်မယ်
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_colors' => 'nullable|array',
        ]);

        $coverImagePath = null;
        if ($request->hasFile('images')) {
            $coverImagePath = $request->file('images')[0]->store('products', 'public');
        }

        // 💡 ဝင်လာတဲ့ Sizes စာသားကို Comma ခံပြီး ဖြတ်ပြီး Array ပြောင်းမည့် Logic
        $sizesArray = null;
        if ($request->filled('sizes')) {
            $sizesArray = array_map('trim', explode(',', strtolower($request->sizes)));
        }

        $colorsArray = [];
        if ($request->has('image_colors')) {
            foreach ($request->image_colors as $color) {
                if (!empty($color)) {
                    $colorsArray[] = strtolower(trim($color));
                }
            }
        }
        $colorsArray = array_unique($colorsArray);

        // Product ကို Database ထဲ သိမ်းခြင်း
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $coverImagePath,
            'sizes' => $sizesArray ? json_encode($sizesArray) : null, // 💡 JSON စစ်စစ်အဖြစ် ဝင်သွားပါပြီ
            'colors' => !empty($colorsArray) ? json_encode(array_values($colorsArray)) : null,
        ]);

        // ၅။ ပုံအားလုံးကို `product_images` table ထဲ တစ်ပုံချင်းစီ သွားသိမ်းပြီး ၎င်းနဲ့ဆိုင်တဲ့ အရောင်ကို တွဲပေးမယ်
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                if ($file->isValid()) {
                    $path = $file->store('products/gallery', 'public');

                    // ရိုက်ထည့်လိုက်တဲ့ အရောင်တွေထဲက လက်ရှိ ပုံရဲ့ Index နဲ့ ကိုက်ညီတဲ့ အရောင်ကို ယူမယ်
                    $associatedColor = isset($request->image_colors[$index]) ? strtolower(trim($request->image_colors[$index])) : null;

                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'color' => !empty($associatedColor) ? $associatedColor : null,
                    ]);
                }
            }
        }

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
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string', // ဒါလေးပါ ထည့်စစ်ပေးပါ
        ]);

        $data = $request->only(['name', 'price', 'stock', 'description']);

        // မင်းရေးထားတဲ့ ကုတ်အတိုင်း Comma (,) ခံပြီး ရိုက်လိုက်တဲ့စာတွေကို Array ပြောင်းတာပါ
        $sizesArray = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : null;
        $colorsArray = $request->colors ? array_map('trim', explode(',', $request->colors)) : null;

        $data['sizes'] = $sizesArray ? json_encode($sizesArray) : null;
        $data['colors'] = $colorsArray ? json_encode($colorsArray) : null;

        if ($request->hasFile('image')) {
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
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
