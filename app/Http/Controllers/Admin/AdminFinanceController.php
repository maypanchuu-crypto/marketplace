<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class AdminFinanceController extends Controller
{
    // Vendor များအားလုံး စာရင်းနှင့် လက်ကျန်ငွေပြရန်
    public function vendorIndex()
    {
        $vendors = User::where('role', 'vendor')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    // Vendor အကောင့် ယာယီပိတ်/ဖွင့် လုပ်ရန်
    public function toggleVendor($id)
    {
        $vendor = User::findOrFail($id);
        $vendor->vendor_status = ($vendor->vendor_status === 'suspended') ? 'approved' : 'suspended';
        $vendor->save();
        return back()->with('success', 'Vendor status updated successfully.');
    }

    // Vendor အကောင့် ဖျက်ရန်
    public function deleteVendor($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Vendor deleted successfully.');
    }

    // ငွေထုတ်ရန်တောင်းဆိုထားသော စာရင်းများ ကြည့်ရန်
    public function withdrawIndex()
    {
        // WithdrawRequest model ကို ဆောက်ရပါဦးမည် (အဆင့် ၄ တွင်ကြည့်ပါ)
        $requests = \App\Models\WithdrawRequest::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.finance.withdraws', compact('requests'));
    }

    // ငွေထုတ်ပေးမှုကို အတည်ပြုခြင်း (Approve)
    public function approveWithdraw($id)
    {
        $request = \App\Models\WithdrawRequest::findOrFail($id);
        if ($request->status !== 'pending')
            return back()->with('error', 'Already processed.');

        $request->update(['status' => 'approved']);
        return back()->with('success', 'Withdraw request approved successfully.');
    }

    // ငွေထုတ်ပေးမှုကို ငြင်းပယ်ခြင်း (Reject) - ပိုက်ဆံကို Wallet ထဲ ပြန်ထည့်ပေးရမည်
    public function rejectWithdraw(Request $request, $id)
    {
        $withdraw = \App\Models\WithdrawRequest::findOrFail($id);
        if ($withdraw->status !== 'pending')
            return back()->with('error', 'Already processed.');

        DB::transaction(function () use ($withdraw, $request) {
            $withdraw->update([
                'status' => 'rejected',
                'admin_note' => $request->admin_note
            ]);
            // Vendor Wallet ထဲ ငွေပြန်ပေါင်းထည့်ပေးခြင်း
            $withdraw->user->increment('balance', $withdraw->amount);
        });

        return back()->with('success', 'Withdraw request rejected and funds returned to vendor.');
    }

    public function completeOrder($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        if ($order->status === 'completed')
            return back();

        $commissionRate = 0.05; // ၅% ကော်မရှင်

        DB::transaction(function () use ($order, $commissionRate) {
            // ၁။ Order status ကို completed ပြောင်းမည်
            $order->update(['status' => 'completed']);

            // ၂။ ပါဝင်သမျှ ပစ္စည်းတစ်ခုချင်းစီအလိုက် ကော်မရှင်ခွဲပြီး သက်ဆိုင်ရာ Vendor ဆီ ပိုက်ဆံထည့်ပေးမည်
            foreach ($order->items as $item) {
                $itemTotal = $item->price * $item->quantity;
                $commission = $itemTotal * $commissionRate;
                $vendorAmount = $itemTotal - $commission;

                // Item တစ်ခုချင်းစီမှာ ကော်မရှင်မှတ်တမ်းသွင်းမည်
                $item->update([
                    'admin_commission' => $commission,
                    'vendor_amount' => $vendorAmount
                ]);

                // သက်ဆိုင်ရာ Vendor ရဲ့ အိတ်ကပ် (balance) ထဲ ပိုက်ဆံထည့်ပေးမည်
                $vendor = \App\Models\User::find($item->vendor_id);
                if ($vendor) {
                    $vendor->increment('balance', $vendorAmount);
                }
            }
        });

        return back()->with('success', 'Order approved! Commissions distributed to vendors.');
    }

    public function orderIndex()
    {        
        $orders = Order::with('items.product', 'user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }
}
