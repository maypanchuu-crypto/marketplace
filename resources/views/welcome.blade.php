<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        /* 📜 အခြေခံ HTML နှင့် Body အတွက် Style များ */
        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            font-family: Figtree, sans-serif;
            background-color: #f3f4f6;
            /* bg-gray-100 ရဲ့ အရောင် */
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            position: relative;
            -webkit-font-smoothing: antialiased;
        }

        /* 🌐 နဂိုမူလ အပြင်အဆင်အတိုင်း ကွက်တိဖြစ်စေမည့် Navigation Bar Styles */
        .nav-container {
            position: fixed;
            top: 0;
            right: 0;
            padding: 1.5rem;
            /* p-6 */
            text-align: right;
            /* text-right */
            z-index: 10;
            /* z-10 */
        }

        .nav-link {
            font-weight: 600;
            /* font-semibold */
            font-size: 1.05rem;
            /* 💡 နဂို 0.875rem ကနေ စာလုံးကို ပိုကြီးပြီး ကြည့်ကောင်းအောင် ပြင်လိုက်သည် */
            color: #4b5563;
            /* text-gray-600 */
            text-decoration: none;
            transition: color 0.15s ease-in-out;
            display: inline-block;
        }

        /* Hover လုပ်လျှင် နဂိုအတိုင်း ပိုမည်းသွားစေရန် */
        .nav-link:hover {
            color: #111827;
            /* hover:text-gray-900 */
        }

        /* Register ခလုတ်ကို ဘယ်ဘက်ကနေ Margin ပေးပြီး ခွာရန် */
        .ml-4 {
            margin-left: 1rem;
            /* ml-4 */
        }

        /* ⚠️ Banned Modal အတွက် လိုအပ်သော Style များ */
        .fixed {
            position: fixed;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .z-50 {
            z-index: 50;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .p-4 {
            padding: 1rem;
        }

        .bg-blur {
            background-color: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(4px);
        }

        .modal-box {
            background-color: white;
            border-radius: 1.5rem;
            padding: 1.5rem;
            max-width: 24rem;
            width: 100%;
            text-align: center;
            border: 1px solid #fef3c7;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 900;
            color: #111827;
            margin: 0;
        }

        .modal-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
            line-height: 1.625;
        }

        .btn-ok {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            padding: 0.625rem 1rem;
            background-color: #f59e0b;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-ok:hover {
            background-color: #d97706;
        }

        .icon-circle {
            margin: 0 auto 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 3.5rem;
            width: 3.5rem;
            border-radius: 9999px;
            background-color: #fef3c7;
            color: #f59e0b;
        }
    </style>
</head>

<body>
    @if (Route::has('login'))
        <div class="nav-container">
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-link ">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-link ">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-link ml-4">Register</a>
                @endif
            @endauth
        </div>
    @endif

    @if(session('account_banned_modal'))
        <div id="bannedModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-blur">
            <div class="modal-box">
                <div class="icon-circle">
                    <svg style="width:2rem; height:2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h3 class="modal-title">Account Suspended</h3>
                <p class="modal-text">
                    သင့်အကောင့်သည် စနစ်စည်းကမ်းချက်များကြောင့် ခေတ္တပိတ်ပင် (Ban) ခြင်း ခံရပါသည်။
                </p>

                <div style="margin-top: 1.5rem;">
                    <button type="button" onclick="closeBannedModal()" class="btn-ok">
                        OK
                    </button> // hello
                </div>
            </div>
        </div>

        <script>
            function closeBannedModal() {
                document.getElementById('bannedModal').style.display = 'none';
            }
        </script>
    @endif
</body>

</html>