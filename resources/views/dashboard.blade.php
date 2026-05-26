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

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300"></div>
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
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">Vendor Registration</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">Cart</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">Orders</a>

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
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 font-medium text-sm text-left">Logout</button>
        </form>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 tracking-wide">Trending Products</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 border rounded-2xl cursor-pointer"
                    onclick="openProductDetailModal({
                        name: '{{ addslashes($product->name) }}',
                        price: '{{ number_format($product->price) }}',
                        description: '{{ addslashes($product->description ?? 'No description available.') }}',
                        image: '{{ $product->image ? asset($product->image) : '' }}',
                        stock: {{ $product->stock }},
                        gallery: {{ json_encode($product->images->map(fn($img) => asset($img->image_path))) }}
                    })">
                    
                    <div class="w-full h-48">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    
                </div>
            @empty
            @endforelse
        </div>
    </main>

    <div id="detailModalOverlay" class="fixed inset-0 bg-black/60 z-50 hidden transition-opacity duration-300 flex items-center justify-center p-0 sm:p-4">
        <div id="detailModalCard" class="bg-white dark:bg-gray-800 w-full max-w-4xl h-full sm:h-auto sm:max-h-[90vh] sm:rounded-3xl shadow-2xl overflow-y-auto transform scale-95 opacity-0 transition-all duration-300 flex flex-col relative pb-20 sm:pb-0">
            
            <div class="sticky top-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md px-6 py-4 flex justify-between items-center border-b border-gray-100 dark:border-gray-700/80 z-20">
                <h2 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">Product Overview</h2>
                <button type="button" id="closeDetailModalBtn" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-2 rounded-xl bg-gray-50 dark:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                
                <div class="flex flex-col gap-3">
                    <div class="w-full aspect-square bg-gray-50 dark:bg-gray-700/50 rounded-2xl relative overflow-hidden group border border-gray-100 dark:border-gray-700/30 flex items-center justify-center">
                        
                        <img id="modalProductImage" src="" class="w-full h-full object-cover hidden" alt="Product Image">
                        
                        <div id="modalProductImageFallback" class="hidden">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        <button type="button" id="prevSlideBtn" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 dark:bg-gray-800/80 text-gray-800 dark:text-white shadow flex items-center justify-center hover:bg-white transition-all hidden z-30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button type="button" id="nextSlideBtn" class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 dark:bg-gray-800/80 text-gray-800 dark:text-white shadow flex items-center justify-center hover:bg-white transition-all hidden z-30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <div id="carouselBadge" class="absolute bottom-4 left-4 bg-black/60 backdrop-blur-sm px-3 py-1 rounded-full text-white font-bold text-xs tracking-wider hidden z-30">
                            <span id="currentIndexLabel">1</span>/<span id="totalIndexLabel">1</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between">
                    <div>
                        <h1 id="modalProductName" class="text-2xl font-black text-gray-900 dark:text-white tracking-tight leading-tight"></h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">In Stock: <span id="modalProductStock"></span> items</span>
                        </div>

                        <div class="text-3xl font-black text-blue-600 dark:text-blue-400 my-4 flex items-baseline gap-1">
                            <span id="modalProductPrice"></span>
                            <span class="text-xs font-bold tracking-wide uppercase text-gray-400 dark:text-gray-500">MMK</span>
                        </div>

                        <hr class="border-gray-100 dark:border-gray-700/60 my-4">

                        <h4 class="text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Description</h4>
                        <p id="modalProductDescription" class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed font-medium mb-5"></p>

                        <div class="mb-6 bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/40">
                            <h4 class="text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Specifications</h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between py-1 border-b border-gray-200/40 dark:border-gray-700/40">
                                    <span class="text-gray-400 font-semibold">Material</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-bold">High-quality Premium</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-200/40 dark:border-gray-700/40">
                                    <span class="text-gray-400 font-semibold">Warranty</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-bold">2 Years</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="text-gray-400 font-semibold">Return Period</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-bold">30 Days Return</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Quantity:</span>
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-xl p-1 border border-gray-200/20 dark:border-gray-600">
                                <button type="button" id="modalMinusBtn" class="w-8 h-8 font-black text-lg hover:bg-white dark:hover:bg-gray-600 rounded-lg transition-all flex items-center justify-center select-none">-</button>
                                <input type="number" id="modalQtyInput" value="1" min="1" class="w-12 text-center bg-transparent border-none focus:outline-none font-bold text-sm text-gray-900 dark:text-white">
                                <button type="button" id="modalPlusBtn" class="w-8 h-8 font-black text-lg hover:bg-white dark:hover:bg-gray-600 rounded-lg transition-all flex items-center justify-center select-none">+</button>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" id="confirmAddCartBtn" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3.5 px-6 rounded-xl transition-all shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                                Add to Cart
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg px-4 py-2 z-40">
        <div class="max-w-xl mx-auto grid grid-cols-3 text-center">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center gap-0.5 text-blue-600 dark:text-blue-400 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V16zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V16z"></path></svg>
                <span class="text-[10px] font-medium">Category</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10zM9 14h6v7H9v-7z"></path></svg>
                <span class="text-[10px] font-medium">Shops</span>
            </a>
        </div>
    </div>

    <script>
        // Modal Structural Elements
        const detailModalOverlay = document.getElementById('detailModalOverlay');
        const detailModalCard = document.getElementById('detailModalCard');
        const closeDetailModalBtn = document.getElementById('closeDetailModalBtn');
        const confirmAddCartBtn = document.getElementById('confirmAddCartBtn');
        
        // Modal Typography Targets
        const modalProductName = document.getElementById('modalProductName');
        const modalProductPrice = document.getElementById('modalProductPrice');
        const modalProductDescription = document.getElementById('modalProductDescription');
        const modalProductStock = document.getElementById('modalProductStock');
        const modalProductImage = document.getElementById('modalProductImage');
        const modalProductImageFallback = document.getElementById('modalProductImageFallback');
        
        // Dynamic Multi-Image Carousel Controller Hooks
        let activeGalleryImages = [];
        let currentGalleryIndex = 0;
        const prevSlideBtn = document.getElementById('prevSlideBtn');
        const nextSlideBtn = document.getElementById('nextSlideBtn');
        const carouselBadge = document.getElementById('carouselBadge');
        const currentIndexLabel = document.getElementById('currentIndexLabel');
        const totalIndexLabel = document.getElementById('totalIndexLabel');
        
        // Counter Elements
        const modalMinusBtn = document.getElementById('modalMinusBtn');
        const modalPlusBtn = document.getElementById('modalPlusBtn');
        const modalQtyInput = document.getElementById('modalQtyInput');
        
        // Feed Toast Elements
        const toastNotification = document.getElementById('toastNotification');
        const toastMessage = document.getElementById('toastMessage');
        const cartBadge = document.getElementById('cartBadge');

        // Dynamic Modal Population Function
        function openProductDetailModal(product) {
            modalProductName.innerText = product.name;
            modalProductPrice.innerText = product.price;
            modalProductDescription.innerText = product.description;
            modalProductStock.innerText = product.stock;
            modalQtyInput.value = 1;
            modalQtyInput.setAttribute('max', product.stock);

            // Construct array tracking indices (Primary Thumbnail + Multi Gallery Items)
            activeGalleryImages = [];
            if (product.image) activeGalleryImages.push(product.image);
            if (product.gallery && product.gallery.length > 0) {
                activeGalleryImages.push(...product.gallery);
            }

            currentGalleryIndex = 0;
            updateCarouselDisplay();

            // Slide up presentation transition animations
            detailModalOverlay.classList.remove('hidden');
            setTimeout(() => {
                detailModalCard.classList.remove('scale-95', 'opacity-0');
                detailModalCard.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        // Render Carousel Layout Transitions Smoothly
        function updateCarouselDisplay() {
            if (activeGalleryImages.length > 0) {
                modalProductImage.src = activeGalleryImages[currentGalleryIndex];
                modalProductImage.classList.remove('hidden');
                modalProductImageFallback.classList.add('hidden');
                
                if (activeGalleryImages.length > 1) {
                    prevSlideBtn.classList.remove('hidden');
                    nextSlideBtn.classList.remove('hidden');
                    carouselBadge.classList.remove('hidden');
                    currentIndexLabel.innerText = currentGalleryIndex + 1;
                    totalIndexLabel.innerText = activeGalleryImages.length;
                } else {
                    prevSlideBtn.classList.add('hidden');
                    nextSlideBtn.classList.add('hidden');
                    carouselBadge.classList.add('hidden');
                }
            } else {
                modalProductImage.classList.add('hidden');
                modalProductImageFallback.classList.remove('hidden');
                prevSlideBtn.classList.add('hidden');
                nextSlideBtn.classList.add('hidden');
                carouselBadge.classList.add('hidden');
            }
        }

        // Left/Right Nav Click Listeners (stopPropagation avoids background event triggers)
        prevSlideBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            currentGalleryIndex = (currentGalleryIndex === 0) ? activeGalleryImages.length - 1 : currentGalleryIndex - 1;
            updateCarouselDisplay();
        });

        nextSlideBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            currentGalleryIndex = (currentGalleryIndex === activeGalleryImages.length - 1) ? 0 : currentGalleryIndex + 1;
            updateCarouselDisplay();
        });

        // Close Modal Lifecycles
        const closePopUpModal = () => {
            detailModalCard.classList.remove('scale-100', 'opacity-100');
            detailModalCard.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                detailModalOverlay.classList.add('hidden');
            }, 300);
        };
        closeDetailModalBtn.addEventListener('click', closePopUpModal);
        detailModalOverlay.addEventListener('click', (e) => {
            if (e.target === detailModalOverlay) closePopUpModal();
        });

        // Quantity Adjuster
        modalMinusBtn.addEventListener('click', () => {
            let val = parseInt(modalQtyInput.value);
            if(val > 1) modalQtyInput.value = val - 1;
        });
        modalPlusBtn.addEventListener('click', () => {
            let val = parseInt(modalQtyInput.value);
            let max = parseInt(modalQtyInput.getAttribute('max'));
            if(val < max) modalQtyInput.value = val + 1;
        });

        // Add to Cart Process Completion
        confirmAddCartBtn.addEventListener('click', () => {
            closePopUpModal();
            
            let currentCount = parseInt(cartBadge.innerText);
            let selectedQty = parseInt(modalQtyInput.value);
            cartBadge.innerText = currentCount + selectedQty;

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

        // Sidebar Actions
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeToggle = document.getElementById('darkModeToggle');

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

        // Dark Theme Switch Engine
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