<!-- <h1>Admin Dashboard</h1>
<a href="{{ route('admin.vendor.requests') }}">
    <button type="submit">Vendor Requests</button>
</a>
<a href="{{ route('admin.orders.index') }}" class="...">Admin Orders</a> -->

<!DOCTYPE html>
<x-app-layout :hideSearch="true">
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Super Admin Dashboard</title>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        </style>
    </head>

    <body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">

        <div class="flex h-screen overflow-hidden">
            <div id="sidebarOverlay"
                class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300 overflow-y-auto">
            </div>
            <div id="sidebar"
                class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 z-50 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto">
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-black tracking-wider text-blue-600 dark:text-blue-400">SUPER ADMIN</h2>
                        <button id="closeBtn" class="text-gray-500 hover:text-gray-800 dark:hover:text-white p-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-1">
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold rounded-xl text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z">
                                </path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm border-t dark:border-gray-700 mt-4 pt-4">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                            </svg>
                            Customer Marketplace
                        </a>
                        <a href="{{ route('admin.vendor.requests') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Vendor Requests
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            User Management
                        </a>

                        <!-- <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/40 rounded-xl text-sm font-semibold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2zm9 0V4a2 2 0 012-2h2a2 2 0 012 2v15a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Analytics
                        </a> -->

                        <a href="{{ route('message.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12 3 7.582 7.03 4 12 4s9 3.582 9 8z">
                                </path>
                            </svg>
                            Message
                        </a>

                        <div id="darkModeRow"
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm cursor-pointer select-none">
                            <span class="flex items-center gap-3 tracking-wide">
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

                        <!-- <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium text-sm">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        Messages
                        </a> -->
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}"
                    class="border-t border-gray-100 dark:border-gray-700 pt-4">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 font-medium text-sm text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

            <main class="flex-grow p-6 overflow-y-auto pb-40">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 p-5 rounded-2xl shadow-sm flex justify-between items-center">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Stores</span>
                            <div class="text-2xl font-black mt-1 text-gray-900 dark:text-white">
                                {{ number_format($totalStores) }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 p-5 rounded-2xl shadow-sm flex justify-between items-center">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Users</span>
                            <div class="text-2xl font-black mt-1 text-gray-900 dark:text-white">
                                {{ number_format($activeUsers) }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 p-5 rounded-2xl shadow-sm flex justify-between items-center">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Monthly
                                Revenue</span>
                            <div class="text-2xl font-black mt-1 text-blue-600 dark:text-blue-400">4.8M MMK</div>
                        </div>
                        <span
                            class="text-xs font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-950/30 px-2 py-1 rounded-lg">+21%</span>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl p-6 shadow-sm flex flex-col justify-between"
                        x-data="{
                            selectedYear: new Date().getFullYear(), // 💡 လက်ရှိရောက်နေသော နှစ်ကို အလိုအလျောက် Default ပေးထားမည်
                            selectedMonth: new Date().getMonth() + 1, // 💡 လက်ရှိရောက်နေသော လကို အလိုအလျောက် Default ပေးထားမည်
                            
                            // 📅 ၂၀၂၄ မှ စ၍ လက်ရှိနှစ်အထိ နှစ်အရေအတွက်ကို အလိုအလျောက် တွက်ချက်ထုတ်ပေးသော Function
                            availableYears() {
                                let startYear = 2024;
                                let currentYear = new Date().getFullYear();
                                let years = [];
                                for (let y = startYear; y <= currentYear; y++) {
                                    years.push(y);
                                }
                                return years;
                            },

                            daysInMonth() {
                                return new Date(this.selectedYear, this.selectedMonth, 0).getDate();
                            },
                            getGraphHeight(day) {
                                let heights = [30, 45, 40, 65, 85, 70, 50, 90, 35, 60, 75, 40, 55, 80, 95, 20, 65, 50, 70, 85, 40, 60, 30, 75, 90, 45, 60, 55, 70, 80, 65];
                                return (heights[(day - 1) % heights.length]) + '%';
                            }
                        }">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                                <div>
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Revenue Growth</h3>
                                    <p class="text-xs text-gray-400">Daily financial performance analysis.</p>
                                </div>

                                <div class="flex gap-2">

                                    <select x-model="selectedYear"
                                        class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 focus:outline-none font-bold text-gray-700 dark:text-gray-200">
                                        <template x-for="year in availableYears()" :key="year">
                                            <option :value="year" x-text="year" :selected="year === selectedYear">
                                            </option>
                                        </template>
                                    </select>

                                    <select x-model="selectedMonth"
                                        class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 focus:outline-none font-bold text-gray-700 dark:text-gray-200">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>

                            <div class="overflow-x-auto pb-2 select-none">
                                <div
                                    class="h-48 flex items-end gap-[3px] pt-4 border-b border-gray-100 dark:border-gray-700 px-1 min-w-[500px]">
                                    <template x-for="day in daysInMonth()" :key="day">
                                        <div class="flex-1 flex flex-col items-center group h-full justify-end">
                                            <div class="absolute mb-16 hidden group-hover:block bg-gray-900 text-white text-[9px] font-black px-1.5 py-0.5 rounded shadow-md z-10 whitespace-nowrap"
                                                x-text="'Day ' + day + ': ' + (parseInt(getGraphHeight(day)) * 500).toLocaleString() + ' MMK'">
                                            </div>
                                            <div class="w-full bg-blue-100 dark:bg-blue-900/20 group-hover:bg-blue-600 rounded-t-[2px] transition-all duration-300 relative cursor-pointer"
                                                :class="day === daysInMonth() ? 'bg-blue-600 dark:bg-blue-500' : ''"
                                                :style="{ height: getGraphHeight(day) }">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div
                                    class="flex justify-between text-[9px] font-bold text-gray-400 mt-2 px-1 min-w-[500px]">
                                    <span>Day 1</span>
                                    <span x-text="'Day ' + Math.floor(daysInMonth()/2)"></span>
                                    <span x-text="'Day ' + daysInMonth()"></span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/50 flex justify-between items-center text-xs">
                            <span class="text-gray-400">Total days showing: <strong
                                    class="text-blue-600 dark:text-blue-400"
                                    x-text="daysInMonth() + ' Days'"></strong></span>
                            <span
                                class="text-[11px] bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-bold px-2 py-0.5 rounded-lg">
                                Live Tracker</span>
                        </div>
                    </div>

                    <div class="col-span-1 lg:col-span-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/70 rounded-2xl p-6 shadow-sm flex flex-col justify-between"
                        x-data="{
                            selectedRegYear: new Date().getFullYear(),
                            chartInstance: null,
                            
                            // 💡 Controller မှ ပို့လိုက်သော Array ကို JavaScript Object အဖြစ် ပြောင်းယူခြင်း
                            dbData: {{ json_encode($registrationsData) }},

                            availableRegYears() {
                                let startYear = 2024;
                                let currentYear = new Date().getFullYear();
                                let years = [];
                                for (let y = startYear; y <= currentYear; y++) {
                                    years.push(y);
                                }
                                return years;
                            },

                            // 💡 ရွေးချယ်လိုက်သော ခုနှစ်အလိုက် ဒေတာကို ကွက်တိဆွဲထုတ်ပြီး Graph ထဲ ထည့်ပေးမည့် Function
                            getYearlyData() {
                                return this.dbData[this.selectedRegYear] ? this.dbData[this.selectedRegYear] : [0,0,0,0,0,0,0,0,0,0,0,0];
                            },

                            initChart() {
                                // 💡 Function အဟောင်းကို ဖျက်ပြီး ဤ စနစ်သစ်အတိုင်း အစားထိုးပါ
                                const renderWaveChart = () => {
                                    const canvas = document.getElementById('registrationsWaveChart');
                                    if (!canvas) return;
                                    const ctx = canvas.getContext('2d');
                                    
                                    // 💡 အရင်ရှိပြီးသား Chart Component အဟောင်းရှိရင် memory ထဲကပါ အပြီးဖျက်ပစ်ခြင်း
                                    if (this.chartInstance) {
                                        this.chartInstance.destroy();
                                    }
                                    
                                    let gradient = ctx.createLinearGradient(0, 0, 0, 180);
                                    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.35)'); 
                                    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)'); 
                                    
                                    // Chart အသစ်စက်စက်ကို Data အသစ်နဲ့ ဆောက်ခြင်း
                                    this.chartInstance = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                            datasets: [{
                                                label: 'Registrations',
                                                data: this.getYearlyData(), // 💡 ရွေးထားတဲ့ နှစ်အလိုက် ဒေတာ ကွက်တိဝင်မည်
                                                borderColor: '#3b82f6', 
                                                backgroundColor: gradient, 
                                                borderWidth: 2.5,
                                                fill: true,
                                                tension: 0.4, 
                                                pointRadius: 3, 
                                                pointHoverRadius: 6,
                                                pointBackgroundColor: '#3b82f6'
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: { legend: { display: false } },
                                            scales: {
                                                y: { 
                                                    display: false,
                                                    beginAtZero: true 
                                                }, 
                                                x: { 
                                                    display: true, 
                                                    grid: { display: false },
                                                    ticks: { color: '#9ca3af', font: { size: 9, weight: 'bold' } }
                                                }  
                                            }
                                        }
                                    });
                                };

                                // စာမျက်နှာ စပွင့်ချင်း Chart စဆွဲခြင်း
                                renderWaveChart();

                                // 💡 Select Box ပြောင်းလဲတာနဲ့ Chart ကို အသစ်ပြန်ဆွဲခိုင်းခြင်း (Destroy & Recreate)
                                this.$watch('selectedRegYear', value => {
                                    renderWaveChart();
                                });
                            }
                        }" x-init="initChart()">
                        <div>
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Registrations Growth
                                    </h3>
                                </div>

                                <select x-model="selectedRegYear"
                                    class="text-xs bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 focus:outline-none font-bold text-gray-700 dark:text-gray-200">
                                    <template x-for="year in availableRegYears()" :key="year">
                                        <option :value="year" x-text="year" :selected="year == selectedRegYear">
                                        </option>
                                    </template>
                                </select>
                            </div>

                            <div class="h-48 relative select-none">
                                <canvas id="registrationsWaveChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

            </main>
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
        </script>
    </body>

    </html>
</x-app-layout>