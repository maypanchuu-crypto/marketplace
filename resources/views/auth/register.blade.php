<?php /*
<x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <div>
          <x-input-label for="name" :value="__('Name')" />
          <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <!-- Email Address -->
      <div class="mt-4">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- Password -->
      <div class="mt-4">
          <x-input-label for="password" :value="__('Password')" />

          <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

          <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
          <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

          <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>

      <div class="flex items-center justify-end mt-4">
          <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
              {{ __('Already registered?') }}
          </a>

          <x-primary-button class="ms-4">
              {{ __('Register') }}
          </x-primary-button>
      </div>
  </form>
</x-guest-layout>
*/ ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Login') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

    <!-- Scripts -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <style>
        /* --- GLOBAL RESET --- */
        * {
            box-sizing: border-box;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
            margin: 0;
            padding: 0
        }

        body {
            background: #f3f4f6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }


        /* --- FORM SECTION --- */
        #formSection {
            margin-top: 1.2px;
            position: absolute;
            /* top:60%; */
            width: 100%;
            display: flex;
            justify-content: center;
            opacity: 1;
            /* transition:opacity 1.5s ease, top 1.5s cubic-bezier(0.19, 1, 0.22, 1); */
            z-index: 1;
        }

        .card {
            background: white;
            width: 360px;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%
        }

        .input-group {
            text-align: left;
        }

        label {
            font-size: 15px;
            color: #4b5563;
            font-weight: 500;
            display: block;
            margin-bottom: 6px;
        }

        /* New: Container for input and icon */
        .password-container {
            position: relative;
            display: block;
            width: 100%;
        }

        #toggleIcon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        input {
            width: 100%;
            padding: 12px;
            padding-right: 40px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: #1e40af;
        }

        /* New: Eye icon styling */
        .eye-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            font-size: 18px;
            /* For a visible icon */
            line-height: 1;
            padding: 0 5px;
        }

        button {
            padding: 12px;
            border: none;
            background: #1e40af;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.2s;
        }

        button:hover {
            background: #172554;
        }

        .links {
            font-size: 15px;
            margin-top: 6px;
            line-height: 1.5;
        }

        .links a {
            color: #1d4ed8;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600
        }
    </style>
</head>

<body>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div id="formSection">
        <div class="card">
            <h2>Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="input-group">
                    <label for="name" :value="__('Name')">Name</label>
                    <input type="text" id="name" name="name" :value="old('name')" required autofocus autocomplete="name"
                        placeholder="Your Name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
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
                            class="password-input" required autocomplete="new-password">
                        <i class="fas fa-eye-slash" id="toggleIcon" onclick="togglePasswordVisibility(this)"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="input-group">
                    <label for="password_confirmation" :value="__('Confirm Password')">Confirm Password</label>
                    <div class="password-container">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="••••••••" class="password-input" required autocomplete="new-password">
                        <i class="fas fa-eye-slash" id="toggleIcon" onclick="togglePasswordVisibility(this)"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <button type="submit">Register</button>
            </form>
            <div class="links">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        // --- NEW PASSWORD TOGGLE FUNCTION ---
        function togglePasswordVisibility(iconElement) {
            // Get the sibling input element (the password field)
            const input = iconElement.previousElementSibling;

            if (input.type === "password") {
                input.type = "text";
                icon.className = 'fas fa-eye';
                //iconElement.textContent = "🙈"; // Change icon to closed/locked
            } else {
                input.type = "password";
                icon.className = 'fas fa-eye-slash';
                //iconElement.textContent = "👁"; // Change icon to open/visible
            }
        }
    </script>

</body>

</html>