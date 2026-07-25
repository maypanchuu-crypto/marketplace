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
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{
    // 💡 Cookie ထဲမှ Cart Data များကို လှမ်းယူသည့် Helper Function
    private function getCartFromCookie()
    {
        return json_decode(Cookie::get('shopping_cart', '[]'), true);
    }

    // ၁။ Checkout Page
    public function index()
    {
        $cart = $this->getCartFromCookie();

        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        return view('checkout', compact('cart', 'total'));
    }

    // ၂။ QR Code Payment Create လုပ်သည့်နေရာ (QR ပေါ်ရုံဖြင့် Cart မဖျက်ပါ)
    public function createQrPayment(Request $request)
    {
        $user = Auth::user();
        $cart = $this->getCartFromCookie();

        // Cart ထဲမှာ ဘာမှမရှိပါက Order တင်ခွင့်မပြုပါ
        if (empty($cart)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart ထဲတွင် ပစ္စည်းများ မရှိပါ။'
            ], 400);
        }

        $total = 0;
        $vendorId = null;

        foreach ($cart as $id => $item) {
            $product = Product::find($item['product_id'] ?? $id);
            if ($product) {
                $total += $item['price'] * $item['quantity'];
                $vendorId = $product->user_id;
            }
        }

        $commission = $total * 0.05;
        $vendorAmount = $total - $commission;

        $txId = 'TXN_' . Str::uuid();

        // Order သို့မဟုတ် QrTransaction Create လုပ်မည်
        $tx = QrTransaction::create([
            'tx_id' => $txId,
            'buyer_id' => $user->id,
            'vendor_id' => $vendorId,
            'amount' => $total,
            'commission_amount' => $commission,
            'vendor_amount' => $vendorAmount,
            'status' => 'generated',
            'expires_at' => now()->addMinutes(10),
        ]);

        // ဖုန်းဖြင့် Scan ဖတ်ရန် Local Network IP Address ဖြင့် URL ပြုလုပ်ခြင်း
        $paymentUrl = "http://192.168.100.242:8000/wallet/pay/" . $txId;

        // 💡 ဤနေရာတွင် Cookie::forget ကို မလုပ်ထားသည့်အတွက် Cart ပျောက်မသွားပါ
        return response()->json([
            'status' => 'success',
            'tx_id' => $txId,
            'amount' => $total,
            'qr' => 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($paymentUrl)
        ]);
    }

    // ၃။ ဖုန်းမှ QR Scan ဖတ်ပြီး ငွေပေးချေမှုကို အတည်ပြုသည့်နေရာ
    public function scanQr(Request $request)
    {
        $request->validate([
            'tx_id' => 'required|string'
        ]);

        $tx = QrTransaction::where('tx_id', $request->tx_id)->first();

        if (!$tx) {
            return response()->json(['error' => 'Invalid QR'], 404);
        }

        // Double payment ကာကွယ်ခြင်း
        if ($tx->status == 'completed') {
            return response()->json(['error' => 'Already paid'], 400);
        }

        // QR Expired ဖြစ်မဖြစ် စစ်ဆေးခြင်း
        if ($tx->expires_at && now()->gt($tx->expires_at)) {
            $tx->update(['status' => 'expired']);
            return response()->json(['error' => 'QR expired'], 400);
        }

        // Processing ပြောင်းမည်
        $tx->update(['status' => 'processing']);

        DB::transaction(function () use ($tx) {
            $adminId = 1; // System Admin

            // Wallet များကို ရှာဖွေ/ဖန်တီးမည်
            $vendorWallet = Wallet::firstOrCreate(['user_id' => $tx->vendor_id]);
            $adminWallet = Wallet::firstOrCreate(['user_id' => $adminId]);

            // Vendor Credit တိုးပေးခြင်း
            $vendorWallet->balance += $tx->vendor_amount;
            $vendorWallet->save();

            $vendorWallet->transactions()->create([
                'type' => 'credit',
                'amount' => $tx->vendor_amount,
                'reference_type' => 'qr_payment',
                'reference_id' => $tx->tx_id,
            ]);

            // Admin Commission တိုးပေးခြင်း
            $adminWallet->balance += $tx->commission_amount;
            $adminWallet->save();

            $adminWallet->transactions()->create([
                'type' => 'credit',
                'amount' => $tx->commission_amount,
                'reference_type' => 'qr_payment',
                'reference_id' => $tx->tx_id,
            ]);

            // Transaction Status ကို Completed ဟု ပြောင်းမည်
            $tx->update(['status' => 'completed']);

            // 💡 ငွေပေးချေမှု အောင်မြင်မှသာ Cookie ထဲမှ Cart ကို ရှင်းထုတ်မည်
            Cookie::queue(Cookie::forget('shopping_cart'));
        });

        return response()->json([
            'message' => 'Payment successful',
            'tx_id' => $tx->tx_id
        ]);
    }

    // ၄။ QR Code Payment Status စစ်ပေးသည့် API
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