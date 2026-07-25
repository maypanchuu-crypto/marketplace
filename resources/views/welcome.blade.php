<?php /*
<!DOCTYPE html>
<x-app-layout :messageIcon="true">
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
    </body>

    </html>
</x-app-layout>
*/ ?>
