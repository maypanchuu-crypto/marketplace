<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - {{ $vendor->shop_name }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen pb-24 relative">

    <nav class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b dark:border-gray-700">
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.dashboard') }}" class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-base font-bold tracking-wide">Add Product</h2>
        </div>
        <button id="menuBtn" class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden"></div>
    <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 p-5 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold dark:text-white">Vendor Menu</h2>
                <button id="closeBtn" class="text-gray-500 p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="space-y-1">
                <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium">Dashboard Home</a>
                <div id="darkModeRow" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm cursor-pointer">
                    <span>Dark Mode</span>
                    <input type="checkbox" id="darkModeToggle" class="sr-only">
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 shadow-sm border dark:border-gray-700">
            
            <div class="mb-6">
                <h1 class="text-xl font-black text-gray-900 dark:text-white">Upload New Item</h1>
                <p class="text-xs text-gray-400 mt-1">Fill in the details to list a new product in the marketplace.</p>
            </div>

            <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-400 uppercase mb-2">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('name') border-rose-500 @enderror" placeholder="e.g. Premium Cotton T-Shirt">
                    @error('name') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-xs font-bold text-gray-400 uppercase mb-2">Price (MMK)</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" min="0"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('price') border-rose-500 @enderror" placeholder="e.g. 15000">
                        @error('price') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-xs font-bold text-gray-400 uppercase mb-2">Available Stock</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}" min="0"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('stock') border-rose-500 @enderror" placeholder="e.g. 10">
                        @error('stock') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-gray-400 uppercase mb-2">Product Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('description') border-rose-500 @enderror" placeholder="Write features, size guide, or details..."></textarea>
                    @error('description') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Product Photo</label>
                    <input type="file" id="product_image" name="product_image" accept="image/*" onchange="previewImage(event)"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-gray-700 dark:file:text-gray-200 border border-dashed border-gray-300 dark:border-gray-600 p-2 rounded-xl bg-gray-50/50 @error('product_image') border-rose-500 @enderror">
                    @error('product_image') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror

                    <div id="previewContainer" class="mt-4 hidden relative w-40 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm bg-gray-100 p-1">
                        <img id="imagePreview" src="#" alt="Preview" class="w-full h-auto object-contain rounded-lg">
                        <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-black/60 text-white p-1 rounded-full text-xs">✕</button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3 rounded-xl transition-all shadow-md">
                        Publish Product
                    </button>
                </div>
            </form>

        </div>
    </main>

    <script>
        // --- Image Preview Logic ---
        function previewImage(event) {
            const input = event.target;
            const container = document.getElementById('previewContainer');
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function removeImage() {
            document.getElementById('product_image').value = "";
            document.getElementById('previewContainer').classList.add('hidden');
        }

        // --- Layout UI Sidebar & Darkmode Logic ---
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
                if(darkModeToggle) darkModeToggle.checked = true;
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if(darkModeToggle) darkModeToggle.checked = false;
            }
        }
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) updateTheme(true);
        if(darkModeRow) darkModeRow.addEventListener('click', () => updateTheme(!darkModeToggle.checked));
        if(menuBtn) menuBtn.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); sidebarOverlay.classList.remove('hidden'); });
        const closeSidebar = () => { sidebar.classList.add('-translate-x-full'); sidebarOverlay.classList.add('hidden'); };
        if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if(sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
    </script>
</body>
</html>