<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckBannedUser
{
    /*
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // 💡 User က Login ဝင်ထားပြီး သူ့ရဲ့ Status က banned ဖြစ်နေရင်
        if (Auth::check() && Auth::user()->vendor_status === 'banned') {

            // ၁။ အရင်ဆုံး နောက်ကွယ်ကနေ Logout လုပ်ပစ်မည် (ဒါမှ ဒေတာ ဆက်ယူလို့မရမှာ)
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // ၂။ 💡 Welcome Page (/) ဆီကို Account Banned ဖြစ်သွားတဲ့ Flash Message နှင့်အတူ ပို့လိုက်ခြင်း
            return redirect('/')->with('account_banned_modal', true);
        }

        return $next($request);
    }
}
