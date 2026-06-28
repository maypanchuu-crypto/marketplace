<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Vendor Requests</title>

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
            <h2 class="text-base font-bold tracking-wide">Admin Panel</h2>
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
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Admin Menu</h2>
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

    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white mb-1">Vendor Application
                Requests</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">Review and manage incoming store registrations from
                customers.</p>
        </div>

        @if(session('success'))
            <div
                class="mb-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs p-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div
                class="mb-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-xs p-4 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <div
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700/70 shadow-sm overflow-hidden hidden md:block">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr
                            class="bg-gray-50 dark:bg-gray-700/50 text-gray-400 font-bold uppercase text-[11px] tracking-wider border-b dark:border-gray-700">
                            <th class="p-4">Applicant</th>
                            <th class="p-4">Shop Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Phone</th>
                            <th class="p-4">Description</th>
                            <th class="p-4">Payment Slip</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700/60">
                        @forelse($requests as $req)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                <td class="p-4 font-semibold text-gray-900 dark:text-white">{{ $req->name }}<br><span
                                        class="text-xs text-gray-400 font-normal">{{ $req->email }}</span></td>
                                <td class="p-4 font-bold text-blue-600 dark:text-blue-400">{{ $req->shop_name }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-300">{{ $req->email }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-300">{{ $req->shop_phone }}</td>
                                <td class="p-4 text-gray-500 dark:text-gray-400 max-w-xs truncate"
                                    title="{{ $req->shop_description }}">{{ $req->shop_description }}</td>
                                <td class="p-4">
                                    @if($req->payment_slip)
                                        <button onclick="showSlip('{{ asset('storage/' . $req->payment_slip) }}')"
                                            class="text-xs bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold px-2.5 py-1.5 rounded-lg border dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-600 transition-all flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            View Slip
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400">No Slip</span>
                                    @endif
                                </td>
                                <!-- <td class="p-4 text-gray-500 dark:text-gray-400 max-w-xs truncate" -->
                                    <!-- title="{{ $req->payment_slip }}">Payment Slip</td> -->
                                <td class="p-4 text-right flex justify-end gap-2 items-center h-full pt-5">
                                    <form action="{{ route('admin.vendor.approve', $req->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition-all">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.vendor.reject', $req->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition-all">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400">No pending vendor requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4 md:hidden">
            @forelse($requests as $req)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700/70 shadow-sm space-y-3">
                    <div>
                        <div class="text-xs text-gray-400">Applicant</div>
                        <div class="font-semibold dark:text-white text-sm">{{ $req->name }} ({{ $req->email }})</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Shop Name & Phone</div>
                        <div class="font-bold text-blue-600 dark:text-blue-400 text-sm">{{ $req->shop_name }} <span
                                class="text-gray-400 font-normal text-xs ml-2">({{ $req->shop_phone }})</span></div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Description</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $req->shop_description }}</p>
                    </div>
                    <div class="flex gap-2 pt-2 border-t dark:border-gray-700">
                        <form action="{{ route('admin.vendor.approve', $req->id) }}" method="POST" class="w-1/2">
                            @csrf
                            <button type="submit"
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2 rounded-lg transition-all">Approve</button>
                        </form>
                        <form action="{{ route('admin.vendor.reject', $req->id) }}" method="POST" class="w-1/2">
                            @csrf
                            <button type="submit"
                                class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs py-2 rounded-lg transition-all">Reject</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-400 bg-white dark:bg-gray-800 rounded-xl border">No pending vendor
                    requests found.</div>
            @endforelse
        </div>
    </main>

    <div id="slipModal" class="fixed inset-0 bg-black/70 z-50 hidden flex items-center justify-center p-4"
        onclick="closeSlip()">
        <div class="relative max-w-md w-full bg-white dark:bg-gray-800 p-3 rounded-2xl shadow-2xl"
            onclick="event.stopPropagation()">
            <button onclick="closeSlip()"
                class="absolute top-4 right-4 bg-black/50 text-white p-1.5 rounded-full hover:bg-black/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="slipImage" src="" class="w-full h-auto max-h-[75vh] object-contain rounded-xl" alt="Payment Slip">
        </div>
    </div>

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

        // Payment Slip Modal
        function showSlip(src) {
            document.getElementById('slipImage').src = src;
            document.getElementById('slipModal').classList.remove('hidden');
        }
        function closeSlip() {
            document.getElementById('slipModal').classList.add('hidden');
        }
    </script>
</body>

</html>