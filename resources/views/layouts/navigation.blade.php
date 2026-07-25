<nav
    class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b dark:border-gray-700">
    <div class="flex items-center gap-3 flex-shrink-0">

        @if(!isset($menuBtn) || !$menuBtn)
            <button id="menuBtn"
                class="text-amber-500 dark:text-amber-400 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        @endif

        @if(!isset($logo) || !$logo)
            <div class="flex items-center gap-3 select-none">
                <!-- Logo ပုံစံ -->
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-11 h-11 object-contain rounded-xl">

                <span
                    class="text-2xl font-black tracking-wider bg-gradient-to-r from-red-500 via-yellow-500 via-green-500 via-blue-500 to-purple-500 bg-clip-text text-transparent font-sans drop-shadow-sm hidden sm:inline-block">
                    Market
                </span>
            </div>
        @endif

    </div>

    @if(!isset($hideSearch) || !$hideSearch)
        <div class="flex-grow max-w-2xl mx-4 relative" x-data="{ query: '' }">
            <span
                class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-500 dark:text-amber-400 pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                    </path>
                </svg>
            </span>
            <input type="text" x-model="query" @input="$dispatch('product-search', query)" placeholder="Search products..."
                class="w-full pl-9 pr-4 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white rounded-full text-sm border-2 border-amber-500 dark:border-amber-400 focus:outline-none focus:border-amber-500 focus:ring-0 placeholder-amber-500/60 dark:placeholder-amber-400/60 font-medium transform transition-all duration-300 ease-out focus:scale-[1.02] shadow-xs">
        </div>
    @endif

    <div class="flex items-center ms-6 gap-4">
        @if(!isset($cartIcon) || !$cartIcon)
            <a href="{{ route('cart.index') }}"
                class="relative text-amber-500 dark:text-amber-400 hover:text-amber-600 dark:hover:text-amber-300 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z">
                    </path>
                </svg>
            </a>
        @endif

        @if(!isset($messageIcon) || !$messageIcon)
            <a href="#"
                class="relative text-amber-500 dark:text-amber-400 hover:text-amber-600 dark:hover:text-amber-300 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
            </a>
        @endif

        @if(isset($header))
            {{ $header }}
        @endif

        @if(!isset($hideDropdown) || !$hideDropdown)
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-amber-500 dark:text-amber-400 bg-white dark:bg-gray-800 hover:text-amber-600 dark:hover:text-amber-300 focus:outline-none transition ease-in-out duration-150">

                        @auth
                            <div>{{ Auth::user()->name }}</div>
                        @else
                            <div>Account</div>
                        @endauth

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4 text-amber-500 dark:text-amber-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @auth
                        <x-dropdown-link :href="route('profile.edit')"
                            class="!text-amber-500 dark:!text-amber-400 hover:!text-amber-600 dark:hover:!text-amber-300">{{ __('Profile') }}</x-dropdown-link>
                        @if(!isset($hideRoleMenu) || !$hideRoleMenu)
                            @if(Auth::check() && Auth::user()->role === 'vendor')
                                <x-dropdown-link :href="route('vendor.dashboard')"
                                    class="!text-amber-500 dark:!text-amber-400 hover:!text-amber-600 dark:hover:!text-amber-300">
                                    {{ __('Vendor Account') }}
                                </x-dropdown-link>
                            @elseif(Auth::check() && Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')"
                                    class="!text-amber-500 dark:!text-amber-400 hover:!text-amber-600 dark:hover:!text-amber-300">
                                    {{ __('Admin Account') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('vendor.register')"
                                    class="!text-amber-500 dark:!text-amber-400 hover:!text-amber-600 dark:hover:!text-amber-300">
                                    {{ __('Vendor Registration') }}
                                </x-dropdown-link>
                            @endif
                        @endif

                        @if(!isset($hideDarkMode) || !$hideDarkMode)
                            <div id="darkModeRow"
                                class="flex items-center gap-2 w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer select-none">

                                
                                <svg id="nightModeIcon" class="w-4 h-4 text-gray-400 block dark:hidden" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                    </path>
                                </svg>

                            
                                <svg id="dayModeIcon" class="w-4 h-4 text-yellow-500 hidden dark:block" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M6.343 6.343l.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>

                                
                                <span id="darkModeText" class="tracking-wide font-medium">Night Mode</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="!text-amber-500 dark:!text-amber-400 hover:!text-amber-600 dark:hover:!text-amber-300">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    @else
                        <x-dropdown-link :href="route('login')"
                            class="!text-amber-500 dark:!text-amber-400 hover:!text-amber-600 dark:hover:!text-amber-300">
                            {{ __('Login') }}
                        </x-dropdown-link>
                        @if (Route::has('register'))
                            <x-dropdown-link :href="route('register')"
                                class="!text-amber-500 dark:!text-amber-400 hover:!text-amber-600 dark:hover:!text-amber-300">
                                {{ __('Register') }}
                            </x-dropdown-link>
                        @endif
                        <?php        /*<div id="darkModeRow"
                                                            class="flex items-center gap-2 w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition ease-in-out duration-150 cursor-pointer select-none">

                                                            <!-- 🌙 Night Mode ပြောင်းရန် Icon (Light mode မှာပဲ ပြမည်) -->
                                                            <svg id="nightModeIcon" class="w-4 h-4 text-gray-400 block dark:hidden" fill="none"
                                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                                                </path>
                                                            </svg>

                                                            <!-- ☀️ Day Mode ပြောင်းရန် Icon (Dark mode မှာပဲ ပြမည်) -->
                                                            <svg id="dayModeIcon" class="w-4 h-4 text-yellow-500 hidden dark:block" fill="none"
                                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M6.343 6.343l.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                                </path>
                                                            </svg>

                                                            <!-- 📝 စာသားပြသမည့်နေရာ (JavaScript မှ Day Mode သို့မဟုတ် Night Mode ဟု အခြေအနေပေါ်မူတည်ပြီး ပြောင်းပေးမည်) -->
                                                            <span id="darkModeText" class="tracking-wide font-medium">Night Mode</span>
                                                        </div>*/ ?>
                    @endauth
                </x-slot>
            </x-dropdown>
        @endif
    </div>
</nav>