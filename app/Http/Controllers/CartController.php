<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        // Subtotal ကို တွက်ချက်ခြင်း
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'subtotal'));
    }

    // ၂။ Cart ထဲသို့ ပစ္စည်းထည့်ရန်
    public function addToCart(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);

        $quantity = $request->input('quantity', 1);
        $size = $request->input('size', null);
        $color = $request->input('color', null);

        // 💡 အဓိကအချက်- Product ID, Size, Color တို့ကို ပေါင်းပြီး သီးသန့် Key တစ်ခု ဆောက်ခြင်း
        // ဥပမာ- "5-m-red" သို့မဟုတ် "5-xl-black"
        $cartKey = $id;
        if ($size)
            $cartKey .= '-' . strtolower($size);
        if ($color)
            $cartKey .= '-' . strtolower($color);

        $cart = session()->get('cart', []);

        // 💡 ရွေးချယ်လိုက်တဲ့ အရောင်နဲ့ ကိုက်ညီတဲ့ ပုံကို Product Images ထဲမှာ လိုက်ရှာခြင်း
        $chosenImage = $product->image; // Default ပုံကို အရင်ယူထားမယ်
        if ($color && $product->images) {
            foreach ($product->images as $img) {
                if (strtolower($img->color) === strtolower($color)) {
                    $chosenImage = $img->image_path; // ကိုက်ညီတဲ့ အရောင်ပုံတွေ့ရင် အစားထိုးမယ်
                    break;
                }
            }
        }

        // Cart ထဲမှာ ဒီ Product ရဲ့ ဒီ Size၊ ဒီ Color ရှိပြီးသားဆိုရင် အရေအတွက်ပဲ တိုးမယ်
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            // မရှိသေးရင် အသစ်တစ်ခုအနေနဲ့ (Line အသစ်) ထည့်မယ်
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $chosenImage, // 💡 အရောင်ပါတဲ့ ပုံ ဖြစ်သွားပါပြီ
                "size" => $size,
                "color" => $color
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('dashboard')->with('success', 'Product added to cart!');
    }

    // ၃။ အရေအတွက် တိုး/လျော့ Update လုပ်ရန်
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart', []);
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }
    }

    // ၄။ Cart ထဲမှ ပစ္စည်းဖျက်ရန်
    public function removeCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
    }
}
