<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WalletPaymentController extends Controller
{
    // ဖုန်း Browser တွင် ပွင့်လာမည့် Payment Form
    public function showPaymentPage($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        return view('wallet.pay', compact('order'));
    }

    // Password စစ်ပြီး Wallet ထဲမှ ငွေနှုတ်/ငွေခွဲပေးသည့် Logic
    public function processPayment(Request $request, $orderId)
    {
        $request->validate(['wallet_password' => 'required']);

        $order = Order::with('items')->findOrFail($orderId);
        $user = auth()->user();
        $wallet = $user->wallet;

        // ၁. Wallet Balance စစ်ဆေးခြင်း
        if ($wallet->balance < $order->total_amount) {
            return back()->with('error', 'Insufficient balance in your wallet!');
        }

        // ၂. Wallet Password (PIN) စစ်ဆေးခြင်း
        if (!Hash::check($request->wallet_password, $wallet->wallet_password)) {
            return back()->with('error', 'Incorrect Wallet Password!');
        }

        // ၃. Transaction အလုပ်လုပ်ပြီး Admin (2%) နှင့် Vendor (98%) ဆီ ငွေခွဲပေးခြင်း
        DB::transaction(function () use ($wallet, $order) {

            // Customer Wallet ထဲမှ ငွေနှုတ်မည်
            $wallet->decrement('balance', $order->total_amount);

            $admin = User::where('role', 'admin')->first();

            foreach ($order->items as $item) {
                $itemTotal = $item->price * $item->quantity;

                $adminCommission = $itemTotal * 0.02;          // 2% Admin Commission
                $vendorAmount = $itemTotal - $adminCommission; // 98% Vendor Share

                // Admin Wallet ထဲ ငွေပေါင်းမည်
                if ($admin && $admin->wallet) {
                    $admin->wallet->increment('balance', $adminCommission);
                }

                // Vendor Wallet ထဲ ငွေပေါင်းမည်
                $vendor = User::find($item->vendor_id);
                if ($vendor && $vendor->wallet) {
                    $vendor->wallet->increment('balance', $vendorAmount);
                }
            }

            // Order Status ကို Paid ပြောင်းမည်
            $order->update(['status' => 'paid']);
        });

        return view('wallet.success', compact('order'));
    }
}
