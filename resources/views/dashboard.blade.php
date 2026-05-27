<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    
    <style>
        html, body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen pb-24 relative overflow-x-hidden">

    <nav class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b dark:border-gray-700">
        <div class="flex items-center flex-shrink-0">
            <button id="menuBtn" class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <div class="flex-grow max-w-2xl mx-4 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="Search products..." 
                   class="w-full pl-9 pr-4 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white rounded-full text-sm border border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-center gap-2 flex-shrink-0">
            <div class="relative cursor-pointer p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">3</span>
            </div>

            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow ml-1 flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300 overflow-y-auto"></div>
    <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto">
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
                <a href="{{ route('vendor.register') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10zM9 14h6v7H9v-7z"></path>
                    </svg>
                    Vendor Registration
                </a>
                
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                    </svg>
                    Cart
                </a>
                
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Orders
                </a>

                <div id="darkModeRow" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm cursor-pointer select-none">
                    <span class="flex items-center gap-3 tracking-wide">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        Dark Mode
                    </span>
                    <div class="relative w-9 h-5 flex-shrink-0 pointer-events-none">
                        <input type="checkbox" id="darkModeToggle" class="sr-only peer">
                        <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Messages
                </a>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 dark:border-gray-700 pt-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 font-medium text-sm text-left">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 tracking-wide">Trending Products</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="block">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl flex flex-col justify-between transform transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden relative">
                    
                    <div class="w-full h-48 bg-gray-100 dark:bg-gray-700 relative flex items-center justify-center border-b border-gray-200 dark:border-gray-700/70 overflow-hidden flex-shrink-0">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                    </div>
                    
                    <div class="p-4 flex flex-col flex-grow justify-between">
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug mb-1 truncate">{{ $product->name }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-2 min-h-[2rem]">{{ $product->description ?? 'No description available.' }}</p>
                        </div>
                        
                        <div class="mt-2 flex-shrink-0">
                            <div class="text-blue-600 dark:text-blue-400 font-extrabold text-sm mb-2">
                                {{ number_format($product->price) }} MMK
                            </div>
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="text-gray-400">Stock: <strong class="text-gray-700 dark:text-gray-300 font-semibold">{{ $product->stock }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-400 flex flex-col items-center justify-center gap-2">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>No products found.</span>
                </div>
            @endforelse
        </div>
    </main>

    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg px-6 py-2 flex justify-around items-center z-40">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-0.5 text-blue-600 dark:text-blue-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        
        <a href="#" class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V16zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V16z"></path>
            </svg>
            <span class="text-[10px] font-medium">Category</span>
        </a>
        
        <a href="#" class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10zM9 14h6v7H9v-7z"></path>
            </svg>
            <span class="text-[10px] font-medium">Shops</span>
        </a>
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeToggle = document.getElementById('darkModeToggle');

        // Sidebar Logic
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

        // Init Dark Mode from memory
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            updateTheme(true);
        } else {
            updateTheme(false);
        }

        // Toggle Dark Mode when clicking anywhere on the row
        darkModeRow.addEventListener('click', () => {
            updateTheme(!darkModeToggle.checked);
        });
    </script>
</body>
</html>