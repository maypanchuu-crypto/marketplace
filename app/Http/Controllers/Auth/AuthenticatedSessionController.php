<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // 💡 အဆင့် ၁: Login ဝင်လာတဲ့ User က Banned ဖြစ်နေလား အရင်စစ်မယ်
        $user = auth()->user();

        if ($user && $user->vendor_status === 'banned') {
            // Banned ဖြစ်နေရင် ချက်ချင်း Auth ကနေ ပြန်ထုတ်ပစ်မယ်
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // ⚠️ Login Page ဆီ Error Message နဲ့ ပြန်လွှတ်လိုက်ခြင်း
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been suspended/banned by the administrator.',
            ]);
        }

        // Banned မဟုတ်ရင် ပုံမှန်အတိုင်း အချိန်မှတ်ပြီး ပေ့ချ်တွေဆီ လွှတ်မယ်
        $request->session()->regenerate();

        if ($user) {
            $user->update([
                'last_login_at' => \Carbon\Carbon::now()
            ]);
        }

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->role === 'vendor') {
            return redirect()->intended(route('vendor.dashboard'));
        }

        return redirect()->intended(route('dashboard'));



        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
