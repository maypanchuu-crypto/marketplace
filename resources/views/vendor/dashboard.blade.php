<!DOCTYPE html>
<x-app-layout :hideSearch="true" :cartIcon="true" :messageIcon="true" :hideRoleMenu="true" :hideDropdown="true">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="text-base font-black tracking-wide text-orange-500 dark:text-orange-400">
                {{ $vendor->shop_name }}
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 ml-1"></span>
            </h2>
        </div>
    </x-slot>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vendor Dashboard - {{ $vendor->shop_name }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            html,
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            /* 💡 Browsers အားလုံးအတွက် Scrollbar ဖျောက်ရန် */
            ::-webkit-scrollbar {
                display: none;
            }

            html,
            body {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            /* 💡 Body, App Wrapper နှင့် Sidebar အရောင် */
            body,
            div.min-h-screen,
            #sidebar {
                background-color: #d1fae5 !important;
                /* Fresh Emerald 100 */
            }

            /* Dark Mode အတွက် */
            html.dark body,
            html.dark div.min-h-screen,
            html.dark #sidebar {
                background-color: #064e3b !important;
                /* Dark Fresh Emerald 900 */
            }

            /* 💡 3D Solid Block Buttons */
            .btn-3d {
                transition: all 0.15s ease;
                border: 2px solid #065f46;
                box-shadow: 3px 4px 0px 0px #065f46;
            }

            .btn-3d:hover {
                transform: translateY(-2px);
                box-shadow: 4px 6px 0px 0px #065f46;
            }

            .btn-3d:active {
                transform: translateY(2px);
                box-shadow: 1px 1px 0px 0px #065f46;
            }

            html.dark .btn-3d {
                border-color: #a7f3d0;
                box-shadow: 3px 4px 0px 0px #a7f3d0;
            }
        </style>
    </head>

    <body
        class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen pb-24 relative overflow-x-hidden">

        <div id="sidebarOverlay"
            class="fixed top-[65px] left-0 right-0 bottom-0 bg-black/40 z-30 hidden transition-opacity duration-300">
        </div>

        <!-- 💡 Sidebar Section (3D Styled) -->
        <div id="sidebar"
            class="fixed top-[65px] left-0 h-[calc(100vh-65px)] w-64 bg-white dark:bg-gray-800 z-30 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto border-r-4 border-emerald-800 dark:border-emerald-300">
            <div>
                <div
                    class="flex justify-between items-center mb-6 border-b-2 border-emerald-800 dark:border-emerald-300 pb-3">
                    <h2 class="text-xl font-black text-emerald-950 dark:text-emerald-100 tracking-wider uppercase">
                        Vendor Menu</h2>
                    <button id="closeBtn"
                        class="text-emerald-800 dark:text-emerald-200 p-1 hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}"
                        class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                        </svg>
                        Customer Marketplace
                    </a>

                    <a href="#"
                        class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        My Products
                    </a>

                    <a href="{{ route('vendor.orders.index') }}"
                        class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        My Shop Orders
                    </a>

                    <a href="#"
                        class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300 stroke-[2.5]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        Messages
                    </a>

                    <!-- 💡 Dark Mode Switch (navigation.blade.php ပုံစံအတိုင်း ပြင်ဆင်ထားပါသည်) -->
                    <div id="darkModeRow"
                        class="btn-3d flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white dark:bg-emerald-900 text-emerald-950 dark:text-emerald-100 font-black text-sm cursor-pointer select-none">

                        <!-- 🌙 Night Mode Icon (Light mode မှာပဲ ပြမည်) -->
                        <svg id="nightModeIcon" class="w-5 h-5 text-emerald-600 stroke-[2.5] block dark:hidden"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>

                        <!-- ☀️ Day Mode Icon (Dark mode မှာပဲ ပြမည်) -->
                        <svg id="dayModeIcon" class="w-5 h-5 text-yellow-400 stroke-[2.5] hidden dark:block" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M6.343 6.343l.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>

                        <!-- 📝 Dynamic Text (JavaScript မှ Control လုပ်မည်) -->
                        <span id="darkModeText" class="tracking-wide">Night Mode</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="pt-4">
                @csrf
                <button type="submit"
                    class="btn-3d w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-rose-500 text-white font-black text-sm text-left shadow-none">
                    <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

        <main class="max-w-6xl mx-auto px-4 py-8">

            <div class="mb-8">
                <h1 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">Welcome back,
                    {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Here is what's happening with your shop
                    **{{ $vendor->shop_name }}** today.</p>
            </div>

            <!-- 💡 3D Block Styled Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <!-- Total Earnings Card -->
                <div class="btn-3d bg-white dark:bg-emerald-900 p-5 rounded-2xl flex items-center justify-between">
                    <div>
                        <span
                            class="text-[11px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Total
                            Earnings</span>
                        <h3 class="text-2xl font-black text-orange-500 dark:text-orange-400 mt-1">
                            {{ number_format($totalEarnings) }} MMK
                        </h3>
                    </div>
                    <div
                        class="p-3 bg-orange-100 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 rounded-xl border-2 border-orange-500 shadow-[2px_3px_0px_0px_#f97316]">
                        <svg class="w-6 h-6 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- My Products Card -->
                <div class="btn-3d bg-white dark:bg-emerald-900 p-5 rounded-2xl flex items-center justify-between">
                    <div>
                        <span
                            class="text-[11px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">My
                            Products</span>
                        <h3 class="text-2xl font-black text-orange-500 dark:text-orange-400 mt-1">{{ $totalProducts }}
                            Items
                        </h3>
                    </div>
                    <div
                        class="p-3 bg-orange-100 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 rounded-xl border-2 border-orange-500 shadow-[2px_3px_0px_0px_#f97316]">
                        <svg class="w-6 h-6 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>

                <!-- Total Orders Card -->
                <div class="btn-3d bg-white dark:bg-emerald-900 p-5 rounded-2xl flex items-center justify-between">
                    <div>
                        <span
                            class="text-[11px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Total
                            Orders</span>
                        <h3 class="text-2xl font-black text-orange-500 dark:text-orange-400 mt-1">{{ $totalOrders }}
                            Orders
                        </h3>
                    </div>
                    <div
                        class="p-3 bg-orange-100 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 rounded-xl border-2 border-orange-500 shadow-[2px_3px_0px_0px_#f97316]">
                        <svg class="w-6 h-6 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 💡 Soft Orange 3D Styled Banner: Add New Product -->
            <div
                class="bg-orange-100 dark:bg-emerald-900 border-2 border-orange-400 dark:border-emerald-300 rounded-2xl p-6 text-gray-800 dark:text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-[3px_4px_0px_0px_#fb923c]">
                <div>
                    <h3 class="font-black text-xl tracking-wide text-orange-600 dark:text-orange-400">
                        Ready to sell something new? 🚀
                    </h3>
                    <p class="text-xs text-orange-800 dark:text-emerald-200 font-bold mt-1">
                        Upload your inventory items and start receiving orders instantly from customers.
                    </p>
                </div>
                <!-- 💡 Button လေးပဲ Hover / Click စေမည် -->
                <a href="{{ route('vendor.product.create') }}"
                    class="btn-3d bg-orange-500 hover:bg-orange-600 text-white font-black text-xs px-5 py-3 rounded-xl border-2 border-orange-700 shadow-[2px_3px_0px_0px_#c2410c] active:translate-y-0.5 active:shadow-none transition-all text-center whitespace-nowrap">
                    + Add New Product
                </a>
            </div>

            <!-- 💡 Static 3D Styled Product List Table Container -->
            <div
                class="mt-8 bg-white dark:bg-emerald-900 rounded-2xl p-6 border-2 border-emerald-800 dark:border-emerald-300 shadow-[3px_4px_0px_0px_#065f46] dark:shadow-[3px_4px_0px_0px_#a7f3d0]">

                <!-- 💡 Header Section (Right-aligned Total Items & Search Dropdown) -->
                <div
                    class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b-2 border-emerald-800/20 dark:border-emerald-300/20 pb-4">
                    <div>
                        <h3 class="text-lg font-black text-orange-600 dark:text-orange-400 tracking-wide">
                            My Products List
                        </h3>
                        <p class="text-xs text-emerald-800 dark:text-emerald-200 font-bold mt-0.5">
                            Manage your listed products, stock, and pricing status.
                        </p>
                    </div>

                    <div class="flex items-center gap-3 self-end sm:self-center">
                        <span
                            class="text-xs font-black bg-orange-100 text-orange-700 dark:bg-orange-950/80 dark:text-orange-300 px-3 py-2 rounded-xl border-2 border-orange-500 shadow-[2px_2px_0px_0px_#f97316]">
                            Total Items: {{ $products->count() }}
                        </span>

                        <form action="{{ route('vendor.dashboard') }}" method="GET" id="stockFilterForm"
                            class="flex items-center">
                            <select name="stock_status" id="stock_status"
                                onchange="document.getElementById('stockFilterForm').submit()"
                                class="bg-white border-2 border-emerald-800 text-emerald-950 text-xs font-bold rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-2 dark:bg-emerald-950 dark:border-emerald-300 dark:text-white shadow-[2px_3px_0px_0px_#065f46] dark:shadow-[2px_3px_0px_0px_#a7f3d0] cursor-pointer">

                                <option value="" {{ $stock_status == '' ? 'selected' : '' }}>All Products
                                </option>
                                <option value="in_stock" {{ $stock_status == 'in_stock' ? 'selected' : '' }}>In
                                    Stock</option>
                                <option value="low_stock" {{ $stock_status == 'low_stock' ? 'selected' : '' }}>Low Stock
                                </option>
                                <option value="out_of_stock" {{ $stock_status == 'out_of_stock' ? 'selected' : '' }}>
                                    Out of Stock</option>

                            </select>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                    <div id="successAlert"
                        class="mb-4 p-4 text-sm text-emerald-900 rounded-xl bg-emerald-100 dark:bg-emerald-950 dark:text-emerald-300 border-2 border-emerald-600 shadow-[3px_3px_0px_0px_#059669] flex items-center justify-between gap-2 transition-all duration-300"
                        role="alert">

                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <span class="font-bold">အောင်မြင်သည်!</span> {{ session('success') }}
                            </div>
                        </div>

                        <button type="button" onclick="dismissAlert()"
                            class="text-emerald-700 hover:bg-emerald-200 dark:hover:bg-emerald-900 p-1 rounded-lg transition duration-200"
                            aria-label="Close">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                    </div>
                @endif

                <div
                    class="w-full overflow-x-auto rounded-xl border-2 border-emerald-800 dark:border-emerald-300 shadow-[3px_4px_0px_0px_#065f46] dark:shadow-[3px_4px_0px_0px_#a7f3d0]">
                    <table class="w-full text-left border-collapse min-w-[600px] bg-white dark:bg-emerald-950">
                        <thead>
                            <tr
                                class="bg-emerald-100 dark:bg-emerald-900 text-xs font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider border-b-2 border-emerald-800 dark:border-emerald-300">
                                <th class="py-3.5 px-4 w-24">Image</th>
                                <th class="py-3.5 px-4">Product Details</th>
                                <th class="py-3.5 px-4">Price</th>
                                <th class="py-3.5 px-4">Stock Status</th>
                                <th class="py-3.5 px-4 text-center w-32">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-emerald-100 dark:divide-emerald-900 text-sm font-bold">
                            @forelse($products as $product)
                                <tr class="hover:bg-emerald-50/60 dark:hover:bg-emerald-900/40 transition-colors">
                                    <td class="py-4 px-4">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-white dark:bg-emerald-900 overflow-hidden border-2 border-emerald-800 dark:border-emerald-300 shadow-[2px_2px_0px_0px_#065f46] dark:shadow-[2px_2px_0px_0px_#a7f3d0] flex items-center justify-center">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="py-4 px-4 max-w-xs">
                                        <div class="font-black text-emerald-950 dark:text-white truncate">
                                            {{ $product->name }}
                                        </div>
                                        <div
                                            class="text-xs text-emerald-700 dark:text-emerald-300 font-semibold line-clamp-1 mt-0.5">
                                            {{ $product->description ?? 'No description.' }}
                                        </div>
                                    </td>

                                    <td class="py-4 px-4 font-black text-orange-600 dark:text-orange-400">
                                        {{ number_format($product->price) }} MMK
                                    </td>

                                    <td class="py-4 px-4">
                                        @if($product->stock > 5)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 border border-emerald-500 shadow-[1px_2px_0px_0px_#059669]">
                                                In Stock ({{ $product->stock }})
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 border border-amber-500 shadow-[1px_2px_0px_0px_#d97706]">
                                                Low Stock ({{ $product->stock }})
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200 border border-rose-500 shadow-[1px_2px_0px_0px_#e11d48]">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" onclick="openEditModal({{ $product->id }})"
                                                class="p-2 text-emerald-800 dark:text-emerald-200 hover:text-orange-500 rounded-xl border border-emerald-700 hover:bg-orange-100 transition-all active:scale-90"
                                                title="Edit Product">
                                                <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <button type="button" onclick="confirmDelete({{ $product->id }})"
                                                class="p-2 text-rose-600 hover:text-rose-700 rounded-xl border border-rose-500 hover:bg-rose-100 transition-all active:scale-90"
                                                title="Delete Product">
                                                <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="py-12 text-center text-emerald-800 dark:text-emerald-300 font-bold">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                            <span class="text-xs">You haven't uploaded any products yet.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <div id="editProductModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-xl border dark:border-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-lg font-black text-gray-900 dark:text-white">Edit Product</h4>
                    <button type="button" onclick="closeEditModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Product
                            Name</label>
                        <input type="text" name="name" id="edit_name" required
                            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Price
                                (MMK)</label>
                            <input type="number" name="price" id="edit_price" required min="0"
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Stock</label>
                            <input type="number" name="stock" id="edit_stock" required min="0"
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Description</label>
                        <textarea name="description" id="edit_description" rows="3"
                            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </textarea>

                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Available
                                Sizes</label>
                            <input type="text" name="sizes" id="edit_sizes" placeholder="e.g. S, M, L"
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Current
                            Images & Colors</label>
                        <div id="edit_existing_images_container"
                            class="grid grid-cols-2 gap-3 bg-gray-100 dark:bg-gray-700/30 p-3 rounded-xl border dark:border-gray-700">
                        </div>
                    </div>

                    <div class="mt-4 border-t dark:border-gray-700 pt-4">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">📸 Add
                            More
                            Images & Colors (Optional)</label>
                        <input type="file" name="new_images[]" id="edit_new_images" multiple
                            onchange="previewNewImagesInModal(event)"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600"
                            accept="image/*">

                        <div id="edit_new_images_preview"
                            class="mt-3 hidden grid grid-cols-2 gap-3 bg-blue-50/50 dark:bg-gray-700/20 p-3 rounded-xl border border-dashed border-blue-300">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-xl hover:bg-gray-200">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 shadow-md">Update
                            Product</button>
                    </div>
                </form>
                <form id="deleteProductForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

    </body>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeText = document.getElementById('darkModeText');

        function updateTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (darkModeText) darkModeText.innerText = 'Day Mode';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (darkModeText) darkModeText.innerText = 'Night Mode';
            }
        }

        // Initial Load Check
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            updateTheme(true);
        } else {
            updateTheme(false);
        }

        // Click Event Listener
        if (darkModeRow) {
            darkModeRow.addEventListener('click', () => {
                const isCurrentlyDark = document.documentElement.classList.contains('dark');
                updateTheme(!isCurrentlyDark);
            });
        }

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            });
        }
        const closeSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        };
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);


        function dismissAlert() {
            const alertBox = document.getElementById('successAlert');
            if (alertBox) {
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-10px)';

                setTimeout(() => {
                    alertBox.remove();
                }, 300);
            }
        }

        function openEditModal(productId) {
            const modal = document.getElementById('editProductModal');
            const form = document.getElementById('editProductForm');
            const existingContainer = document.getElementById('edit_existing_images_container');
            const newPreviewContainer = document.getElementById('edit_new_images_preview');

            editModalFilesArray = [];

            existingContainer.innerHTML = '<p class="text-xs text-gray-400 col-span-2 text-center">Loading images...</p>';
            newPreviewContainer.innerHTML = '';
            newPreviewContainer.classList.add('hidden');
            document.getElementById('edit_new_images').value = '';

            form.action = `/vendor/products/${productId}`;

            fetch(`/vendor/products/${productId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_price').value = data.price;
                    document.getElementById('edit_stock').value = data.stock;
                    document.getElementById('edit_description').value = data.description || '';
                    document.getElementById('edit_sizes').value = data.sizes ? JSON.parse(data.sizes).join(', ') : '';

                    existingContainer.innerHTML = '';
                    if (data.images && Array.isArray(data.images) && data.images.length > 0) {
                        data.images.forEach(img => {
                            const div = document.createElement('div');
                            div.className = 'p-2 bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-600 flex flex-col gap-1.5 relative';
                            div.innerHTML = `
            <div class="aspect-video w-full rounded overflow-hidden border">
                <img src="/storage/${img.image_path}" class="w-full h-full object-cover">
            </div>
            <div>
                <input type="text" name="existing_image_colors[${img.id}]" value="${img.color || ''}" 
                    placeholder="Color" class="w-full px-2 py-1 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded text-[11px] focus:outline-none dark:text-white">
            </div>
            <label class="flex items-center gap-1 mt-1 text-[10px] text-rose-500 font-medium cursor-pointer">
                <input type="checkbox" name="delete_images[]" value="${img.id}" class="rounded text-rose-600 focus:ring-rose-500"> Delete photo
            </label>
        `;
                            existingContainer.appendChild(div);
                        });
                    } else {
                        existingContainer.innerHTML = '<p class="text-xs text-gray-400 col-span-2 text-center py-2">No gallery images uploaded for this product.</p>';
                    }
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
        }

        let editModalFilesArray = [];

        function previewNewImagesInModal(event) {
            const input = event.target;
            const container = document.getElementById('edit_new_images_preview');

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    editModalFilesArray.push(file);
                });
            }

            renderEditModalPreviews();
        }

        function renderEditModalPreviews() {
            const container = document.getElementById('edit_new_images_preview');
            const input = document.getElementById('edit_new_images');
            container.innerHTML = '';

            if (editModalFilesArray.length > 0) {
                container.classList.remove('hidden');

                editModalFilesArray.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.className = 'p-2 bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-600 flex flex-col gap-1.5 relative group';

                        div.innerHTML = `
                    <button type="button" onclick="removeNewImageFromModal(${index})" 
                        class="absolute -top-1.5 -right-1.5 bg-rose-500 hover:bg-rose-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md z-10 transition-transform hover:scale-110">
                        &times;
                    </button>
                    <div class="aspect-video w-full rounded overflow-hidden border bg-gray-50 flex items-center justify-center">
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <input type="text" name="new_image_colors[${index}]" placeholder="New Color" 
                            class="w-full px-2 py-1 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded text-[11px] focus:outline-none dark:text-white">
                    </div>
                `;
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
            }

            const dataTransfer = new DataTransfer();
            editModalFilesArray.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        function removeNewImageFromModal(indexToRemove) {
            editModalFilesArray.splice(indexToRemove, 1);
            renderEditModalPreviews();
        }

        function closeEditModal() {
            document.getElementById('editProductModal').classList.add('hidden');
        }

        function confirmDelete(productId) {
            if (confirm("Are you sure you want to delete this product? This action cannot be undone.")) {
                const form = document.getElementById('deleteProductForm');

                form.action = `/vendor/products/${productId}`;

                form.submit();
            }
        }
    </script>

    </html>
</x-app-layout>