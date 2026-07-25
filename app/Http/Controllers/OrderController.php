<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function index()
    {
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        // Cart ထဲက ပစ္စည်းတွေရဲ့ စုစုပေါင်း တန်ဖိုးကို တွက်ချက်ခြင်း
        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // checkout.blade.php သို့ $total ပို့ပေးမည်
        return view('checkout.index', compact('cart', 'total'));
    }
    public function placeOrder(Request $request)
    {
        $cart = json_decode(Cookie::get('shopping_cart', '[]'), true);

        // Cart ထဲမှာ ဘာမှမရှိရင် မလုပ်ခိုင်းပါ
        if (empty($cart)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart ထဲတွင် ပစ္စည်းများ မရှိပါ။'
            ], 400);
        }

        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // 💡 Pending Order ရှိ/မရှိ စစ်ပြီး ရှိရင် Update လုပ်မည်၊ မရှိရင် Create လုပ်မည်
        $order = Order::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'status' => 'pending', // Pending ဖြစ်နေတဲ့ Order ကိုပဲ ရှာမည်
            ],
            [
                'total_amount' => $total,
                'customer_name'    => $request->input('customer_name', auth()->user()->name),
                'customer_phone' => $request->phone,   // နောက်ဆုံးရိုက်ထည့်လိုက်သည့် ဖုန်းနံပါတ်
                'shipping_address' => $request->address, // နောက်ဆုံးရိုက်ထည့်လိုက်သည့် လိပ်စာ
            ]
        );

        // Order ID တစ်ခုတည်းအတွက်ပဲ QR Code URL ထုတ်ပေးမည်
        $paymentUrl = "http://192.168.1.5:8000/wallet/pay/" . $order->id; 
        $qrCode = QrCode::size(200)->generate($paymentUrl);

        return response()->json([
            'status' => 'success',
            'order_id' => $order->id,
            'qr_code' => 'data:image/svg+xml;base64,' . base64_encode($qrCode)
        ]);
    }

    // ၂။ ဖုန်းဖြင့် Scan ဖတ်ပြီး ငွေချေပြီးမှ Cart ကို ရှင်းထုတ်မည်
    // public function confirmPayment($orderId)
    // {
    //     $order = Order::findOrFail($orderId);

    //     if ($order->status !== 'paid') {
    //         $order->update(['status' => 'paid']);

    //         // 💡 ငွေပေးချေမှု အောင်မြင်မှသာ Cookie ထဲက Cart ကို ရှင်းထုတ်ပါမည်
    //         Cookie::queue(Cookie::forget('shopping_cart'));
    //     }

    //     return "Order #{$orderId} အတွက် ငွေပေးချေမှု အောင်မြင်ပါသည်။";
    // }

    public function confirmPayment($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response('<h3>Order မတွေ့ရှိပါ!</h3>', 404);
        }

        if ($order->status !== 'paid') {
            $order->update(['status' => 'paid']);

            // 💡 ငွေပေးချေမှု အောင်မြင်ပါက Cookie ထဲက Shopping Cart ကို ရှင်းထုတ်မည်
            Cookie::queue(Cookie::forget('shopping_cart'));
        }

        return response('
        <div style="text-align: center; padding: 50px; font-family: sans-serif;">
            <h2 style="color: green;">🎉 ငွေပေးချေမှု အောင်မြင်ပါသည်။</h2>
            <p>Order #' . $orderId . ' အတွက် ပေးချေမှု ပြီးစီးပါပြီ။</p>
        </div>
    ');
    }
}
