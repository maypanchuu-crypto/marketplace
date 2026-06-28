<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\QrTransaction;
use Illuminate\Support\Str;
use App\Models\Wallet;

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

        // 🌟 စာမျက်နှာဖွင့်ကတည်းက Random OTP ကို ထုတ်ပြီး Session ထဲ တစ်ခါတည်း သိမ်းထားမည်
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
public function createQrPayment(Request $request)
{
    $user = Auth::user();

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return response()->json(['error' => 'Cart is empty'], 400);
    }

    $total = 0;
    $vendorId = null;

    foreach ($cart as $id => $item) {
        $product = Product::find($item['product_id'] ?? $id);
        $total += $item['price'] * $item['quantity'];
        $vendorId = $product->user_id;
    }

    $commission = $total * 0.05;
    $vendorAmount = $total - $commission;

    $txId = 'TXN_' . Str::uuid();

    $tx = QrTransaction::create([
        'tx_id' => $txId,
        'buyer_id' => $user->id,
        'vendor_id' => $vendorId,
        'amount' => $total,
        'commission_amount' => $commission,
        'vendor_amount' => $vendorAmount,
        'status' => 'generated',
        'expires_at' => now()->addMinutes(5),
    ]);

    // 🟢 SIMPLE DEMO QR (NO PACKAGE REQUIRED)
    $qrData = json_encode([
        'tx_id' => $txId,
        'amount' => $total
    ]);

    return response()->json([
    'tx_id' => $txId,
    'amount' => $total,
    'qr' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($txId)
]);
}
public function scanQr(Request $request)
{
    $request->validate([
        'tx_id' => 'required|string'
    ]);

    $tx = QrTransaction::where('tx_id', $request->tx_id)->first();

    if (!$tx) {
        return response()->json(['error' => 'Invalid QR'], 404);
    }

    // ❌ prevent double payment
    if ($tx->status == 'completed') {
        return response()->json(['error' => 'Already paid'], 400);
    }

    // ❌ expired check
    if ($tx->expires_at && now()->gt($tx->expires_at)) {
        $tx->update(['status' => 'expired']);
        return response()->json(['error' => 'QR expired'], 400);
    }

    // mark processing
    $tx->update(['status' => 'processing']);

    DB::transaction(function () use ($tx) {

        $adminId = 1; // system admin

        // wallets
        $vendorWallet = Wallet::firstOrCreate(['user_id' => $tx->vendor_id]);
        $adminWallet = Wallet::firstOrCreate(['user_id' => $adminId]);

        // 💰 vendor credit
        $vendorWallet->balance += $tx->vendor_amount;
        $vendorWallet->save();

        $vendorWallet->transactions()->create([
            'type' => 'credit',
            'amount' => $tx->vendor_amount,
            'reference_type' => 'qr_payment',
            'reference_id' => $tx->tx_id,
        ]);

        // 💰 admin commission
        $adminWallet->balance += $tx->commission_amount;
        $adminWallet->save();

        $adminWallet->transactions()->create([
            'type' => 'credit',
            'amount' => $tx->commission_amount,
            'reference_type' => 'qr_payment',
            'reference_id' => $tx->tx_id,
        ]);

        // mark completed
        $tx->update(['status' => 'completed']);
    });

    return response()->json([
        'message' => 'Payment successful',
        'tx_id' => $tx->tx_id
    ]);
}

public function checkQrStatus($tx_id)
{
    $tx = QrTransaction::where('tx_id', $tx_id)->first();

    if (!$tx) {
        return response()->json(['status' => 'invalid']);
    }

    return response()->json([
        'status' => $tx->status,
        'amount' => $tx->amount
    ]);
}
}
