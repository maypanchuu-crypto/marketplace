<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // ၁။ Checkout Page (Random OTP ထုတ်ပြီး Form ပြသရန်)
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 🌟 ဤနေရာတွင် Random OTP ၄ လုံးဂဏန်း ထုတ်ပြီး Session ထဲသိမ်းခြင်း
        $randomOtp = rand(1000, 9999);
        session()->put('demo_otp', $randomOtp);

        return view('checkout.index', compact('cart', 'total', 'randomOtp'));
    }

    // ၂။ "Pay Now" နှိပ်ပြီး Random OTP ကို စစ်ဆေးကာ ငွေဖြတ်မည့်နေရာ
    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart))
            return redirect()->route('cart.index');

        // Session ထဲတွင် သိမ်းထားခဲ့သော OTP အမှန်ကို လှမ်းယူခြင်း
        $correctOtp = session()->get('demo_otp');

        // Validation စစ်ဆေးခြင်း
        $request->validate([
            'customer_name' => 'required|string|max:255',
            // 🌟 သုတ မေးထားသည့်အတိုင်း ဖုန်းနံပါတ် ဂဏန်း ၈ လုံးမှ ၁၁ လုံးအတွင်း စစ်ဆေးခြင်း
            'customer_phone' => 'required|digits_between:8,11',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
            'otp_code' => 'required|numeric',
        ]);

        // 🌟 CRITICAL CHECK: User ရိုက်လိုက်သည့် OTP နှင့် Session ထဲက Random OTP တူ/မတူ စစ်ခြင်း
        if ($request->otp_code != $correctOtp) {
            return back()->withErrors(['otp_code' => 'Invalid OTP Code! Please check the demo popup again.'])->withInput();
        }

        // စုစုပေါင်း ကျသင့်ငွေ တွက်ချက်ခြင်း
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Transaction စတင်ပြီး ပိုက်ဆံတိုက်ရိုက်ခွဲဝေကာ status ကို 'completed' ပေးမည်
        DB::transaction(function () use ($request, $cart, $total) {

            // Orders Table ထဲသို့ status 'completed' ဖြင့် တိုက်ရိုက်သွင်းခြင်း
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'completed', // Admin အတည်ပြုစရာမလိုဘဲ တန်းပြီး Completed ဖြစ်သွားမည်
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'payment_slip' => null
            ]);

            $commissionRate = 0.05; // Admin ကော်မရှင် ၅%

            // ဝယ်လိုက်သော ပစ္စည်းတစ်ခုချင်းစီကို OrderItems ထဲသွင်းပြီး Vendor ဆီ ပိုက်ဆံ တန်းခွဲပေးခြင်း
            foreach ($cart as $id => $details) {
                $product = Product::find($details['product_id'] ?? $id);

                $itemTotal = $details['price'] * $details['quantity'];
                $commission = $itemTotal * $commissionRate;
                $vendorAmount = $itemTotal - $commission;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'vendor_id' => $product->user_id,
                    'quantity' => $details['quantity'],
                    'color' => $details['color'] ?? null,
                    'size' => $details['size'] ?? null,
                    'price' => $details['price'],
                    'admin_commission' => $commission,
                    'vendor_amount' => $vendorAmount
                ]);

                // Vendor ၏ Balance အကောင့်ထဲသို့ ပိုက်ဆံ တိုက်ရိုက် တိုးပေးခြင်း
                $vendor = User::find($product->user_id);
                if ($vendor) {
                    $vendor->increment('balance', $vendorAmount);
                }
            }

            // အော်ဒါအောင်မြင်သွားသဖြင့် သုံးပြီးသား OTP ရော Cart ရော ရှင်းလင်းပစ်ခြင်း
            session()->forget(['cart', 'demo_otp']);
        });

        return redirect()->route('dashboard')->with('success', 'Payment Successful! Your order has been placed and paid via Mobile Wallet.');
    }
}
