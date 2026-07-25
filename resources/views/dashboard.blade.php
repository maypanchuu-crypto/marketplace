<!DOCTYPE html>
@auth
<x-app-layout :menuBtn="true">
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Dashboard</title>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script> -->

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

        <?php /* <div id="sidebarOverlay"
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

                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Orders
                    </a>

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
        </div> */ ?>

        <main class="max-w-7xl mx-auto px-4 pt-10 pb-36 font-sans" x-data="{ 
                  chunkSize: window.innerWidth < 640 ? 3 : 6,
                  init() {
                      window.addEventListener('resize', () => {
                          this.chunkSize = window.innerWidth < 640 ? 3 : 6;
                      });
                  }
              }">
              
            @guest
            <div class="mb-10 relative overflow-hidden bg-gradient-to-r from-amber-500 via-orange-600 to-red-600 text-white rounded-2xl shadow-xl border border-white/10 transform transition-all duration-300 hover:scale-[1.01]">
                <!-- Background Decorative Blobs -->
                <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-40 h-40 bg-pink-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="px-6 py-8 sm:p-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative z-10">
                    <div class="space-y-2 max-w-2xl">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm tracking-wide uppercase">
                            🚀 Become a Seller
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                            ယခုပဲ Account ဖွင့်ပြီး သင့်ပစ္စည်းများကို စတင်ရောင်းချလိုက်ပါ!
                        </h2>
                        <!-- 💡 text-white ဖြစ်အောင် ပြောင်းလဲထားပြီး စာသားကို လင်းထိန်သွားစေပါသည် -->
                        <p class="text-xs sm:text-sm text-white leading-relaxed font-medium">
                            ရိုးရှင်းလွယ်ကူတဲ့ Register အဆင့်ဆင့်ကို ဖြည့်စွက်ပြီးတာနဲ့ သာမန်ဝယ်ယူသူအဆင့်မှတစ်ဆင့် နောင်တွင် ကိုယ်ပိုင်ဆိုင်ခန်းဖွင့်လှစ်ပြီး <span class="text-yellow-300 font-extrabold">Vendor (အရောင်းဆိုင်ရှင်)</span> တစ်ဦးအဖြစ်ပါ တိုးမြှင့်လုပ်ဆောင်နိုင်ခွင့် ရရှိလာမှာဖြစ်ပါတယ်။
                        </p>
                    </div>
                    
                    <!-- <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('register') }}" 
                           class="px-5 py-3 text-xs sm:text-sm font-extrabold bg-white text-indigo-700 hover:bg-blue-50 hover:text-blue-800 rounded-xl shadow-lg transition-all duration-200 active:scale-95 text-center w-full sm:w-auto">
                            Register လုပ်ရန်
                        </a>
                        <a href="{{ route('login') }}" 
                           class="px-5 py-3 text-xs sm:text-sm font-bold bg-transparent border border-white/40 hover:bg-white/10 rounded-xl transition-all duration-200 text-center w-full sm:w-auto">
                            Sign In
                        </a>
                    </div> -->
                </div>
            </div>
            @endguest

            <!-- ==================== (၁) SEARCH RESULTS SECTION ==================== -->
            <template x-if="searchQuery.trim() !== ''">
                <div>
                    <div class="mb-6">
                        <h3 class="text-xl font-extrabold text-gray-800 dark:text-white tracking-wide">
                            Search Results for '<span x-text="searchQuery" class="text-blue-600"></span>'
                        </h3>
                    </div>

                    <!-- Search Results Loop -->
                    <template
                        x-for="(rowProducts, rowIndex) in Array.from({ length: Math.ceil(filteredProducts.length / chunkSize) }, (_, i) => filteredProducts.slice(i * chunkSize, (i + 1) * chunkSize))"
                        :key="'search-row-' + rowIndex">
                        <div class="relative px-2 sm:px-12 pt-6 pb-20 mb-12">
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-x-2 sm:gap-x-6 relative z-10 w-full">
                                <template x-for="product in rowProducts" :key="'search-' + product.id">
                                    <div class="relative h-24 sm:h-44 w-full flex flex-col items-center group">
                                        <!-- 💡 group ခံထားဆဲဖြစ်သည် -->

                                        <!-- 📦 Product Image Container -->
                                        <!-- 💡 group-hover: လှုပ်ရှားမှုကို ဤ Image ဘောင်တစ်ခုတည်းတွင်သာ ထည့်သွင်းထားသဖြင့် မည်သည့်နေရာကို cursor တင်တင် ပုံပဲ လှုပ်မည် -->
                                        <a :href="product.url"
                                            class="absolute bottom-[-25px] sm:bottom-[16px] w-20 sm:w-36 h-16 sm:h-36 bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl p-0.5 sm:p-1 overflow-hidden shadow-md transform transition-all duration-300 group-hover:-translate-y-1 sm:group-hover:-translate-y-2 z-10">
                                            <div
                                                class="absolute inset-0 p-[1px] sm:p-[1.5px] bg-gradient-to-tr from-pink-500 via-purple-500 via-cyan-500 to-yellow-400 rounded-lg sm:rounded-xl opacity-100">
                                                <div
                                                    class="w-full h-full bg-white dark:bg-gray-800 rounded-[7px] sm:rounded-[10px] flex items-center justify-center p-1 sm:p-2">
                                                    <template x-if="product.image">
                                                        <img :src="product.image" :alt="product.name"
                                                            class="max-w-full max-h-full object-contain">
                                                    </template>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- 🏷️ Price Tag (<a> link ဖြစ်ပြီး transform / hover animation ကုဒ်များ ဖြုတ်ထားသဖြင့် လုံးဝ မလှုပ်ဘဲ ငြိမ်နေမည်) -->
                                        <a :href="product.url"
                                            class="absolute bottom-[-65px] sm:bottom-[-48px] w-[90%] sm:w-[85%] h-6 sm:h-12 bg-white border border-gray-200 shadow-md rounded flex flex-col justify-center items-center leading-none sm:leading-tight px-0.5 z-20">
                                            <div class="text-[7px] sm:text-[10px] font-extrabold text-gray-800 truncate w-full text-center"
                                                x-text="product.name"></div>
                                            <div class="text-[8px] sm:text-[11px] font-black text-red-600 tracking-tight"
                                                x-text="product.price"></div>
                                        </a>

                                    </div>
                                </template>
                            </div>

                            <!-- 🪵 🌈 3D RAINBOW SHELF COMPONENT -->
                            <div class="absolute bottom-6 sm:bottom-12 left-0 right-0 z-0 [perspective:1000px]">
                                <div
                                    class="w-full h-10 sm:h-20 bg-gradient-to-r from-red-500/80 via-yellow-500/80 via-green-500/80 via-blue-500/80 to-purple-500/80 shadow-inner border-t border-white/30 [transform:rotateX(55deg)] rounded-t-sm origin-bottom">
                                </div>
                                <div
                                    class="w-full h-4 sm:h-8 bg-gradient-to-r from-red-600 via-yellow-600 via-green-600 via-blue-600 to-purple-600 border-t border-white/20 shadow-lg rounded-b-sm">
                                </div>
                            </div>
                        </div>
                    </template>

                    <div x-show="filteredProducts.length === 0" class="text-center py-12 text-gray-400">
                        <span>No products found</span>
                    </div>
                </div>
            </template>


            <!-- ==================== (၂) REGULAR PRODUCTS DISPLAY ==================== -->
            <template x-if="searchQuery.trim() === ''">
                <div class="space-y-6 sm:space-y-12">

                    <!-- 🔥 ROW 1: TRENDING PRODUCTS SECTION -->
                    <div class="relative">
                        <div class="mb-4 border-b-2 border-gray-200 dark:border-gray-700/50 pb-2">
                            <h3
                                class="text-lg sm:text-xl font-black text-gray-800 dark:text-white tracking-wider uppercase flex items-center gap-2">
                                <span class="w-2 h-5 sm:w-2.5 sm:h-6 bg-red-500 rounded-full inline-block"></span>
                                Trending Products
                            </h3>
                        </div>

                        <template
                            x-for="(rowProducts, rowIndex) in Array.from({ length: Math.ceil(trendingProducts.length / chunkSize) }, (_, i) => trendingProducts.slice(i * chunkSize, (i + 1) * chunkSize))"
                            :key="'trending-row-' + rowIndex">
                            <div class="relative px-2 sm:px-12 pt-6 pb-20 mb-4 sm:mb-8">
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-x-2 sm:gap-x-6 relative z-10 w-full">
                                    <template x-for="product in rowProducts" :key="'trending-' + product.id">
                                        <div class="relative h-24 sm:h-44 w-full flex flex-col items-center group">
                                            <!-- 💡 group ခံထားဆဲဖြစ်သည် -->

                                            <!-- 📦 Product Image Container -->
                                            <!-- 💡 group-hover: လှုပ်ရှားမှုကို ဤ Image ဘောင်တစ်ခုတည်းတွင်သာ ထည့်သွင်းထားသဖြင့် မည်သည့်နေရာကို cursor တင်တင် ပုံပဲ လှုပ်မည် -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-25px] sm:bottom-[16px] w-20 sm:w-36 h-16 sm:h-36 bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl p-0.5 sm:p-1 overflow-hidden shadow-md transform transition-all duration-300 group-hover:-translate-y-1 sm:group-hover:-translate-y-2 z-10">
                                                <div
                                                    class="absolute inset-0 p-[1px] sm:p-[1.5px] bg-gradient-to-tr from-pink-500 via-purple-500 via-cyan-500 to-yellow-400 rounded-lg sm:rounded-xl opacity-100">
                                                    <div
                                                        class="w-full h-full bg-white dark:bg-gray-800 rounded-[7px] sm:rounded-[10px] flex items-center justify-center p-1 sm:p-2">
                                                        <template x-if="product.image">
                                                            <img :src="product.image" :alt="product.name"
                                                                class="max-w-full max-h-full object-contain">
                                                        </template>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- 🏷️ Price Tag (<a> link ဖြစ်ပြီး transform / hover animation ကုဒ်များ ဖြုတ်ထားသဖြင့် လုံးဝ မလှုပ်ဘဲ ငြိမ်နေမည်) -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-65px] sm:bottom-[-48px] w-[90%] sm:w-[85%] h-6 sm:h-12 bg-white border border-gray-200 shadow-md rounded flex flex-col justify-center items-center leading-none sm:leading-tight px-0.5 z-20">
                                                <div class="text-[7px] sm:text-[10px] font-extrabold text-gray-800 truncate w-full text-center"
                                                    x-text="product.name"></div>
                                                <div class="text-[8px] sm:text-[11px] font-black text-red-600 tracking-tight"
                                                    x-text="product.price"></div>
                                            </a>

                                        </div>
                                    </template>
                                </div>

                                <!-- 🪵 🌈 စင်ပုံစံအပြား -->
                                <div class="absolute bottom-6 sm:bottom-12 left-0 right-0 z-0 [perspective:1000px]">
                                    <div
                                        class="w-full h-10 sm:h-20 bg-gradient-to-r from-red-500/80 via-yellow-500/80 via-green-500/80 via-blue-500/80 to-purple-500/80 shadow-inner border-t border-white/30 [transform:rotateX(55deg)] rounded-t-sm origin-bottom">
                                    </div>
                                    <div
                                        class="w-full h-4 sm:h-8 bg-gradient-to-r from-red-600 via-yellow-600 via-green-600 via-blue-600 to-purple-600 border-t border-white/20 shadow-lg rounded-b-sm">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- 🌿 ROW 2: MORE PRODUCTS SECTION -->
                    <div class="relative">
                        <div class="mb-4 border-b-2 border-gray-200 dark:border-gray-700/50 pb-2">
                            <h3
                                class="text-lg sm:text-xl font-black text-gray-800 dark:text-white tracking-wider uppercase flex items-center gap-2">
                                <span class="w-2 h-5 sm:w-2.5 sm:h-6 bg-blue-500 rounded-full inline-block"></span>
                                More Products
                            </h3>
                        </div>

                        <template
                            x-for="(rowProducts, rowIndex) in Array.from({ length: Math.ceil(moreProducts.length / chunkSize) }, (_, i) => moreProducts.slice(i * chunkSize, (i + 1) * chunkSize))"
                            :key="'more-row-' + rowIndex">
                            <div class="relative px-2 sm:px-12 pt-6 pb-20 mb-4 sm:mb-8">
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-x-2 sm:gap-x-6 relative z-10 w-full">
                                    <template x-for="product in rowProducts" :key="'more-' + product.id">
                                        <div class="relative h-24 sm:h-44 w-full flex flex-col items-center group">
                                            <!-- 💡 group ခံထားဆဲဖြစ်သည် -->

                                            <!-- 📦 Product Image Container -->
                                            <!-- 💡 group-hover: လှုပ်ရှားမှုကို ဤ Image ဘောင်တစ်ခုတည်းတွင်သာ ထည့်သွင်းထားသဖြင့် မည်သည့်နေရာကို cursor တင်တင် ပုံပဲ လှုပ်မည် -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-25px] sm:bottom-[16px] w-20 sm:w-36 h-16 sm:h-36 bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl p-0.5 sm:p-1 overflow-hidden shadow-md transform transition-all duration-300 group-hover:-translate-y-1 sm:group-hover:-translate-y-2 z-10">
                                                <div
                                                    class="absolute inset-0 p-[1px] sm:p-[1.5px] bg-gradient-to-tr from-pink-500 via-purple-500 via-cyan-500 to-yellow-400 rounded-lg sm:rounded-xl opacity-100">
                                                    <div
                                                        class="w-full h-full bg-white dark:bg-gray-800 rounded-[7px] sm:rounded-[10px] flex items-center justify-center p-1 sm:p-2">
                                                        <template x-if="product.image">
                                                            <img :src="product.image" :alt="product.name"
                                                                class="max-w-full max-h-full object-contain">
                                                        </template>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- 🏷️ Price Tag (<a> link ဖြစ်ပြီး transform / hover animation ကုဒ်များ ဖြုတ်ထားသဖြင့် လုံးဝ မလှုပ်ဘဲ ငြိမ်နေမည်) -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-65px] sm:bottom-[-48px] w-[90%] sm:w-[85%] h-6 sm:h-12 bg-white border border-gray-200 shadow-md rounded flex flex-col justify-center items-center leading-none sm:leading-tight px-0.5 z-20">
                                                <div class="text-[7px] sm:text-[10px] font-extrabold text-gray-800 truncate w-full text-center"
                                                    x-text="product.name"></div>
                                                <div class="text-[8px] sm:text-[11px] font-black text-red-600 tracking-tight"
                                                    x-text="product.price"></div>
                                            </a>

                                        </div>
                                    </template>
                                </div>

                                <!-- 🪵 🌈 စင်ပုံစံအပြား -->
                                <div class="absolute bottom-6 sm:bottom-12 left-0 right-0 z-0 [perspective:1000px]">
                                    <div
                                        class="w-full h-10 sm:h-20 bg-gradient-to-r from-red-500/80 via-yellow-500/80 via-green-500/80 via-blue-500/80 to-purple-500/80 shadow-inner border-t border-white/30 [transform:rotateX(55deg)] rounded-t-sm origin-bottom">
                                    </div>
                                    <div
                                        class="w-full h-4 sm:h-8 bg-gradient-to-r from-red-600 via-yellow-600 via-green-600 via-blue-600 to-purple-600 border-t border-white/20 shadow-lg rounded-b-sm">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                </div>
            </template>
        </main>

        <!-- <div
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

            <a href="{{ route('message.index') }}"
                class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <span class="text-[10px] font-medium">Message</span>
            </a>

        </div> -->

        <!-- <script>
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
        </script> -->
        <script>
            const darkModeRow = document.getElementById('darkModeRow');
            const darkModeText = document.getElementById('darkModeText');

            function updateTheme(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    // 💡 Dark Mode ဖြစ်သွားရင် နောက်တစ်ကြိမ် နှိပ်ရင် Day Mode (Light) ပြောင်းရမှာမို့ "Day Mode" ဟု ပြောင်းပြထားမည်
                    if (darkModeText) darkModeText.textContent = 'Day Mode';
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    // 💡 Light Mode ဖြစ်သွားရင် နောက်တစ်ကြိမ် နှိပ်ရင် Night Mode (Dark) ပြောင်းရမှာမို့ "Night Mode" ဟု ပြောင်းပြထားမည်
                    if (darkModeText) darkModeText.textContent = 'Night Mode';
                }
            }

            // Init Theme (ပထမဆုံး ဝင်လာချိန် စစ်ဆေးခြင်း)[cite: 5]
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                updateTheme(true);
            } else {
                updateTheme(false);
            }

            // Click Event (ကလစ်နှိပ်လိုက်လျှင် လက်ရှိ theme ကို ပြောင်းပြန်လှန်ပစ်မည်)[cite: 5]
            if (darkModeRow) {
                darkModeRow.addEventListener('click', () => {
                    const isCurrentlyDark = document.documentElement.classList.contains('dark');
                    updateTheme(!isCurrentlyDark);
                });
            }
        </script>
    </body>

    </html>
</x-app-layout>
@endauth

@guest
<!DOCTYPE html>
<x-app-layout :messageIcon="true" :menuBtn="true">
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Marketplace</title>

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

    <body
        x-data="{ searchQuery: '', products: {{ json_encode($trendingProducts->merge($moreProducts)->unique('id')->map(function ($product) {
    return ['id' => $product->id, 'name' => $product->name, 'description' => $product->description ?? 'No description available.', 'price' => number_format($product->price) . ' MMK', 'stock' => $product->stock, 'image' => $product->image ? asset('storage/' . $product->image) : '', 'url' => route('products.show', $product->id)]; })) }}, trendingProducts: {{ json_encode($trendingProducts->map(function ($product) {
    return ['id' => $product->id, 'name' => $product->name, 'description' => $product->description ?? 'No description available.', 'price' => number_format($product->price) . ' MMK', 'stock' => $product->stock, 'image' => $product->image ? asset('storage/' . $product->image) : '', 'url' => route('products.show', $product->id)]; })) }}, moreProducts: {{ json_encode($moreProducts->map(function ($product) {
    return ['id' => $product->id, 'name' => $product->name, 'description' => $product->description ?? 'No description available.', 'price' => number_format($product->price) . ' MMK', 'stock' => $product->stock, 'image' => $product->image ? asset('storage/' . $product->image) : '', 'url' => route('products.show', $product->id)]; })) }}, get filteredProducts() { if (this.searchQuery.trim() === '') { return []; } return this.products.filter(p => p.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || p.description.toLowerCase().includes(this.searchQuery.toLowerCase()) ); } }"
        @product-search.window="searchQuery = $event.detail"
        class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen pb-24 relative overflow-x-hidden">

        <main class="max-w-7xl mx-auto px-4 pt-10 pb-36 font-sans" x-data="{ 
                  chunkSize: window.innerWidth < 640 ? 3 : 6,
                  init() {
                      window.addEventListener('resize', () => {
                          this.chunkSize = window.innerWidth < 640 ? 3 : 6;
                      });
                  }
              }">
              
            @guest
            <div class="mb-10 relative overflow-hidden bg-gradient-to-r from-amber-500 via-orange-600 to-red-600 text-white rounded-2xl shadow-xl border border-white/10 transform transition-all duration-300 hover:scale-[1.01]">
                <!-- Background Decorative Blobs -->
                <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-40 h-40 bg-pink-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="px-6 py-8 sm:p-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative z-10">
                    <div class="space-y-2 max-w-2xl">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm tracking-wide uppercase">
                            🚀 Become a Seller
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                            ယခုပဲ Account ဖွင့်ပြီး သင့်ပစ္စည်းများကို စတင်ရောင်းချလိုက်ပါ!
                        </h2>
                        <!-- 💡 text-white ဖြစ်အောင် ပြောင်းလဲထားပြီး စာသားကို လင်းထိန်သွားစေပါသည် -->
                        <p class="text-xs sm:text-sm text-white leading-relaxed font-medium">
                            ရိုးရှင်းလွယ်ကူတဲ့ Register အဆင့်ဆင့်ကို ဖြည့်စွက်ပြီးတာနဲ့ သာမန်ဝယ်ယူသူအဆင့်မှတစ်ဆင့် နောင်တွင် ကိုယ်ပိုင်ဆိုင်ခန်းဖွင့်လှစ်ပြီး <span class="text-yellow-300 font-extrabold">Vendor (အရောင်းဆိုင်ရှင်)</span> တစ်ဦးအဖြစ်ပါ တိုးမြှင့်လုပ်ဆောင်နိုင်ခွင့် ရရှိလာမှာဖြစ်ပါတယ်။
                        </p>
                    </div>
                    
                    <!-- <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('register') }}" 
                           class="px-5 py-3 text-xs sm:text-sm font-extrabold bg-white text-indigo-700 hover:bg-blue-50 hover:text-blue-800 rounded-xl shadow-lg transition-all duration-200 active:scale-95 text-center w-full sm:w-auto">
                            Register လုပ်ရန်
                        </a>
                        <a href="{{ route('login') }}" 
                           class="px-5 py-3 text-xs sm:text-sm font-bold bg-transparent border border-white/40 hover:bg-white/10 rounded-xl transition-all duration-200 text-center w-full sm:w-auto">
                            Sign In
                        </a>
                    </div> -->
                </div>
            </div>
            @endguest

            <!-- ==================== (၁) SEARCH RESULTS SECTION ==================== -->
            <template x-if="searchQuery.trim() !== ''">
                <div>
                    <div class="mb-6">
                        <h3 class="text-xl font-extrabold text-gray-800 dark:text-white tracking-wide">
                            Search Results for '<span x-text="searchQuery" class="text-blue-600"></span>'
                        </h3>
                    </div>

                    <!-- Search Results Loop -->
                    <template
                        x-for="(rowProducts, rowIndex) in Array.from({ length: Math.ceil(filteredProducts.length / chunkSize) }, (_, i) => filteredProducts.slice(i * chunkSize, (i + 1) * chunkSize))"
                        :key="'search-row-' + rowIndex">
                        <div class="relative px-2 sm:px-12 pt-6 pb-20 mb-12">
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-x-2 sm:gap-x-6 relative z-10 w-full">
                                <template x-for="product in rowProducts" :key="'search-' + product.id">
                                    <div class="relative h-24 sm:h-44 w-full flex flex-col items-center group">
                                        <!-- 💡 group ခံထားဆဲဖြစ်သည် -->

                                        <!-- 📦 Product Image Container -->
                                        <!-- 💡 group-hover: လှုပ်ရှားမှုကို ဤ Image ဘောင်တစ်ခုတည်းတွင်သာ ထည့်သွင်းထားသဖြင့် မည်သည့်နေရာကို cursor တင်တင် ပုံပဲ လှုပ်မည် -->
                                        <a :href="product.url"
                                            class="absolute bottom-[-25px] sm:bottom-[16px] w-20 sm:w-36 h-16 sm:h-36 bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl p-0.5 sm:p-1 overflow-hidden shadow-md transform transition-all duration-300 group-hover:-translate-y-1 sm:group-hover:-translate-y-2 z-10">
                                            <div
                                                class="absolute inset-0 p-[1px] sm:p-[1.5px] bg-gradient-to-tr from-pink-500 via-purple-500 via-cyan-500 to-yellow-400 rounded-lg sm:rounded-xl opacity-100">
                                                <div
                                                    class="w-full h-full bg-white dark:bg-gray-800 rounded-[7px] sm:rounded-[10px] flex items-center justify-center p-1 sm:p-2">
                                                    <template x-if="product.image">
                                                        <img :src="product.image" :alt="product.name"
                                                            class="max-w-full max-h-full object-contain">
                                                    </template>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- 🏷️ Price Tag (<a> link ဖြစ်ပြီး transform / hover animation ကုဒ်များ ဖြုတ်ထားသဖြင့် လုံးဝ မလှုပ်ဘဲ ငြိမ်နေမည်) -->
                                        <a :href="product.url"
                                            class="absolute bottom-[-65px] sm:bottom-[-48px] w-[90%] sm:w-[85%] h-6 sm:h-12 bg-white border border-gray-200 shadow-md rounded flex flex-col justify-center items-center leading-none sm:leading-tight px-0.5 z-20">
                                            <div class="text-[7px] sm:text-[10px] font-extrabold text-gray-800 truncate w-full text-center"
                                                x-text="product.name"></div>
                                            <div class="text-[8px] sm:text-[11px] font-black text-red-600 tracking-tight"
                                                x-text="product.price"></div>
                                        </a>

                                    </div>
                                </template>
                            </div>

                            <!-- 🪵 🌈 3D RAINBOW SHELF COMPONENT -->
                            <div class="absolute bottom-6 sm:bottom-12 left-0 right-0 z-0 [perspective:1000px]">
                                <div
                                    class="w-full h-10 sm:h-20 bg-gradient-to-r from-red-500/80 via-yellow-500/80 via-green-500/80 via-blue-500/80 to-purple-500/80 shadow-inner border-t border-white/30 [transform:rotateX(55deg)] rounded-t-sm origin-bottom">
                                </div>
                                <div
                                    class="w-full h-4 sm:h-8 bg-gradient-to-r from-red-600 via-yellow-600 via-green-600 via-blue-600 to-purple-600 border-t border-white/20 shadow-lg rounded-b-sm">
                                </div>
                            </div>
                        </div>
                    </template>

                    <div x-show="filteredProducts.length === 0" class="text-center py-12 text-gray-400">
                        <span>No products found</span>
                    </div>
                </div>
            </template>


            <!-- ==================== (၂) REGULAR PRODUCTS DISPLAY ==================== -->
            <template x-if="searchQuery.trim() === ''">
                <div class="space-y-6 sm:space-y-12">

                    <!-- 🔥 ROW 1: TRENDING PRODUCTS SECTION -->
                    <div class="relative">
                        <div class="mb-4 border-b-2 border-gray-200 dark:border-gray-700/50 pb-2">
                            <h3
                                class="text-lg sm:text-xl font-black text-gray-800 dark:text-white tracking-wider uppercase flex items-center gap-2">
                                <span class="w-2 h-5 sm:w-2.5 sm:h-6 bg-red-500 rounded-full inline-block"></span>
                                Trending Products
                            </h3>
                        </div>

                        <template
                            x-for="(rowProducts, rowIndex) in Array.from({ length: Math.ceil(trendingProducts.length / chunkSize) }, (_, i) => trendingProducts.slice(i * chunkSize, (i + 1) * chunkSize))"
                            :key="'trending-row-' + rowIndex">
                            <div class="relative px-2 sm:px-12 pt-6 pb-20 mb-4 sm:mb-8">
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-x-2 sm:gap-x-6 relative z-10 w-full">
                                    <template x-for="product in rowProducts" :key="'trending-' + product.id">
                                        <div class="relative h-24 sm:h-44 w-full flex flex-col items-center group">
                                            <!-- 💡 group ခံထားဆဲဖြစ်သည် -->

                                            <!-- 📦 Product Image Container -->
                                            <!-- 💡 group-hover: လှုပ်ရှားမှုကို ဤ Image ဘောင်တစ်ခုတည်းတွင်သာ ထည့်သွင်းထားသဖြင့် မည်သည့်နေရာကို cursor တင်တင် ပုံပဲ လှုပ်မည် -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-25px] sm:bottom-[16px] w-20 sm:w-36 h-16 sm:h-36 bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl p-0.5 sm:p-1 overflow-hidden shadow-md transform transition-all duration-300 group-hover:-translate-y-1 sm:group-hover:-translate-y-2 z-10">
                                                <div
                                                    class="absolute inset-0 p-[1px] sm:p-[1.5px] bg-gradient-to-tr from-pink-500 via-purple-500 via-cyan-500 to-yellow-400 rounded-lg sm:rounded-xl opacity-100">
                                                    <div
                                                        class="w-full h-full bg-white dark:bg-gray-800 rounded-[7px] sm:rounded-[10px] flex items-center justify-center p-1 sm:p-2">
                                                        <template x-if="product.image">
                                                            <img :src="product.image" :alt="product.name"
                                                                class="max-w-full max-h-full object-contain">
                                                        </template>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- 🏷️ Price Tag (<a> link ဖြစ်ပြီး transform / hover animation ကုဒ်များ ဖြုတ်ထားသဖြင့် လုံးဝ မလှုပ်ဘဲ ငြိမ်နေမည်) -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-65px] sm:bottom-[-48px] w-[90%] sm:w-[85%] h-6 sm:h-12 bg-white border border-gray-200 shadow-md rounded flex flex-col justify-center items-center leading-none sm:leading-tight px-0.5 z-20">
                                                <div class="text-[7px] sm:text-[10px] font-extrabold text-gray-800 truncate w-full text-center"
                                                    x-text="product.name"></div>
                                                <div class="text-[8px] sm:text-[11px] font-black text-red-600 tracking-tight"
                                                    x-text="product.price"></div>
                                            </a>

                                        </div>
                                    </template>
                                </div>

                                <!-- 🪵 🌈 စင်ပုံစံအပြား -->
                                <div class="absolute bottom-6 sm:bottom-12 left-0 right-0 z-0 [perspective:1000px]">
                                    <div
                                        class="w-full h-10 sm:h-20 bg-gradient-to-r from-red-500/80 via-yellow-500/80 via-green-500/80 via-blue-500/80 to-purple-500/80 shadow-inner border-t border-white/30 [transform:rotateX(55deg)] rounded-t-sm origin-bottom">
                                    </div>
                                    <div
                                        class="w-full h-4 sm:h-8 bg-gradient-to-r from-red-600 via-yellow-600 via-green-600 via-blue-600 to-purple-600 border-t border-white/20 shadow-lg rounded-b-sm">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- 🌿 ROW 2: MORE PRODUCTS SECTION -->
                    <div class="relative">
                        <div class="mb-4 border-b-2 border-gray-200 dark:border-gray-700/50 pb-2">
                            <h3
                                class="text-lg sm:text-xl font-black text-gray-800 dark:text-white tracking-wider uppercase flex items-center gap-2">
                                <span class="w-2 h-5 sm:w-2.5 sm:h-6 bg-blue-500 rounded-full inline-block"></span>
                                More Products
                            </h3>
                        </div>

                        <template
                            x-for="(rowProducts, rowIndex) in Array.from({ length: Math.ceil(moreProducts.length / chunkSize) }, (_, i) => moreProducts.slice(i * chunkSize, (i + 1) * chunkSize))"
                            :key="'more-row-' + rowIndex">
                            <div class="relative px-2 sm:px-12 pt-6 pb-20 mb-4 sm:mb-8">
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-x-2 sm:gap-x-6 relative z-10 w-full">
                                    <template x-for="product in rowProducts" :key="'more-' + product.id">
                                        <div class="relative h-24 sm:h-44 w-full flex flex-col items-center group">
                                            <!-- 💡 group ခံထားဆဲဖြစ်သည် -->

                                            <!-- 📦 Product Image Container -->
                                            <!-- 💡 group-hover: လှုပ်ရှားမှုကို ဤ Image ဘောင်တစ်ခုတည်းတွင်သာ ထည့်သွင်းထားသဖြင့် မည်သည့်နေရာကို cursor တင်တင် ပုံပဲ လှုပ်မည် -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-25px] sm:bottom-[16px] w-20 sm:w-36 h-16 sm:h-36 bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl p-0.5 sm:p-1 overflow-hidden shadow-md transform transition-all duration-300 group-hover:-translate-y-1 sm:group-hover:-translate-y-2 z-10">
                                                <div
                                                    class="absolute inset-0 p-[1px] sm:p-[1.5px] bg-gradient-to-tr from-pink-500 via-purple-500 via-cyan-500 to-yellow-400 rounded-lg sm:rounded-xl opacity-100">
                                                    <div
                                                        class="w-full h-full bg-white dark:bg-gray-800 rounded-[7px] sm:rounded-[10px] flex items-center justify-center p-1 sm:p-2">
                                                        <template x-if="product.image">
                                                            <img :src="product.image" :alt="product.name"
                                                                class="max-w-full max-h-full object-contain">
                                                        </template>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- 🏷️ Price Tag (<a> link ဖြစ်ပြီး transform / hover animation ကုဒ်များ ဖြုတ်ထားသဖြင့် လုံးဝ မလှုပ်ဘဲ ငြိမ်နေမည်) -->
                                            <a :href="product.url"
                                                class="absolute bottom-[-65px] sm:bottom-[-48px] w-[90%] sm:w-[85%] h-6 sm:h-12 bg-white border border-gray-200 shadow-md rounded flex flex-col justify-center items-center leading-none sm:leading-tight px-0.5 z-20">
                                                <div class="text-[7px] sm:text-[10px] font-extrabold text-gray-800 truncate w-full text-center"
                                                    x-text="product.name"></div>
                                                <div class="text-[8px] sm:text-[11px] font-black text-red-600 tracking-tight"
                                                    x-text="product.price"></div>
                                            </a>

                                        </div>
                                    </template>
                                </div>

                                <!-- 🪵 🌈 စင်ပုံစံအပြား -->
                                <div class="absolute bottom-6 sm:bottom-12 left-0 right-0 z-0 [perspective:1000px]">
                                    <div
                                        class="w-full h-10 sm:h-20 bg-gradient-to-r from-red-500/80 via-yellow-500/80 via-green-500/80 via-blue-500/80 to-purple-500/80 shadow-inner border-t border-white/30 [transform:rotateX(55deg)] rounded-t-sm origin-bottom">
                                    </div>
                                    <div
                                        class="w-full h-4 sm:h-8 bg-gradient-to-r from-red-600 via-yellow-600 via-green-600 via-blue-600 to-purple-600 border-t border-white/20 shadow-lg rounded-b-sm">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                </div>
            </template>
        </main>
        <script>
            const darkModeRow = document.getElementById('darkModeRow');
            const darkModeText = document.getElementById('darkModeText');

            function updateTheme(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    // 💡 Dark Mode ဖြစ်သွားရင် နောက်တစ်ကြိမ် နှိပ်ရင် Day Mode (Light) ပြောင်းရမှာမို့ "Day Mode" ဟု ပြောင်းပြထားမည်
                    if (darkModeText) darkModeText.textContent = 'Day Mode';
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    // 💡 Light Mode ဖြစ်သွားရင် နောက်တစ်ကြိမ် နှိပ်ရင် Night Mode (Dark) ပြောင်းရမှာမို့ "Night Mode" ဟု ပြောင်းပြထားမည်
                    if (darkModeText) darkModeText.textContent = 'Night Mode';
                }
            }

            // Init Theme (ပထမဆုံး ဝင်လာချိန် စစ်ဆေးခြင်း)[cite: 5]
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                updateTheme(true);
            } else {
                updateTheme(false);
            }

            // Click Event (ကလစ်နှိပ်လိုက်လျှင် လက်ရှိ theme ကို ပြောင်းပြန်လှန်ပစ်မည်)[cite: 5]
            if (darkModeRow) {
                darkModeRow.addEventListener('click', () => {
                    const isCurrentlyDark = document.documentElement.classList.contains('dark');
                    updateTheme(!isCurrentlyDark);
                });
            }
        </script>
    </body>

    </html>
</x-app-layout>
@endguest