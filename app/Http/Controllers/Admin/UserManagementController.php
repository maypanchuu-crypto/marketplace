<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    // 👥 User စာရင်းအားလုံးကို Search / Filter လုပ်ပြီး ပြသခြင်း
    public function index(Request $request)
    {
        $query = User::query();

        // 🔍 Search Logic: Name သို့မဟုတ် Email ဖြင့် ရှာဖွေခြင်း
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // filter Logic: Role အလိုက် စစ်ထုတ်ခြင်း (admin, vendor, customer)
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // ဒေတာများကို pagination စနစ်ဖြင့် ဆွဲထုတ်ခြင်း (တစ်မျက်နှာလျှင် ၁၀ ယောက်)
        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.user-management', compact('users'));
    }

    // 🚫 User တစ်ယောက်ကို Ban ရန် သို့မဟုတ် Unban ရန် (Status Toggle)
    // (မှတ်ချက် - users table ထဲမှာ vendor_status column ရှိပြီးသားမို့လို့ Customer ပါ သုံးနိုင်အောင် ၎င်းကိုပဲ 'banned' / 'approved' ပြောင်းလဲခြင်းဖြစ်ပါတယ်)
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // လက်ရှိ Status က banned ဖြစ်နေရင် ပုံမှန်အတိုင်း ပြန်ပြောင်းပေးမယ်
        if ($user->vendor_status === 'banned') {
            // role က vendor ဆိုရင် approved ပြန်လုပ်မယ်၊ customer ဆိုရင် null ပြန်ထားမယ်
            $user->vendor_status = ($user->role === 'vendor') ? 'approved' : null;
            $message = "User '{$user->name}' has been unbanned successfully.";
        } else {
            // banned မဟုတ်သေးရင် 'banned' လို့ သတ်မှတ်လိုက်မယ်
            $user->vendor_status = 'banned';
            $message = "User '{$user->name}' has been banned successfully.";
        }

        $user->save(); // 💡 Database ထဲကို အသေသိမ်းလိုက်ခြင်း

        return redirect()->back()->with('success', $message);
    }

    // 🗑️ User အကောင့်ကို စနစ်ထဲမှ လုံးဝ ဖျက်ပစ်ခြင်း
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User account deleted successfully.');
    }
}
