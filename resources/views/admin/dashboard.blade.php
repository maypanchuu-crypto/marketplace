<!DOCTYPE html>
<x-app-layout :hideSearch="true" :cartIcon="true" :messageIcon="true" :hideRoleMenu="true" :hideDarkMode="true">
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

            /* ✨ 3D Shadows & Neumorphic Effects */
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

            .bar-3d {
                box-shadow: 2px -2px 5px rgba(255, 255, 255, 0.2), -2px 2px 5px rgba(0, 0, 0, 0.4);
            }
        </style>
    </head>

    <body class="bg-blue-600 text-white min-h-screen font-sans antialiased pt-16">
        <!-- 💡 Main Layout ကို Navbar ရဲ့ Height အလိုက် တွန်းပေးဖို့ pt-16 ထည့်ထားပါတယ် -->

        <!-- Sidebar Overlay (Navbar အောက် ရောက်စေရန် top-16 နဲ့ z-30 ထားပါသည်) -->
        <div id="sidebarOverlay"
            class="fixed top-16 inset-x-0 bottom-0 bg-blue-950/60 backdrop-blur-sm z-30 hidden transition-opacity duration-300">
        </div>

        <div id="sidebar"
            class="fixed top-16 left-0 h-[calc(100vh-4rem)] w-64 bg-blue-900 z-40 shadow-2xl border-r-4 border-blue-950 border-t border-blue-800 transform -translate-x-full transition-transform duration-300 ease-in-out p-5 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-black tracking-wider text-yellow-400 drop-shadow">ADMIN MENU</h2>
                    <!-- Close Icon X (မူလအတိုင်း ဘာ Animation မှ မပါပါ) -->
                    <button id="closeBtn" class="text-blue-200 hover:text-white p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3">

                    <!-- <a href="{{ route('admin.dashboard') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a> -->

                    <a href="{{ route('dashboard') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"></path>
                        </svg>
                        Customer Marketplace
                    </a>

                    <a href="{{ route('admin.vendor.requests') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Vendor Requests
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        User Management
                    </a>

                    <a href="#"
                        class="btn-3d flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-800 text-white font-medium text-sm border border-blue-700 transform transition duration-200 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12 3 7.582 7.03 4 12 4s9 3.582 9 8z">
                            </path>
                        </svg>
                        Communication
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
                        <span id="darkModeText" class="tracking-wide">Night Mode</span>
                    </div>
                </div>
            </div>

            <!-- Logout Button (Card Effect) -->
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
            <!-- Stat Cards Section -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div
                    class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                    <div>
                        <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Total Stores</span>
                        <div class="text-4xl font-black mt-2 text-white drop-shadow-md">
                            {{ number_format($totalStores) }}
                        </div>
                    </div>
                </div>

                <div
                    class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                    <div>
                        <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Active Users</span>
                        <div class="text-4xl font-black mt-2 text-white drop-shadow-md">
                            {{ number_format($activeUsers) }}
                        </div>
                    </div>
                </div>

                <div
                    class="card-3d p-6 rounded-2xl flex justify-between items-center transform transition duration-200 hover:-translate-y-1">
                    <div>
                        <span class="text-xs font-black text-blue-200 uppercase tracking-wider">Monthly Revenue</span>
                        <div class="text-3xl font-black mt-2 text-cyan-300 drop-shadow-md">4.8M MMK</div>
                    </div>
                    <span
                        class="btn-3d text-xs font-black text-emerald-300 bg-emerald-900/80 border border-emerald-500 px-3 py-1.5 rounded-xl">+21%</span>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Revenue Growth Chart -->
                <div class="card-3d rounded-2xl p-6 flex flex-col justify-between" x-data="{
                        selectedYear: new Date().getFullYear(),
                        selectedMonth: new Date().getMonth() + 1,
                        
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
                                <h3 class="text-xl font-black text-white drop-shadow">Revenue Growth</h3>
                                <p class="text-xs text-blue-200">Daily financial performance analysis.</p>
                            </div>

                            <div class="flex gap-2">
                                <select x-model="selectedYear"
                                    class="btn-3d text-xs bg-blue-900 border border-blue-500 text-white rounded-xl px-3 py-2 focus:outline-none font-bold cursor-pointer">
                                    <template x-for="year in availableYears()" :key="year">
                                        <option :value="year" x-text="year" :selected="year === selectedYear"></option>
                                    </template>
                                </select>

                                <select x-model="selectedMonth"
                                    class="btn-3d text-xs bg-blue-900 border border-blue-500 text-white rounded-xl px-3 py-2 focus:outline-none font-bold cursor-pointer">
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
                                class="h-48 flex items-end gap-[3px] pt-4 border-b-2 border-blue-900/80 px-1 min-w-[500px]">
                                <template x-for="day in daysInMonth()" :key="day">
                                    <div class="flex-1 flex flex-col items-center group h-full justify-end">
                                        <div class="absolute mb-16 hidden group-hover:block bg-blue-950 text-yellow-300 border border-yellow-400 text-[10px] font-black px-2 py-1 rounded-lg shadow-2xl z-20 whitespace-nowrap"
                                            x-text="'Day ' + day + ': ' + (parseInt(getGraphHeight(day)) * 500).toLocaleString() + ' MMK'">
                                        </div>
                                        <div class="w-full bar-3d bg-gradient-to-t from-blue-700 to-cyan-400 group-hover:from-yellow-500 group-hover:to-amber-300 rounded-t-sm transition-all duration-200 relative cursor-pointer"
                                            :class="day === daysInMonth() ? 'bg-gradient-to-t from-amber-500 to-yellow-300' : ''"
                                            :style="{ height: getGraphHeight(day) }">
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div
                                class="flex justify-between text-[11px] font-black text-blue-200 mt-3 px-1 min-w-[500px]">
                                <span>Day 1</span>
                                <span x-text="'Day ' + Math.floor(daysInMonth()/2)"></span>
                                <span x-text="'Day ' + daysInMonth()"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-blue-800 flex justify-between items-center text-xs">
                        <span class="text-blue-200">Total days showing: <strong class="text-cyan-300 font-black"
                                x-text="daysInMonth() + ' Days'"></strong></span>
                        <span class="btn-3d text-[11px] bg-cyan-500 text-blue-950 font-black px-3 py-1 rounded-lg">Live
                            Tracker</span>
                    </div>
                </div>

                <!-- Registrations Growth Chart Card -->
                <div class="card-3d rounded-2xl p-6 flex flex-col justify-between" x-data="{
                        selectedRegYear: new Date().getFullYear(),
                        chartInstance: null,
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

                        getYearlyData() {
                            return this.dbData[this.selectedRegYear] ? this.dbData[this.selectedRegYear] : [0,0,0,0,0,0,0,0,0,0,0,0];
                        },

                        initChart() {
                            const renderWaveChart = () => {
                                const canvas = document.getElementById('registrationsWaveChart');
                                if (!canvas) return;
                                const ctx = canvas.getContext('2d');
                                
                                if (this.chartInstance) {
                                    this.chartInstance.destroy();
                                }
                                
                                let gradient = ctx.createLinearGradient(0, 0, 0, 180);
                                gradient.addColorStop(0, 'rgba(34, 211, 238, 0.6)'); 
                                gradient.addColorStop(1, 'rgba(34, 211, 238, 0.0)'); 
                                
                                this.chartInstance = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                        datasets: [{
                                            label: 'Registrations',
                                            data: this.getYearlyData(),
                                            borderColor: '#22d3ee', 
                                            backgroundColor: gradient, 
                                            borderWidth: 4,
                                            fill: true,
                                            tension: 0.4, 
                                            pointRadius: 5, 
                                            pointHoverRadius: 8,
                                            pointBackgroundColor: '#fbbf24',
                                            pointBorderColor: '#ffffff',
                                            pointBorderWidth: 2
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
                                                ticks: { color: '#93c5fd', font: { size: 11, weight: 'bold' } }
                                            }  
                                        }
                                    }
                                });
                            };

                            renderWaveChart();

                            this.$watch('selectedRegYear', value => {
                                renderWaveChart();
                            });
                        }
                    }" x-init="initChart()">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-black text-white drop-shadow">Registrations Growth</h3>
                            </div>

                            <select x-model="selectedRegYear"
                                class="btn-3d text-xs bg-blue-900 border border-blue-500 text-white rounded-xl px-3 py-2 focus:outline-none font-bold cursor-pointer">
                                <template x-for="year in availableRegYears()" :key="year">
                                    <option :value="year" x-text="year" :selected="year == selectedRegYear"></option>
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