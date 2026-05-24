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

    <div id="toastNotification" class="fixed top-20 right-4 z-50 transform translate-x-full opacity-0 transition-all duration-300 ease-out pointer-events-none">
        <div class="bg-green-500 text-white px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 font-semibold text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toastMessage">Product added to cart successfully!</span>
        </div>
    </div>

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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                </svg>
                <span id="cartBadge" class="absolute top-1 right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">3</span>
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
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    Vendor Registration
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    Cart
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    Orders
                </a>

                <div id="darkModeRow" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm cursor-pointer select-none">
                    <span>Dark Mode</span>
                    <div class="relative w-9 h-5 flex-shrink-0 pointer-events-none">
                        <input type="checkbox" id="darkModeToggle" class="sr-only peer">
                        <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 dark:border-gray-700 pt-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 font-medium text-sm text-left">
                Logout
            </button>
        </form>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 tracking-wide">Trending Products</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl flex flex-col justify-between transform transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden relative cursor-pointer"
                     onclick="goToDetail(event, '{{ route('products.show', $product->id) }}')">
                    
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
                                
                                <button type="button" 
                                        onclick="openQuickAddModal(event, '{{ $product->name }}')"
                                        class="bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 px-3 py-1 rounded-full font-bold hover:bg-blue-100 dark:hover:bg-blue-900/60 transition-colors z-10 relative">
                                    Add +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-400">No products found.</div>
            @endforelse
        </div>
    </main>

    <div id="miniModalOverlay" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity duration-300 flex items-center justify-center p-4">
        <div id="miniModal" class="bg-white dark:bg-gray-800 rounded-2xl max-w-sm w-full p-5 shadow-2xl border border-gray-200 dark:border-gray-700 transform scale-95 opacity-0 transition-all duration-300">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Confirm Purchase</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                သင် ရွေးချယ်ထားသော "<span id="modalProductName" class="font-black text-blue-600 dark:text-blue-400"></span>" အား Cart ထဲသို့ ထည့်သွင်းရန် သေချာပါသလား?
            </p>
            
            <div class="flex gap-3 justify-end">
                <button type="button" id="cancelModalBtn" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="button" id="confirmModalBtn" class="px-5 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-colors shadow-md shadow-blue-600/10">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg px-4 py-2 z-40">
        <div class="max-w-xl mx-auto grid grid-cols-3 text-center">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center gap-0.5 text-blue-600 dark:text-blue-400 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V16zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V16z"></path>
                </svg>
                <span class="text-[10px] font-medium">Category</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10zM9 14h6v7H9v-7z"></path>
                </svg>
                <span class="text-[10px] font-medium">Shops</span>
            </a>
        </div>
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeToggle = document.getElementById('darkModeToggle');

        // Modal & Toast Elements
        const miniModalOverlay = document.getElementById('miniModalOverlay');
        const miniModal = document.getElementById('miniModal');
        const modalProductName = document.getElementById('modalProductName');
        const cancelModalBtn = document.getElementById('cancelModalBtn');
        const confirmModalBtn = document.getElementById('confirmModalBtn');
        const toastNotification = document.getElementById('toastNotification');
        const toastMessage = document.getElementById('toastMessage');
        const cartBadge = document.getElementById('cartBadge');

        // 1. Card နှိပ်ရင် Detail Page သွားမယ့် Function
        function goToDetail(event, url) {
            window.location.href = url;
        }

        // 2. Add + ခလုတ်နှိပ်ရင် Modal ဖွင့်မယ့် Function
        function openQuickAddModal(event, productName) {
            event.stopPropagation(); // Card ကလစ်ဖြစ်သွားတာကို တားဆီးခြင်း
            
            modalProductName.innerText = productName;
            miniModalOverlay.classList.remove('hidden');
            setTimeout(() => {
                miniModal.classList.remove('scale-95', 'opacity-0');
                miniModal.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        // 3. Close Modal Logic
        const closeModal = () => {
            miniModal.classList.remove('scale-100', 'opacity-100');
            miniModal.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                miniModalOverlay.classList.add('hidden');
            }, 300);
        };
        cancelModalBtn.addEventListener('click', closeModal);

        // 4. Confirm -> Show Toast Logic
        confirmModalBtn.addEventListener('click', () => {
            closeModal();
            
            // Cart ဂဏန်းကို အပြင်မှာတင် +1 တိုးပေးခြင်း
            let currentCount = parseInt(cartBadge.innerText);
            cartBadge.innerText = currentCount + 1;

            // Toast Message အား သက်ဝင်လှုပ်ရှားစေခြင်း
            toastMessage.innerText = `"${modalProductName.innerText}" added to cart successfully!`;
            setTimeout(() => {
                toastNotification.classList.remove('translate-x-full', 'opacity-0');
                toastNotification.classList.add('translate-x-0', 'opacity-100');

                setTimeout(() => {
                    toastNotification.classList.remove('translate-x-0', 'opacity-100');
                    toastNotification.classList.add('translate-x-full', 'opacity-0');
                }, 3000);
            }, 400);
        });

        // Sidebar Menu Trigger
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