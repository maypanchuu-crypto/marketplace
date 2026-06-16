<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorRegistrationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // if ($user->role === 'vendor') {
        //     return redirect()->route('dashboard')->with('info', 'You are already a vendor.');
        // }
        return view('vendor-register', compact('user'));
    }

    public function register(Request $request)
    {
        $user = Auth::user();

        // Validation တွင် payment_slip အတွက် image စစ်ဆေးချက်ထည့်ခြင်း
        $request->validate([
            'shop_name' => 'required|string|max:255|unique:users,shop_name,' . $user->id,
            'shop_phone' => 'required|digits_between:8,11',
            'shop_description' => 'required|string|min:10',
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $inputData = [
            'shop_name' => $request->shop_name,
            'shop_phone' => $request->shop_phone,
            'shop_description' => $request->shop_description,
            'vendor_status' => 'pending',
        ];

        // ပုံကို Storage အောက်ထဲသို့ သိမ်းဆည်းခြင်း
        if ($request->hasFile('payment_slip')) {
            // ယခင်ပုံဟောင်းရှိရင် ဖျက်ပစ်မည်
            if ($user->payment_slip) {
                Storage::disk('public')->delete($user->payment_slip);
            }
            
            $path = $request->file('payment_slip')->store('slips', 'public');
            $inputData['payment_slip'] = $path;
        }

        $user->update($inputData);

        return redirect()->back()->with('success', 'Your request and payment slip have been submitted! Please wait for admin approval.');
    }
}