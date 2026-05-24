<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
        // Tailwind dark mode configuration
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        html, body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        /* Custom scrollbar hide for clean look */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen pb-24 relative">

    <nav class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b dark:border-gray-700">
        <div class="flex items-center gap-3 w-full max-w-md">
            <button id="menuBtn" class="text-gray-600 dark:text-gray-300 text-xl p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
            
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input type="text" placeholder="Search products..." 
                       class="w-full pl-9 pr-4 py-1.5 bg-gray-100 dark:bg-gray-700 dark:text-white rounded-full text-sm border-none focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex items-center gap-4 ml-4">
            <div class="relative cursor-pointer p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa-regular fa-bell text-xl text-gray-600 dark:text-gray-300"></i>
                <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">3</span>
            </div>

            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300"></div>
    <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Menu</h2>
                <button id="closeBtn" class="text-gray-500 hover:text-gray-800 dark:hover:text-white text-xl p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <i class="fa-solid fa-shop text-gray-400 w-5"></i> Vendor Registration
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <i class="fa-solid fa-cart-shopping text-gray-400 w-5"></i> Cart
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <i class="fa-solid fa-box text-gray-400 w-5"></i> Orders
                </a>

                <div class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 text-sm">
                    <span class="flex items-center gap-3 font-medium">
                        <i class="fa-regular fa-moon text-gray-400 w-5"></i> Dark Mode
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="darkModeToggle" class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <i class="fa-regular fa-comment text-gray-400 w-5"></i> Messages
                </a>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 dark:border-gray-700 pt-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 font-medium text-sm text-left">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Logout
            </button>
        </form>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 tracking-wide">Trending Products</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/50 rounded-2xl p-4 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="w-full h-44 bg-gray-100 dark:bg-gray-700 rounded-xl overflow-hidden mb-3 relative flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-regular fa-image text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug mb-1">{{ $product->name }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-2">{{ $product->description ?? 'No description available.' }}</p>
                    </div>
                    
                    <div class="mt-2">
                        <div class="text-blue-600 dark:text-blue-400 font-extrabold text-sm mb-2">
                            {{ number_format($product->price) }} MMK
                        </div>
                        <div class="flex justify-between items-center text-[11px]">
                            <span class="text-gray-400">Stock: <strong class="text-gray-700 dark:text-gray-300 font-semibold">{{ $product->stock }}</strong></span>
                            <button class="bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 px-3 py-1 rounded-full font-bold hover:bg-blue-100 dark:hover:bg-blue-900/60 transition-colors">
                                Add +
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-400">
                    <i class="fa-solid fa-box-open text-3xl mb-2 block"></i>
                    No products found.
                </div>
            @endforelse
        </div>
    </main>

    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 shadow-lg px-6 py-2 flex justify-around items-center z-40">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-0.5 text-blue-600 dark:text-blue-400">
            <i class="fa-solid fa-house text-base"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <i class="fa-solid fa-layer-group text-base"></i>
            <span class="text-[10px] font-medium">Category</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <i class="fa-solid fa-store text-base"></i>
            <span class="text-[10px] font-medium">Shops</span>
        </a>
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const darkModeToggle = document.getElementById('darkModeToggle');

        // Sidebar Actions
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

        // Dark Mode Setup
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            darkModeToggle.checked = true;
        } else {
            document.documentElement.classList.remove('dark');
            darkModeToggle.checked = false;
        }

        darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>
</html>