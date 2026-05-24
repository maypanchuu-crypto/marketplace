<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    
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
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-base font-bold tracking-wide hidden sm:block">Product Details</h2>
        </div>
        
        <button id="menuBtn" class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300"></div>
    <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between">
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
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
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
                
                <div id="darkModeRow" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm cursor-pointer select-none">
                    <span class="flex items-center gap-3">
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
            </div>
        </div>
    </div>

    <main class="max-w-5xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-gray-800 rounded-2xl p-4 md:p-6 shadow-sm border border-gray-200 dark:border-gray-700/70 overflow-hidden">
            
            <div class="w-full h-72 sm:h-96 bg-gray-100 dark:bg-gray-700 rounded-xl overflow-hidden flex items-center justify-center relative">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                @endif
            </div>

            <div class="flex flex-col justify-between">
                <div>
                    <span class="bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 text-xs px-2.5 py-1 rounded-md font-bold uppercase tracking-wider inline-block mb-2">In Stock</span>
                    <h1 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white mb-2 leading-tight">{{ $product->name }}</h1>
                    
                    <div class="text-xl font-extrabold text-blue-600 dark:text-blue-400 mb-4">
                        {{ number_format($product->price) }} MMK
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-4">

                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Product Description</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                        {{ $product->description ?? 'No description available for this product. High quality guaranteed from our verified local vendors.' }}
                    </p>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Quantity:</span>
                        <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-xl px-2 py-1">
                            <button type="button" id="minusBtn" class="w-8 h-8 font-bold text-lg hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors flex items-center justify-center">-</button>
                            <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center bg-transparent border-none focus:outline-none font-bold text-sm">
                            <button type="button" id="plusBtn" class="w-8 h-8 font-bold text-lg hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors flex items-center justify-center">+</button>
                        </div>
                        <span class="text-xs text-gray-400">Available Stock: <strong>{{ $product->stock }}</strong></span>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3 px-6 rounded-xl transition-all shadow-md shadow-blue-600/20 text-center">
                            Add to Cart
                        </button>
                    </div>
                </form>
            </div>
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
        
        const minusBtn = document.getElementById('minusBtn');
        const plusBtn = document.getElementById('plusBtn');
        const qtyInput = document.getElementById('qtyInput');

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

        // Quantity Logic
        minusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if(val > 1) qtyInput.value = val - 1;
        });
        plusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            let max = parseInt(qtyInput.getAttribute('max'));
            if(val < max) qtyInput.value = val + 1;
        });

        // Dark Mode Logic
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
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            updateTheme(true);
        } else {
            updateTheme(false);
        }
        darkModeRow.addEventListener('click', () => {
            updateTheme(!darkModeToggle.checked);
        });
    </script>
</body>
</html>