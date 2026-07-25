<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Wallet;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            // ၁။ 📬 Email ကို ပိုမိုတိကျစေရန် regex (Regular Expression) ဖြင့် စစ်ဆေးခြင်း
            'email' => [
                'required',
                'string',
                'lowercase',
                'max:255',
                'unique:' . User::class,
                // regex က name@domain.com / .net / .org ပုံစံမျိုး မှန်ကန်မှသာ လက်ခံပါမည်
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],

            // ၂။ 🔐 Password ကို အနည်းဆုံး ၈ လုံး + စာလုံး + နံပါတ် + သင်္ကေတ ပါဝင်အောင် စစ်ဆေးခြင်း
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8) // အနည်းဆုံး ၈ လုံး
                    ->letters()        // စာလုံး (a-z, A-Z) ပါရမည်
                    ->numbers()        // နံပါတ် (0-9) ပါရမည်
                    ->symbols()        // အထူးသင်္ကေတ (!, @, #, $, %, etc.) ပါရမည်
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 100000.00, // Starting Balance
            'wallet_password' => Hash::make('123456'), // Default PIN / Password
        ]);

        event(new Registered($user));

        Auth::login($user);

        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->role === 'vendor') {
            return redirect()->intended(route('vendor.dashboard'));
        }

        // Default redirection for customers
        return redirect()->intended(route('dashboard'));

        //return redirect(RouteServiceProvider::HOME);
    }
}
