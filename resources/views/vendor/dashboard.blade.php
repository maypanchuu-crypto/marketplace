<!DOCTYPE html>
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
    </style>
</head>

<body
    class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen pb-24 relative overflow-x-hidden">

    <nav
        class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b dark:border-gray-700">

        <button id="menuBtn"
            class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="flex items-center gap-3">
            <h2 class="text-base font-black tracking-wide text-blue-600 dark:text-blue-400">{{ $vendor->shop_name }}
                <span class="text-xs font-normal text-gray-400 dark:text-gray-500 ml-1">(Vendor Portal)</span>
            </h2>
        </div>
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300"></div>
    <div id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Vendor Menu</h2>
                <button id="closeBtn" class="text-gray-500 hover:text-gray-800 dark:hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-1">
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z">
                        </path>
                    </svg>
                    Dashboard Home
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    My Products
                </a>

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm border-t dark:border-gray-700 mt-4 pt-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                    </svg>
                    Customer Marketplace
                </a>

                <div id="darkModeRow"
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm cursor-pointer select-none">
                    <span class="flex items-center gap-3">
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
        </div>
    </div>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <div class="mb-8">
            <h1 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">Welcome back,
                {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Here is what's happening with your shop
                **{{ $vendor->shop_name }}** today.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700/70 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total
                        Earnings</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">
                        {{ number_format($totalEarnings) }} MMK
                    </h3>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700/70 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">My
                        Products</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $totalProducts }} Items</h3>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700/70 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total
                        Orders</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $totalOrders }} Orders</h3>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-950/30 text-amber-500 dark:text-amber-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-lg">Ready to sell something new?</h3>
                <p class="text-xs text-blue-100 mt-1">Upload your inventory items and start receiving orders instantly
                    from customers.</p>
            </div>
            <a href="{{ route('vendor.product.create') }}"
                class="bg-white text-blue-600 font-bold text-xs px-4 py-3 rounded-xl shadow-sm hover:bg-blue-50 transition-all text-center whitespace-nowrap">
                + Add New Product
            </a>
        </div>

        <!-- Product List Table -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <div>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white tracking-wide">My Products List</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Manage your listed products, stock, and pricing status.</p>
                </div>
                <span
                    class="text-xs font-bold bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 px-3 py-1.5 rounded-xl self-start sm:self-center">
                    Total Items: {{ $products->count() }}
                </span>
            </div>

            <div
                class="mb-6 flex flex-wrap gap-4 items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4">

                <form action="{{ route('vendor.dashboard') }}" method="GET" id="stockFilterForm"
                    class="flex items-center gap-2">
                    <label for="stock_status" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Search by:
                    </label>

                    <select name="stock_status" id="stock_status"
                        onchange="document.getElementById('stockFilterForm').submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white">

                        <option value="" {{ $stock_status == '' ? 'selected' : '' }}>All Products</option>
                        <option value="in_stock" {{ $stock_status == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ $stock_status == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ $stock_status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock
                        </option>

                    </select>
                </form>

                <!-- <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">
                    Showing {{ $products->count() }} items
                </span> -->
            </div>

            <div class="w-full overflow-x-auto rounded-xl border dark:border-gray-700">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr
                            class="bg-gray-50 dark:bg-gray-700/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b dark:border-gray-700">
                            <th class="py-3.5 px-4 w-24">Image</th>
                            <th class="py-3.5 px-4">Product Details</th>
                            <th class="py-3.5 px-4">Price</th>
                            <th class="py-3.5 px-4">Stock Status</th>
                            <th class="py-3.5 px-4 text-center w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                <td class="py-4 px-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 overflow-hidden border dark:border-gray-600 flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                                class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-4 px-4 max-w-xs">
                                    <div class="font-bold text-gray-900 dark:text-white truncate">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400 line-clamp-1 mt-0.5">
                                        {{ $product->description ?? 'No description.' }}
                                    </div>
                                </td>

                                <td class="py-4 px-4 font-extrabold text-blue-600 dark:text-blue-400">
                                    {{ number_format($product->price) }} MMK
                                </td>

                                <td class="py-4 px-4">
                                    @if($product->stock > 5)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400">
                                            In Stock ({{ $product->stock }})
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400">
                                            Low Stock ({{ $product->stock }})
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400">
                                            Out of Stock
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="openEditModal({{ $product->id }})"
                                            class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                            title="Edit Product">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        <button type="button" onclick="confirmDelete({{ $product->id }})"
                                            class="p-2 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                            title="Delete Product">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
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
                                <td colspan="5" class="py-12 text-center text-gray-400 dark:text-gray-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none"
                                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
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

    <div
        class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg px-6 py-2 flex justify-around items-center z-40">
        <a href="{{ route('vendor.dashboard') }}"
            class="flex flex-col items-center gap-0.5 text-blue-600 dark:text-blue-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z">
                </path>
            </svg>
            <span class="text-[10px] font-medium">Dashboard</span>
        </a>
        <a href="#"
            class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span class="text-[10px] font-medium">Products</span>
        </a>
    </div>

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
                        class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Product Image
                        (Optional)</label>
                    <input type="file" name="image"
                        class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-gray-700 dark:file:text-gray-200">
                    <p class="text-[10px] text-gray-400 mt-1">Leave empty to keep the current image.</p>
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
    const darkModeToggle = document.getElementById('darkModeToggle');

    function updateTheme(isDark) {
        if (isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            if (darkModeToggle) darkModeToggle.checked = true;
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            if (darkModeToggle) darkModeToggle.checked = false;
        }
    }

    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        updateTheme(true);
    } else {
        updateTheme(false);
    }

    if (darkModeRow && darkModeToggle) {
        darkModeRow.addEventListener('click', () => {
            updateTheme(!darkModeToggle.checked);
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

    
    function openEditModal(productId) {
        const modal = document.getElementById('editProductModal');
        const form = document.getElementById('editProductForm');

        form.action = `/vendor/products/${productId}`;

        fetch(`/vendor/products/${productId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Product resource not found');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_price').value = data.price;
                document.getElementById('edit_stock').value = data.stock;
                document.getElementById('edit_description').value = data.description || '';

                modal.classList.remove('hidden');
                modal.classList.add('flex'); // Tailwind flexbox စနစ်ဖြင့် Center ကျအောင်
            })
            .catch(error => {
                console.error('Error fetching product:', error);
                alert('Something went wrong while fetching product details. Please try again later.');
            });
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