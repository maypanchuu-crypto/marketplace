<!DOCTYPE html>
<x-app-layout>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Dashboard</title>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>

        <style>
            html,
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            [x-cloak] {
                display: none !important;
            }
        </style>
    </head>

    <body x-data="{ 
        searchQuery: '',
        // Search လုပ်ရင် အကုန်ထဲက ရှာရအောင် trending ကော more ကောကို array တစ်ခုတည်း ပေါင်းထည့်ထားမယ်
        products: {{ json_encode($trendingProducts->merge($moreProducts)->unique('id')->map(function ($product) {
    return [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description ?? 'No description available.',
        'price' => number_format($product->price) . ' MMK',
        'stock' => $product->stock,
        'image' => $product->image ? asset('storage/' . $product->image) : '',
        'url' => route('products.show', $product->id)
    ];
})) }},
                    
                    // Blade ဘက်က သီးသန့်လာတဲ့ Array ၂ ခုကို JavaScript ထဲ တိုက်ရိုက်သိမ်းထားမယ်
                    trendingProducts: {{ json_encode($trendingProducts->map(function ($product) {
    return [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description ?? 'No description available.',
        'price' => number_format($product->price) . ' MMK',
        'stock' => $product->stock,
        'image' => $product->image ? asset('storage/' . $product->image) : '',
        'url' => route('products.show', $product->id)
    ];
})) }},

                    moreProducts: {{ json_encode($moreProducts->map(function ($product) {
    return [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description ?? 'No description available.',
        'price' => number_format($product->price) . ' MMK',
        'stock' => $product->stock,
        'image' => $product->image ? asset('storage/' . $product->image) : '',
        'url' => route('products.show', $product->id)
    ];
})) }},

                    get filteredProducts() {
                        if (this.searchQuery.trim() === '') {
                            return [];
                        }
                        return this.products.filter(p => 
                            p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            p.description.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    }
                }" @product-search.window="searchQuery = $event.detail"
        class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen pb-24 relative overflow-x-hidden">

        <div id="sidebarOverlay"
            class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300 overflow-y-auto">
        </div>
        <div id="sidebar"
            class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Menu</h2>
                    <button id="closeBtn" class="text-gray-500 hover:text-gray-800 dark:hover:text-white p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-bold text-sm">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Home
                    </a>

                    @if(Auth::check() && Auth::user()->role === 'vendor')
                        <a href="{{ route('vendor.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Vendor Account
                        </a>
                    @elseif(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Admin Account
                        </a>
                    @else
                        <a href="{{ route('vendor.register') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            Vendor Registration
                        </a>
                    @endif

                    <div id="darkModeRow"
                        class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm cursor-pointer select-none">
                        <span class="flex items-center gap-3 tracking-wide">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                </path>
                            </svg>
                            Dark Mode
                        </span>
                        <div class="relative w-9 h-5 flex-shrink-0 pointer-events-none">
                            <input type="checkbox" id="darkModeToggle" class="sr-only peer">
                            <div
                                class="absolute inset-0 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4">
                            </div>
                        </div>
                    </div>

                    <!-- <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        Messages
                    </a> -->
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}"
                class="border-t border-gray-100 dark:border-gray-700 pt-4">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 font-medium text-sm text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

        <main class="max-w-7xl mx-auto px-4 pt-6 pb-36">

            <template x-if="searchQuery.trim() !== ''">
                <div>
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-wide">
                            Search Results for '<span x-text="searchQuery" class="text-blue-600"></span>'
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        <template x-for="product in filteredProducts" :key="'search-' + product.id">
                            <a :href="product.url" class="block">
                                <div
                                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl flex flex-col justify-between transform transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden relative h-full">

                                    <div
                                        class="w-full h-64 bg-gray-50 dark:bg-gray-700/20 relative flex items-center justify-center border-b border-gray-200 dark:border-gray-700/70 overflow-hidden flex-shrink-0 p-3">
                                        <template x-if="product.image">
                                            <img :src="product.image" :alt="product.name"
                                                class="max-w-full max-h-full w-auto h-auto object-contain mx-auto">
                                        </template>
                                        <template x-if="!product.image">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </template>
                                    </div>

                                    <div class="p-4 flex flex-col flex-grow justify-between mt-auto">
                                        <div class="mb-3">
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug mb-1 truncate"
                                                x-text="product.name"></h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 min-h-[2rem]"
                                                x-text="product.description"></p>
                                        </div>
                                        <div
                                            class="mt-auto pt-2 flex-shrink-0 border-t border-gray-100 dark:border-gray-700/50">
                                            <div class="text-blue-600 dark:text-blue-400 font-extrabold text-sm mb-1"
                                                x-text="product.price"></div>
                                            <div class="flex justify-between items-center text-[11px]">
                                                <span class="text-gray-400">Stock: <strong
                                                        class="text-gray-700 dark:text-gray-300 font-semibold"
                                                        x-text="product.stock"></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </div>
                    <div x-show="filteredProducts.length === 0" class="text-center py-12 text-gray-400">
                        <span>No products found</span>
                    </div>
                </div>
            </template>

            <template x-if="searchQuery.trim() === ''">
                <div class="space-y-10">

                    <div>
                        <div>
                            {{ session('success') }}
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-wide">Trending Products
                            </h3>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-5">
                            <template x-for="product in trendingProducts" :key="'trending-' + product.id">
                                <a :href="product.url" class="block">
                                    <div
                                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl flex flex-col justify-between transform transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden relative h-full">
                                        <div
                                            class="w-full h-48 bg-gray-100 dark:bg-gray-700 relative flex items-center justify-center border-b border-gray-200 dark:border-gray-700/70 overflow-hidden flex-shrink-0">
                                            <template x-if="product.image"><img :src="product.image" :alt="product.name"
                                                    class="w-full h-full object-cover"></template>
                                            <template x-if="!product.image">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </template>
                                        </div>
                                        <div class="p-4 flex flex-col flex-grow justify-between">
                                            <div>
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug mb-1 truncate"
                                                    x-text="product.name"></h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-2 min-h-[2rem]"
                                                    x-text="product.description"></p>
                                            </div>
                                            <div class="mt-2 flex-shrink-0">
                                                <div class="text-blue-600 dark:text-blue-400 font-extrabold text-sm mb-2"
                                                    x-text="product.price"></div>
                                                <div class="flex justify-between items-center text-[11px]"><span
                                                        class="text-gray-400">Stock: <strong
                                                            class="text-gray-700 dark:text-gray-300 font-semibold"
                                                            x-text="product.stock"></strong></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>

                    <div>
                        <div class="mb-4 border-t border-gray-100 dark:border-gray-800 pt-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-wide">More Products</h3>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-5">
                            <template x-for="product in moreProducts" :key="'more-' + product.id">
                                <a :href="product.url" class="block">
                                    <div
                                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl flex flex-col justify-between transform transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden relative h-full">
                                        <div
                                            class="w-full h-48 bg-gray-100 dark:bg-gray-700 relative flex items-center justify-center border-b border-gray-200 dark:border-gray-700/70 overflow-hidden flex-shrink-0">
                                            <template x-if="product.image"><img :src="product.image" :alt="product.name"
                                                    class="w-full h-full object-cover"></template>
                                            <template x-if="!product.image">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </template>
                                        </div>
                                        <div class="p-4 flex flex-col flex-grow justify-between">
                                            <div>
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug mb-1 truncate"
                                                    x-text="product.name"></h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-2 min-h-[2rem]"
                                                    x-text="product.description"></p>
                                            </div>
                                            <div class="mt-2 flex-shrink-0">
                                                <div class="text-blue-600 dark:text-blue-400 font-extrabold text-sm mb-2"
                                                    x-text="product.price"></div>
                                                <div class="flex justify-between items-center text-[11px]">
                                                    <span class="text-gray-400">Stock: <strong
                                                            class="text-gray-700 dark:text-gray-300 font-semibold"
                                                            x-text="product.stock"></strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>

                </div>
            </template>
        </main>

        <div
            class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg px-6 py-2 flex justify-around items-center z-40">
            <a href="#"
                class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10zM9 14h6v7H9v-7z"></path>
                </svg>
                <span class="text-[10px] font-medium">Shops</span>
            </a>

            <a href="{{ route('cart.index') }}"
                class="flex flex-col items-center gap-0.5 text-blue-600 dark:text-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z">
                    </path>
                </svg>
                <span class="text-[10px] font-medium">Cart</span>
            </a>

            <a href="#"
                class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                <span class="text-[10px] font-medium">Order History</span>
            </a>

            <a href="#"
                class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <span class="text-[10px] font-medium">Message</span>
            </a>

        </div>

        <script>
            const menuBtn = document.getElementById('menuBtn');
            const closeBtn = document.getElementById('closeBtn');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const darkModeRow = document.getElementById('darkModeRow');
            const darkModeToggle = document.getElementById('darkModeToggle');

            // Sidebar Open/Close Logic
            menuBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            });

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            };
            closeBtn.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);

            // Dark Mode Function
            function updateTheme(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    darkModeToggle.checked = true;
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    darkModeToggle.checked = false;
                }
            }

            // Init Dark Mode
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                updateTheme(true);
            } else {
                updateTheme(false);
            }

            // Toggle Dark Mode Event
            darkModeRow.addEventListener('click', () => {
                updateTheme(!darkModeToggle.checked);
            });
        </script>
    </body>

    </html>
</x-app-layout>