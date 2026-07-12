<x-app-layout :hideNav="true">
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

    <div class="flex flex-col h-screen overflow-hidden bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <nav
            class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-40 px-4 py-3 flex items-center justify-between border-b dark:border-gray-700">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="text-base font-bold tracking-wide">User Management</h2>
            </div>
        </nav>

        <main class="flex-grow p-6 overflow-y-auto pb-40">

            @if(session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 text-sm font-bold rounded-xl border border-emerald-200 dark:border-emerald-800/40">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 p-4 rounded-2xl shadow-sm mb-6"
                x-data="{
        // 💡 စာရိုက်လိုက်တာနဲ့ Auto Submit လုပ်ပေးမည့် Function (Debounce သုံးထားပါတယ်)
        autoSubmit() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.$refs.searchForm.submit();
            }, 500); // 💡 စာရိုက်ပြီး 0.5 စက္ကန့် ငြိမ်သွားတာနဲ့ Auto ရှာပေးပါမည်
        },
        searchTimeout: null
     }">

                <form x-ref="searchForm" action="{{ route('admin.users.index') }}" method="GET"
                    class="flex flex-col sm:flex-row gap-3">

                    <div class="flex-grow relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name or email..." {{-- 💡 စာရိုက်လိုက်တိုင်း autoSubmit() function
                            ကို လှမ်းခေါ်ခြင်း --}} @input="autoSubmit()"
                            class="w-full text-sm bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-blue-500 text-gray-700 dark:text-gray-200 font-medium"
                            autocomplete="off" {{-- 💡 Cursor လေးကို Search Box ရဲ့ နောက်ဆုံးစာလုံးနားမှာ အလိုအလျောက်
                            သွားထားပေးခြင်း --}}
                            x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length)">

                        <div class="absolute right-3 top-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <select name="role" {{-- 💡 Dropdown ပြောင်းလိုက်တာနဲ့ ချက်ချင်း Submit လုပ်ခြင်း --}}
                            @change="$refs.searchForm.submit()"
                            class="text-sm bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 focus:outline-none font-bold text-gray-700 dark:text-gray-200">
                            <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer
                            </option>
                        </select>
                    </div>

                </form>
            </div>

            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20 text-xs uppercase tracking-wider text-gray-400 font-bold">
                                <th class="p-4">User Details</th>
                                <th class="p-4">Role</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Last Login</th>
                                <th class="p-4">Joined Date</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50 text-sm">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition">

                                    <td class="p-4 flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 font-black flex items-center justify-center text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        @if($user->role === 'admin')
                                            <span
                                                class="text-[11px] font-bold text-purple-600 bg-purple-50 dark:bg-purple-950/30 px-2 py-1 rounded-md">Admin</span>
                                        @elseif($user->role === 'vendor')
                                            <span
                                                class="text-[11px] font-bold text-blue-600 bg-blue-50 dark:bg-blue-950/30 px-2 py-1 rounded-md">Vendor</span>
                                        @else
                                            <span
                                                class="text-[11px] font-bold text-gray-600 bg-gray-50 dark:bg-gray-700 px-2 py-1 rounded-md">Customer</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if($user->vendor_status === 'banned')
                                            <span
                                                class="text-[11px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-950/30 px-2 py-1 rounded-md">Banned</span>
                                        @else
                                            <span
                                                class="text-[11px] font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-950/30 px-2 py-1 rounded-md">Active</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-xs font-semibold text-gray-500 dark:text-gray-400">
                                        {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never logged in' }}
                                    </td>

                                    <td class="p-4 text-xs text-gray-400 font-medium">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="p-4 text-center flex justify-center gap-2">

                                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs font-bold px-3 py-1.5 rounded-xl border transition {{ $user->vendor_status === 'banned' ? 'border-emerald-200 text-emerald-600 hover:bg-emerald-50 dark:border-emerald-800' : 'border-rose-200 text-rose-600 hover:bg-rose-50 dark:border-rose-800' }}">
                                                {{ $user->vendor_status === 'banned' ? 'Unban' : 'Ban' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-xs font-bold px-3 py-1.5 rounded-xl bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 text-rose-500 dark:text-rose-400 transition">
                                                Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 font-bold">
                                        No users found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50/50 dark:bg-gray-700/10 border-t border-gray-100 dark:border-gray-700">
                    {{ $users->links() }}
                </div>

            </div>

        </main>
    </div>
</x-app-layout>