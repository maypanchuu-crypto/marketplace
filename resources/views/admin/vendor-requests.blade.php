<!DOCTYPE html>
<x-app-layout :hideSearch="true" :cartIcon="true" :messageIcon="true" :hideRoleMenu="true" :hideDarkMode="true">
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Vendor Requests</title>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>
        <style>
            html,
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            [x-cloak] {
                display: none !important;
            }

            /* ✨ 3D Shadows & Neumorphic Effects (dashboard.blade.php Style) */
            .card-3d {
                background: linear-gradient(145deg, #1e3a8a, #1e40af);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4),
                    0 8px 10px -6px rgba(0, 0, 0, 0.3),
                    inset 0 1px 1px rgba(255, 255, 255, 0.2);
                border-bottom: 4px solid #172554;
            }

            .btn-3d {
                box-shadow: 0 4px 0px #1e3a8a, 0 6px 12px rgba(0, 0, 0, 0.3);
                transition: all 0.1s ease;
            }

            .btn-3d:active {
                transform: translateY(3px);
                box-shadow: 0 1px 0px #1e3a8a, 0 2px 4px rgba(0, 0, 0, 0.3);
            }
        </style>
    </head>

    <body class="bg-blue-600 text-white min-h-screen font-sans antialiased pt-16">

        <!-- Sidebar Overlay -->
        <div id="sidebarOverlay"
            class="fixed top-16 inset-x-0 bottom-0 bg-blue-950/60 backdrop-blur-sm z-30 hidden transition-opacity duration-300">
        </div>

        <!-- Sidebar Navigation -->
        <div id="sidebar"
            class="fixed top-16 left-0 h-[calc(100vh-4rem)] w-64 bg-blue-900 z-40 shadow-2xl border-r-4 border-blue-950 border-t border-blue-800 transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-black tracking-wider text-yellow-400 drop-shadow">ADMIN MENU</h2>
                    <button id="closeBtn" class="text-blue-200 hover:text-white p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Menu Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="normal-case tracking-normal">Customer Marketplace</span>
                    </a>

                    <!-- <a href="{{ route('admin.vendor.requests') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="normal-case tracking-normal">Vendor Requests</span>
                    </a> -->

                    <a href="{{ route('admin.users.index') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="normal-case tracking-normal">User Management</span>
                    </a>

                    <a href="#"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12 3 7.582 7.03 4 12 4s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span class="normal-case tracking-normal">Communication</span>
                    </a>

                    <div id="darkModeRow"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm cursor-pointer border border-blue-700 select-none transform transition duration-200 hover:-translate-y-1">
                        <svg id="nightModeIcon" class="w-5 h-5 text-yellow-400 block dark:hidden" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg id="dayModeIcon" class="w-5 h-5 text-amber-400 hidden dark:block" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M6.343 6.343l.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                        <span id="darkModeText" class="normal-case tracking-normal">Night Mode</span>
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="border-t border-blue-800 pt-4">
                @csrf
                <button type="submit"
                    class="btn-3d w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-rose-600 text-white font-medium text-sm text-left border border-rose-700 transform transition duration-200 hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
        <!-- Main Content Area -->
        <main class="flex-grow p-6 overflow-y-auto pb-40">
            <!-- Header Section -->
            <div class="mb-6 select-none">
                <h1 class="text-2xl font-black tracking-wider text-yellow-400 mb-1">
                    Vendor Application Requests
                </h1>
                <p class="text-xs font-bold text-amber-300 tracking-wide">
                    Review and manage incoming store registrations from customers.
                </p>
            </div>

            <!-- Flash Alerts -->
            @if(session('success'))
                <div
                    class="mb-4 bg-emerald-900/80 border border-emerald-500 text-emerald-200 text-xs p-4 rounded-xl shadow-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-rose-900/80 border border-rose-500 text-rose-200 text-xs p-4 rounded-xl shadow-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Desktop Table View (Card-3D Design) -->
            <div class="card-3d rounded-2xl overflow-hidden hidden md:block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr
                                class="bg-blue-950/60 text-yellow-400 font-black uppercase text-[11px] tracking-wider border-b border-blue-800">
                                <th class="p-4">Applicant</th>
                                <th class="p-4">Shop Name</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Phone</th>
                                <th class="p-4">Description</th>
                                <th class="p-4">Payment Slip</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-800/60">
                            @forelse($requests as $req)
                                <tr class="hover:bg-blue-800/40 transition-colors">
                                    <td class="p-4 font-bold text-white">
                                        {{ $req->name }}<br>
                                        <span class="text-xs text-blue-200 font-normal">{{ $req->email }}</span>
                                    </td>
                                    <td class="p-4 font-black text-cyan-300 drop-shadow-sm">{{ $req->shop_name }}</td>
                                    <td class="p-4 text-blue-100">{{ $req->email }}</td>
                                    <td class="p-4 text-blue-100">{{ $req->shop_phone }}</td>
                                    <td class="p-4 text-blue-200 max-w-xs truncate" title="{{ $req->shop_description }}">
                                        {{ $req->shop_description }}
                                    </td>
                                    <td class="p-4">
                                        @if($req->payment_slip)
                                            <button onclick="showSlip('{{ asset('storage/' . $req->payment_slip) }}')"
                                                class="btn-3d text-xs bg-blue-900 hover:bg-blue-800 text-cyan-300 font-bold px-3 py-1.5 rounded-xl border border-cyan-500 transition-all flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                View Slip
                                            </button>
                                        @else
                                            <span class="text-xs text-blue-300/60 font-semibold">No Slip</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex justify-end gap-2 items-center">
                                            <form action="{{ route('admin.vendor.approve', $req->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn-3d bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs px-3.5 py-1.5 rounded-xl border border-emerald-400">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.vendor.reject', $req->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn-3d bg-rose-600 hover:bg-rose-500 text-white font-black text-xs px-3.5 py-1.5 rounded-xl border border-rose-400">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-blue-200 font-bold">
                                        No pending vendor requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="space-y-4 md:hidden">
                @forelse($requests as $req)
                    <div class="card-3d rounded-2xl p-5 space-y-3">
                        <div>
                            <div class="text-[11px] font-black text-blue-200 uppercase tracking-wider">Applicant</div>
                            <div class="font-bold text-white text-sm">{{ $req->name }} <span
                                    class="text-xs text-blue-300 font-normal">({{ $req->email }})</span></div>
                        </div>
                        <div>
                            <div class="text-[11px] font-black text-blue-200 uppercase tracking-wider">Shop Name & Phone
                            </div>
                            <div class="font-black text-cyan-300 text-sm">{{ $req->shop_name }} <span
                                    class="text-blue-200 font-normal text-xs ml-2">({{ $req->shop_phone }})</span></div>
                        </div>
                        <div>
                            <div class="text-[11px] font-black text-blue-200 uppercase tracking-wider">Description</div>
                            <p class="text-xs text-blue-100 leading-relaxed">{{ $req->shop_description }}</p>
                        </div>
                        @if($req->payment_slip)
                            <div>
                                <button onclick="showSlip('{{ asset('storage/' . $req->payment_slip) }}')"
                                    class="btn-3d text-xs bg-blue-900 text-cyan-300 font-bold px-3 py-1.5 rounded-xl border border-cyan-500 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    View Slip
                                </button>
                            </div>
                        @endif
                        <div class="flex gap-2 pt-3 border-t border-blue-800">
                            <form action="{{ route('admin.vendor.approve', $req->id) }}" method="POST" class="w-1/2">
                                @csrf
                                <button type="submit"
                                    class="btn-3d w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs py-2 rounded-xl border border-emerald-400">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.vendor.reject', $req->id) }}" method="POST" class="w-1/2">
                                @csrf
                                <button type="submit"
                                    class="btn-3d w-full bg-rose-600 hover:bg-rose-500 text-white font-black text-xs py-2 rounded-xl border border-rose-400">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="card-3d text-center py-12 text-blue-200 rounded-2xl font-bold">
                        No pending vendor requests found.
                    </div>
                @endforelse
            </div>
        </main>

        <!-- Payment Slip Modal -->
        <div id="slipModal"
            class="fixed inset-0 bg-blue-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4"
            onclick="closeSlip()">
            <div class="relative max-w-md w-full card-3d p-4 rounded-2xl border border-blue-700 shadow-2xl"
                onclick="event.stopPropagation()">
                <button onclick="closeSlip()"
                    class="absolute top-4 right-4 bg-blue-950 text-white p-1.5 rounded-full hover:bg-rose-600 border border-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <img id="slipImage" src=""
                    class="w-full h-auto max-h-[75vh] object-contain rounded-xl border border-blue-800"
                    alt="Payment Slip">
            </div>
        </div>

        <script>
            const darkModeRow = document.getElementById('darkModeRow');

            function updateTheme(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    if (darkModeText) darkModeText.textContent = 'Day Mode';
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    if (darkModeText) darkModeText.textContent = 'Night Mode';
                }
            }

            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                updateTheme(true);
            } else {
                updateTheme(false);
            }

            if (darkModeRow) {
                darkModeRow.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.contains('dark');
                    updateTheme(!isDark);
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

            // Payment Slip Modal Functions
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
</x-app-layout>