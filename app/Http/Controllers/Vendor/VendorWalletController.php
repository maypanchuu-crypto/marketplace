<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorWalletController extends Controller
{
    public function index()
    {
        $vendor = Auth::user();
        $history = WithdrawRequest::where('user_id', $vendor->id)->orderBy('created_at', 'desc')->get();
        return view('vendor.wallet.index', compact('vendor', 'history'));
    }

    // ငွေထုတ်ရန် လျှောက်လွှာတင်ခြင်း
    public function requestWithdraw(Request $request)
    {
        $vendor = Auth::user();

        $request->validate([
            'amount' => 'required|numeric|min:1000|max:' . $vendor->balance,
            'payment_method' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        DB::transaction(function () use ($vendor, $request) {
            // ၁။ Vendor Balance ထဲကနေ ထုတ်မည့်ပမာဏကို နှုတ်ယူထားမည်
            $vendor->decrement('balance', $request->amount);

            // ၂။ Request Table ထဲ မှတ်တမ်းသွင်းမည်
            WithdrawRequest::create([
                'user_id' => $vendor->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'status' => 'pending'
            ]);
        });

        return back()->with('success', 'Withdraw request submitted successfully. Waiting for admin approval.');
    }
}
