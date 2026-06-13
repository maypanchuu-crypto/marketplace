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

    <nav
        class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b dark:border-gray-700">
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.dashboard') }}"
                class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-base font-bold tracking-wide">Add Product</h2>
        </div>
        <button id="menuBtn"
            class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden"></div>
    <div id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 p-5 flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold dark:text-white">Vendor Menu</h2>
                <button id="closeBtn" class="text-gray-500 p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg></button>
            </div>
            <div class="space-y-1">
                <a href="{{ route('vendor.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium">Dashboard
                    Home</a>
                <div id="darkModeRow"
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm cursor-pointer">
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

            <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-gray-400 uppercase mb-2">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('name') border-rose-500 @enderror"
                        placeholder="e.g. Premium Cotton T-Shirt">
                    @error('name') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-xs font-bold text-gray-400 uppercase mb-2">Price
                            (MMK)</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" min="0"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('price') border-rose-500 @enderror"
                            placeholder="e.g. 15000">
                        @error('price') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-xs font-bold text-gray-400 uppercase mb-2">Available
                            Stock</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}" min="0"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('stock') border-rose-500 @enderror"
                            placeholder="e.g. 10">
                        @error('stock') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-gray-400 uppercase mb-2">Product
                        Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('description') border-rose-500 @enderror"
                        placeholder="Write features, size guide, or details...">
                    </textarea>
                    <div>
                        <label App\Models\Product for="sizes"
                            class="block text-xs font-bold text-gray-400 uppercase mb-2">Available Sizes (ကော်မာ ခံပြီး
                            ရိုက်ထည့်ပါ)</label>
                        <input type="text" id="sizes" name="sizes" value="{{ old('sizes') }}"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white"
                            placeholder="e.g. S, M, L, XL သို့မဟုတ် 30ml, 50ml (မလိုလျှင် လွတ်ထားပါ)">
                        @error('sizes') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    @error('description') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- <div>
                    <div class="mb-4">
                        <label for="images" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product
                            Images (maximum size:2Mb)</label>

                        <input type="file" name="images[]" id="images" multiple onchange="previewImages(event)"
                            class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            accept="image/*">

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">You can upload more than one image for
                            this product.</p>
                    </div>
                    @error('images') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror

                    <div id="previewContainer"
                        class="mt-4 hidden grid grid-cols-3 gap-3 bg-gray-100 dark:bg-gray-700/50 p-3 rounded-xl border border-gray-200 dark:border-gray-700">
                    </div>
                </div> -->

                <div class="mt-6 border-t pt-4">
                    <h3 class="text-md font-bold text-gray-700 dark:text-gray-300 mb-2">📸 Product Images & Colors
                        (ကုန်ပစ္စည်းပုံများနှင့် အရောင်များ)</h3>
                    <p class="text-xs text-gray-400 mb-3">ပုံများကို တစ်ပြိုင်နက် စုရွေးနိုင်ပါသည်။ ရွေးပြီးပါက
                        ပုံတစ်ပုံချင်းစီအတွက် အရောင်သတ်မှတ်နိုင်မည့် အကွက်များ ပေါ်လာပါလိမ့်မည်။</p>

                    <div>
                        <input type="file" name="images[]" id="images" multiple
                            onchange="previewImagesWithColorInputs(event)"
                            class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600"
                            accept="image/*" required>
                        @error('images') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                        @error('images.*') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="previewContainer"
                        class="mt-4 hidden grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-100 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3 rounded-xl transition-all shadow-md">
                        Publish Product
                    </button>
                </div>
            </form>

        </div>
    </main>

    <script>
        // --- Multiple Image Preview Logic ---
        function previewImagesWithColorInputs(event) {
            const input = event.target;
            const container = document.getElementById('previewContainer');

            container.innerHTML = ''; // အဟောင်းတွေကို ရှင်းထုတ်မယ်

            if (input.files && input.files.length > 0) {
                container.classList.remove('hidden');

                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.className = 'p-3 bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-600 flex flex-col gap-2 relative';

                        div.innerHTML = `
                    <div class="aspect-video w-full rounded-lg overflow-hidden border">
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-400 uppercase mb-1">Color for Image ${index + 1}</label>
                        <input type="text" name="image_colors[${index}]" placeholder="e.g. gray, red (မလိုလျှင် လွတ်ထားပါ)" 
                               class="w-full px-3 py-1.5 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 dark:text-white">
                    </div>

                    <button type="button" onclick="removeUploadedImage(${index})" 
                            class="absolute top-2 right-2 bg-black/70 text-white w-5 h-5 rounded-full text-[10px] flex items-center justify-center hover:bg-rose-600 transition">✕</button>
                `;
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
            }
        }

        function removeUploadedImage(index) {
            const input = document.getElementById('images');
            const dt = new DataTransfer();
            const { files } = input;

            for (let i = 0; i < files.length; i++) {
                if (index !== i) dt.items.add(files[i]);
            }

            input.files = dt.files;
            previewImagesWithColorInputs({ target: input }); // Preview ပြန်ဆွဲမယ်
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
                if (darkModeToggle) darkModeToggle.checked = true;
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (darkModeToggle) darkModeToggle.checked = false;
            }
        }
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) updateTheme(true);
        if (darkModeRow) darkModeRow.addEventListener('click', () => updateTheme(!darkModeToggle.checked));
        if (menuBtn) menuBtn.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); sidebarOverlay.classList.remove('hidden'); });
        const closeSidebar = () => { sidebar.classList.add('-translate-x-full'); sidebarOverlay.classList.add('hidden'); };
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
    </script>
</body>

</html>