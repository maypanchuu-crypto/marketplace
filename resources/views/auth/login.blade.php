<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- GLOBAL RESET --- */
        * {
            box-sizing: border-box;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
            margin: 0;
            padding: 0;
        }

        body {
            background: #eef2f6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* --- FORM SECTION --- */
        #formSection {
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 1;
        }

        /* 💡 3D BLOCK CARD (လိမ္မော်နှင့် အနီဦးစားပေး Rainbow Background & 3D Depth) */
        .card {
            background: linear-gradient(135deg, #ef4444 0%, #f97316 50%, #eab308 100%);
            width: 380px;
            padding: 24px;
            border-radius: 24px;
            border-top: 2px solid rgba(255, 255, 255, 0.7);
            border-left: 2px solid rgba(255, 255, 255, 0.7);
            border-bottom: 6px solid #b91c1c;
            border-right: 3px solid #b91c1c;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        /* 💡 Glassmorphic Inner Container (စာသားများ ကြည်လင်စွာ ဖတ်နိုင်ရန် ခံပေးထားသော ဘုတ်ပြား) */
        .card-inner {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 16px;
            border-top: 2px solid #ffffff;
            border-left: 2px solid #ffffff;
            border-bottom: 4px solid #cbd5e1;
            border-right: 2px solid #cbd5e1;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 26px;
            font-weight: 900;
            color: #9a3412;
            /* လိမ္မော်ရင့်ရင့် ခေါင်းစဉ် */
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
        }

        .input-group {
            text-align: left;
        }

        label {
            font-size: 14px;
            color: #ea580c;
            /* လိမ္မော်ရောင် Label */
            font-weight: 800;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .password-container {
            position: relative;
            display: block;
            width: 100%;
        }

        #toggleIcon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9a3412;
        }

        /* 💡 3D Input Boxes */
        input {
            width: 100%;
            padding: 12px;
            padding-right: 40px;
            border: 2px solid #fdba74;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            outline: none;
            background: #fff7ed;
            color: #1f2937;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
            transition: all 0.2s;
        }

        input:focus {
            border-color: #ea580c;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.2);
        }

        /* 💡 3D BUTTON (လိမ္မော်/အနီ စတိုင် 3D Push Button) */
        button {
            padding: 14px;
            border: none;
            background: linear-gradient(to right, #ea580c, #dc2626);
            color: white;
            font-weight: 900;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            /* 3D Depth အောက်ခြေအထူ */
            border-bottom: 4px solid #991b1b;
            box-shadow: 0 6px 12px rgba(220, 38, 38, 0.3);
            transition: all 0.15s ease;
        }

        button:hover {
            background: linear-gradient(to right, #f97316, #ef4444);
        }

        button:active {
            transform: translateY(3px);
            border-bottom: 1px solid #991b1b;
            box-shadow: none;
        }

        .links {
            font-size: 14px;
            margin-top: 16px;
            line-height: 1.5;
            font-weight: 600;
            color: #4b5563;
        }

        .links a {
            color: #dc2626;
            cursor: pointer;
            text-decoration: none;
            font-weight: 800;
            transition: color 0.2s;
        }

        .links a:hover {
            color: #ea580c;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div id="formSection">
        <!-- 💡 3D Rainbow Outer Card -->
        <div class="card">
            <!-- 💡 Inner Content Container -->
            <div class="card-inner">
                <h2>Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <label for="email" :value="__('Email')">Email</label>
                        <input type="email" id="email" name="email" placeholder="you@example.com" :value="old('email')"
                            required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="input-group">
                        <label for="password" :value="__('Password')">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" placeholder="••••••••"
                                class="password-input" required autocomplete="current-password">
                            <i class="fas fa-eye-slash" id="toggleIcon" onclick="togglePasswordVisibility(this)"></i>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <button type="submit">Login</button>
                </form>
                <div class="links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                    <br><br>
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(icon) {
            const passwordInput = document.getElementById('password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye-slash';
            }
        }
    </script>

</body>

</html>