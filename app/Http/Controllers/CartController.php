<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    // Cart စာမျက်နှာ ပြသခြင်း
    public function index()
    {
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        $subtotal = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        return view('cart.index', compact('cart', 'subtotal')); // မိမိ view path အတိုင်း ညှိပါ
    }

    // Add To Cart Function
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        $size = $request->input('size', null);
        $color = $request->input('color', null);
        $quantity = (int) $request->input('quantity', 1);

        // Cart Key
        $cartKey = $id . ($size ? '-' . $size : '') . ($color ? '-' . $color : '');

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'size' => $size,   // null ဖြစ်ရင်လည်း key ပါသွားမည်
                'color' => $color,  // null ဖြစ်ရင်လည်း key ပါသွားမည်
                'stock' => $product->stock
            ];
        }

        Cookie::queue('shopping_cart', json_encode($cart), 43200);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Cart ထဲမှ အရေအတွက် ပြင်ခြင်း
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);
            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = (int) $request->quantity;
                Cookie::queue('shopping_cart', json_encode($cart), 43200);
            }
        }
        return response()->json(['status' => 'success']);
    }

    // Cart ထဲမှ Item ဖျက်ခြင်း
    public function removeCart(Request $request)
    {
        if ($request->id) {
            $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Cookie::queue('shopping_cart', json_encode($cart), 43200);
            }
        }
        return response()->json(['status' => 'success']);
    }
}