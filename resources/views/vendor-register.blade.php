<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Registration</title>

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
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}"
                class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-base font-bold tracking-wide">Become a Vendor</h2>
        </div>

        <!-- <button id="menuBtn"
            class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button> -->
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300"></div>
    <div id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between">
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
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Home Dashboard
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
            </div>
        </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 shadow-sm border border-gray-200 dark:border-gray-700/70">

            <div class="mb-6 text-center">
                <h1 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white mb-2">Register Your Shop
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Fill in the details to send a request to the system
                    administrator.</p>
            </div>

            @if(session('success'))
                <div
                    class="mb-6 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-sm p-4 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($user->vendor_status === 'pending')
                <div
                    class="text-center py-8 px-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/60 rounded-xl flex flex-col items-center justify-center gap-3">
                    <svg class="w-12 h-12 text-amber-500 animate-pulse" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="font-bold text-amber-800 dark:text-amber-400 text-base">Request Pending</h3>
                    <p class="text-xs text-amber-700 dark:text-amber-500/90 max-w-md leading-relaxed">
                        သင်တင်ထားသော ဆိုင်အချက်အလက်များကို Admin မှ စစ်ဆေးနေဆဲ ဖြစ်ပါသည်။ အတည်ပြုပြီးပါက Vendor စနစ်ကို
                        စတင်အသုံးပြုနိုင်ပါမည်။
                    </p>
                    <div
                        class="mt-4 text-xs bg-white dark:bg-gray-700 px-4 py-2 rounded-lg shadow-sm border dark:border-gray-600">
                        <span class="text-gray-400">Submitted Shop Name:</span> <strong
                            class="text-gray-800 dark:text-white">{{ $user->shop_name }}</strong>
                    </div>
                </div>

            @elseif($user->vendor_status === 'rejected')
                <div
                    class="mb-6 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-xs p-4 rounded-xl">
                    သင်၏ ယခင်တင်ထားသော တောင်းဆိုမှုကို Admin မှ ငြင်းပယ်ထားပါသည်။ အချက်အလက်များကို ပြန်လည်ပြင်ဆင်၍ Form
                    ပြန်တင်နိုင်ပါသည်။
                </div>
            @endif

            @if($user->vendor_status !== 'pending')
                <form action="{{ route('vendor.register.submit') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <div
                        class="bg-blue-50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900/50 rounded-xl p-4 flex flex-col sm:flex-row items-center gap-4">
                        <div
                            class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-[10px] text-gray-400 font-bold border-2 border-white dark:border-gray-600 shadow-sm flex-shrink-0">
                            [ Kpay / Wave QR ]
                        </div>
                        <div class="text-center sm:text-left">
                            <h4 class="font-bold text-sm text-blue-900 dark:text-blue-400">One-Time Registration Fee</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Please transfer **5,000 MMK** to the
                                QR code above to activate your vendor account capability.</p>
                        </div>
                    </div>

                    <div>
                        <label for="shop_name"
                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Shop
                            Name</label>
                        <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name', $user->shop_name) }}"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('shop_name') border-rose-500 focus:ring-rose-500 @enderror"
                            placeholder="Enter your shop name">
                        @error('shop_name') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shop_phone"
                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Contact
                            Phone Number</label>
                        <input type="text" id="shop_phone" name="shop_phone"
                            value="{{ old('shop_phone', $user->shop_phone) }}"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('shop_phone') border-rose-500 focus:ring-rose-500 @enderror"
                            placeholder="e.g. 09123456789">
                        @error('shop_phone') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shop_description"
                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Shop
                            Description</label>
                        <textarea id="shop_description" name="shop_description" rows="3"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white @error('shop_description') border-rose-500 focus:ring-rose-500 @enderror"
                            placeholder="What are you selling?">{{ old('shop_description', $user->shop_description) }}</textarea>
                        @error('shop_description') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Slip Upload Input (Image Preview) -->
                    <div>
                        <label for="payment_slip"
                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Upload
                            Payment Slip (Screenshot)</label>

                        <input type="file" id="payment_slip" name="payment_slip" accept="image/*"
                            onchange="previewImage(event)"
                            class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-gray-700 dark:file:text-gray-200 hover:file:bg-blue-100 border border-dashed border-gray-300 dark:border-gray-600 p-2 rounded-xl bg-gray-50/50 dark:bg-gray-700/30 @error('payment_slip') border-rose-500 @enderror">

                        @error('payment_slip')
                            <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p>
                        @enderror

                        <!-- Image Preview Area -->
                        <div id="previewContainer"
                            class="mt-4 hidden relative w-48 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm bg-gray-100 dark:bg-gray-800 p-1">
                            <img id="imagePreview" src="#" alt="Payment Slip Preview"
                                class="w-full h-auto object-contain rounded-lg">

                            <!-- to delete image -->
                            <button type="button" onclick="removeImage()"
                                class="absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white p-1 rounded-full transition-all">
                                <svg class="w-4 4-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3 rounded-xl transition-all shadow-md shadow-blue-600/20">
                            Submit Registration Request
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </main>

    <div
        class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg px-6 py-2 flex justify-around items-center z-40">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 text-blue-600 dark:text-blue-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10zM9 14h6v7H9v-7z"></path>
            </svg>
            <span class="text-[10px] font-medium">Shops</span>
        </a>
    </div>

    <script>
        // const menuBtn = document.getElementById('menuBtn');
        // const closeBtn = document.getElementById('closeBtn');
        // const sidebar = document.getElementById('sidebar');
        // const sidebarOverlay = document.getElementById('sidebarOverlay');
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeToggle = document.getElementById('darkModeToggle');

        // --- ၁။ Dark Mode Logic ---
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

        // --- ၂။ Sidebar Logic ---
        // if (menuBtn) {
        //     menuBtn.addEventListener('click', () => {
        //         sidebar.classList.remove('-translate-x-full');
        //         sidebarOverlay.classList.remove('hidden');
        //     });
        // }
        // const closeSidebar = () => {
        //     sidebar.classList.add('-translate-x-full');
        //     sidebarOverlay.classList.add('hidden');
        // };
        // if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        // if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

        function previewImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('previewContainer');
            const imagePreview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden'); // Hidden ကို ဖြုတ်ပြီး ပုံပြ
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('payment_slip');
            const previewContainer = document.getElementById('previewContainer');
            const imagePreview = document.getElementById('imagePreview');

            input.value = ""; // Input ထဲက ဖိုင်ဖျက်
            imagePreview.src = "#";
            previewContainer.classList.add('hidden'); // ပြန်ဖျောက်
        }
    </script>
</body>

</html>