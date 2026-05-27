<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    // Pending ဖြစ်နေတဲ့ Request အားလုံးကို စာရင်းပြမည့်နေရာ
    public function index()
    {
        $requests = User::where('vendor_status', 'pending')->get();
        return view('admin.vendor-requests', compact('requests'));
    }

    // Request ကို အတည်ပြုပေးခြင်း (Approve)
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'role' => 'vendor',
            'vendor_status' => 'approved'
        ]);

        return redirect()->back()->with('success', "Approved! {$user->name}'s shop ({$user->shop_name}) is now live.");
    }

    // Request ကို ငြင်းပယ်လိုက်ခြင်း (Reject)
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'vendor_status' => 'rejected'
        ]);

        return redirect()->back()->with('error', "Rejected {$user->name}'s vendor request.");
    }
}