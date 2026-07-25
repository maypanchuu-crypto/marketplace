<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WalletController extends Controller
{
    // Update Form ပြသပေးမည့် View
    public function editPassword()
    {
        return view('wallet.edit-password');
    }

    // Wallet Password ပြောင်းလဲပေးမည်
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed', // စာလုံးရေ အနည်းဆုံး ၆ လုံး + Confirm စစ်မည်
        ]);

        $user = auth()->user();
        $wallet = $user->wallet; // User Model ရဲ့ Wallet Relationship ကို သုံးထားသည်

        if (!$wallet) {
            return back()->withErrors(['current_password' => 'Wallet အကောင့် မတွေ့ရှိပါ။']);
        }

        // ၁။ မူရင်း Current Wallet Password မှန်/မမှန် စစ်ဆေးခြင်း
        if (!Hash::check($request->current_password, $wallet->wallet_password)) {
            return back()->withErrors(['current_password' => 'လက်ရှိ Wallet Password မမှန်ကန်ပါ။']);
        }

        // ၂။ Password အသစ်ကို Hash လုပ်ပြီး Update လုပ်ခြင်း
        $wallet->update([
            'wallet_password' => Hash::make($request->new_password)
        ]);

        return back()->with('status', 'Wallet Password အောင်မြင်စွာ ပြောင်းလဲပြီးပါပြီ။');
    }
}