<!DOCTYPE html>
<x-app-layout :hideSearch="true" :cartIcon="true" :messageIcon="true" :hideRoleMenu="true" :hideDarkMode="true">
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - User Management</title>

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

                    <a href="{{ route('admin.vendor.requests') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="normal-case tracking-normal">Vendor Requests</span>
                    </a>

                    <!-- <a href="{{ route('admin.users.index') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="normal-case tracking-normal">User Management</span>
                    </a> -->

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
            <!-- Header Section (Dark Blue Text Style) -->
            <div class="mb-6 select-none">
                <h1 class="text-2xl font-black tracking-wider text-yellow-400 mb-1">
                    User Management
                </h1>
                <p class="text-xs font-bold text-amber-300 tracking-wide">
                    Manage system accounts, assign roles, and control access statuses.
                </p>
            </div>

            <!-- Alert Session -->
            @if(session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-900/80 text-emerald-200 text-xs font-bold rounded-xl border border-emerald-500 shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filter Card (3D Card) -->
            <div class="card-3d p-4 rounded-2xl mb-6" x-data="{
                    autoSubmit() {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            this.$refs.searchForm.submit();
                        }, 500);
                    },
                    searchTimeout: null
                }">

                <form x-ref="searchForm" action="{{ route('admin.users.index') }}" method="GET"
                    class="flex flex-col sm:flex-row gap-3">

                    <div class="flex-grow relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name or email..." @input="autoSubmit()"
                            class="w-full text-sm bg-blue-900/80 border border-blue-500 rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-cyan-400 text-white font-medium placeholder-blue-300/60 shadow-inner"
                            autocomplete="off"
                            x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length)">

                        <div class="absolute right-3 top-3 text-cyan-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <select name="role" @change="$refs.searchForm.submit()"
                            class="btn-3d text-sm bg-blue-900 border border-blue-500 text-yellow-400 rounded-xl px-4 py-2.5 focus:outline-none font-bold cursor-pointer">
                            <option value="all" class="bg-blue-900 text-yellow-400" {{ request('role') == 'all' ? 'selected' : '' }}>All Roles</option>
                            <option value="admin" class="bg-blue-900 text-yellow-400" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="vendor" class="bg-blue-900 text-yellow-400" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                            <option value="customer" class="bg-blue-900 text-yellow-400" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                    </div>

                </form>
            </div>

            <!-- Users Table Card (3D Card View) -->
            <div class="card-3d rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-blue-950/60 text-yellow-400 font-black uppercase text-[11px] tracking-wider border-b border-blue-800">
                                <th class="p-4">User Details</th>
                                <th class="p-4">Role</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Last Login</th>
                                <th class="p-4">Joined Date</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-800/60 text-sm">
                            @forelse($users as $user)
                                <tr class="hover:bg-blue-800/40 transition-colors">

                                    <td class="p-4 flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-blue-950 text-cyan-300 border border-cyan-400 font-black flex items-center justify-center text-xs shadow-md">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-blue-200">{{ $user->email }}</div>
                                        </div>
                                    </td>

                                    <td class="p-4">
    @if($user->role === 'admin')
        <!-- Dark Red 3D Text -->
        <span class="text-xs font-black text-rose-600 [text-shadow:_0_1px_0_#4c0519,_0_2px_0_#27020d,_0_3px_2px_rgba(0,0,0,0.8)]">
            Admin
        </span>
    @elseif($user->role === 'vendor')
        <!-- Dark Green 3D Text -->
        <span class="text-xs font-black text-emerald-600 [text-shadow:_0_1px_0_#064e3b,_0_2px_0_#022c22,_0_3px_2px_rgba(0,0,0,0.8)]">
            Vendor
        </span>
    @else
        <!-- Gold 3D Text -->
        <span class="text-xs font-black text-amber-400 [text-shadow:_0_1px_0_#b45309,_0_2px_0_#78350f,_0_3px_2px_rgba(0,0,0,0.8)]">
            Customer
        </span>
    @endif
</td>

                                    <td class="p-4">
                                        @if($user->vendor_status === 'banned')
                                            <span
                                                class="btn-3d text-[11px] font-black text-rose-300 bg-rose-950/80 border border-rose-500 px-2.5 py-1 rounded-lg">Banned</span>
                                        @else
                                            <span
                                                class="btn-3d text-[11px] font-black text-emerald-300 bg-emerald-950/80 border border-emerald-500 px-2.5 py-1 rounded-lg">Active</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-xs font-semibold text-blue-200">
                                        {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never logged in' }}
                                    </td>

                                    <td class="p-4 text-xs text-blue-300 font-medium">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-2 items-center">
                                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn-3d text-xs font-black px-3 py-1.5 rounded-xl border transition {{ $user->vendor_status === 'banned' ? 'bg-emerald-600 border-emerald-400 text-white' : 'bg-amber-600 border-amber-400 text-white' }}">
                                                    {{ $user->vendor_status === 'banned' ? 'Unban' : 'Ban' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn-3d text-xs font-black px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-500 border border-rose-400 text-white transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-blue-200 font-bold">
                                        No users found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-blue-950/50 border-t border-blue-800">
                    {{ $users->links() }}
                </div>

            </div>

        </main>

        <script>
            const menuBtn = document.getElementById('menuBtn');
            const closeBtn = document.getElementById('closeBtn');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
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
        </script>
    </body>

    </html>
</x-app-layout>