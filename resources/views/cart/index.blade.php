<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-gray-50 dark:bg-gray-950 flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">

        <!-- 💡 🌈 RAINBOW BACKGROUND CARD CONTAINER -->
        <div
            class="max-w-5xl w-full bg-gradient-to-br from-red-500 via-amber-400 via-green-500 via-cyan-500 to-purple-600 rounded-3xl p-6 sm:p-8 border border-white/40 shadow-xl">

            <h1 class="text-2xl sm:text-3xl font-black text-center text-white mb-8 tracking-tight drop-shadow-md">
                Shopping Cart
            </h1>

            @if(!empty($cart) && count($cart) > 0)
                <!-- 💡 Inside Content Wrapper (Glassmorphism Container for readable content) -->
                <div
                    class="bg-white/95 dark:bg-gray-900/95 p-6 sm:p-8 rounded-2xl border border-white/60 dark:border-gray-800 shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="border-b-2 border-gray-200 dark:border-gray-800 text-amber-600 dark:text-amber-500 text-xs font-black uppercase tracking-wider">
                                    <th class="pb-4">Product</th>
                                    <th class="pb-4 text-center">Quantity</th>
                                    <th class="pb-4 text-right">Price</th>
                                    <th class="pb-4 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800/60">
                                @foreach($cart as $id => $details)
                                    <tr data-id="{{ $id }}" class="text-sm text-gray-700 dark:text-gray-300">
                                        <td class="py-6 flex items-center gap-4">
                                            <div
                                                class="w-20 h-20 rounded-xl overflow-hidden bg-gray-50 border-2 border-amber-400/40 dark:border-gray-700 flex-shrink-0 shadow-sm">
                                                <img src="{{ asset('storage/' . $details['image']) }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $details['name'] }}</h4>
                                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ number_format($details['price']) }} MMK
                                                </p>

                                                @if(!empty($details['size']) || !empty($details['color']))
                                                    <div class="flex gap-2 mt-2">
                                                        @if(isset($details['size']) && $details['size'])
                                                            <span
                                                                class="px-2 py-0.5 bg-amber-50 dark:bg-amber-950/40 text-[11px] font-bold text-amber-700 dark:text-amber-400 rounded-md border border-amber-300 dark:border-amber-800">
                                                                Size: {{ strtoupper($details['size']) }}
                                                            </span>
                                                        @endif
                                                        @if(isset($details['color']) && $details['color'])
                                                            <span
                                                                class="px-2 py-0.5 bg-amber-50 dark:bg-amber-950/40 text-[11px] font-bold text-amber-700 dark:text-amber-400 rounded-md border border-amber-300 dark:border-amber-800 flex items-center gap-1">
                                                                Color: {{ ucfirst($details['color']) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="py-6 text-center">
                                            <div
                                                class="inline-flex items-center border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 p-1 shadow-inner">
                                                <button
                                                    class="px-2.5 py-1 text-gray-600 hover:text-black dark:text-gray-300 dark:hover:text-white font-black update-cart-btn minus-btn transition-colors">-</button>
                                                <input type="number" value="{{ $details['quantity'] }}" min="1"
                                                    max="{{ $details['stock'] ?? 99 }}"
                                                    class="w-12 text-center bg-transparent border-none text-xs font-black focus:outline-none quantity-input dark:text-white">
                                                <button
                                                    class="px-2.5 py-1 text-gray-600 hover:text-black dark:text-gray-300 dark:hover:text-white font-black update-cart-btn plus-btn transition-colors">+</button>
                                            </div>
                                        </td>

                                        <td class="py-6 text-right font-black text-red-600 dark:text-red-400">
                                            {{ number_format($details['price'] * $details['quantity']) }} MMK
                                        </td>

                                        <td class="py-6 text-center">
                                            <button
                                                class="text-rose-500 hover:text-rose-700 remove-from-cart p-2 rounded-full hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors font-bold">
                                                ✕
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 border-t-2 border-gray-100 dark:border-gray-800 pt-6 flex flex-col items-end">
                        <div class="w-full sm:w-80 space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex justify-between pt-1 text-base font-black text-red-600 dark:text-red-400">
                                <span>Total</span>
                                <span>{{ number_format($subtotal) }} MMK</span>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <a href="{{ url('/') }}"
                                class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-gray-950 text-xs font-black rounded-xl transition-all text-center border-b-4 border-amber-500 shadow-sm active:translate-y-1 active:border-b-0">
                                Continue Shopping
                            </a>

                            <a href="{{ route('checkout.index') }}"
                                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black rounded-xl transition-all text-center border-b-4 border-emerald-800 shadow-sm active:translate-y-1 active:border-b-0 inline-flex items-center justify-center gap-1">
                                Continue to Payment ❯
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div
                    class="bg-white/95 dark:bg-gray-900/95 p-8 rounded-2xl border border-white/60 dark:border-gray-800 text-center py-16 shadow-lg">
                    <div
                        class="w-16 h-16 bg-amber-100 dark:bg-amber-950/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600 dark:text-amber-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-bold">Your shopping cart is empty.</p>
                    <a href="{{ url('/') }}"
                        class="mt-5 inline-block px-6 py-3 bg-amber-400 hover:bg-amber-300 text-gray-950 text-xs font-black rounded-xl shadow-md transition">
                        Shop Now
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
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

        document.querySelectorAll('.update-cart-btn').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr');
                const id = row.getAttribute('data-id');
                const input = row.querySelector('.quantity-input');
                let currentVal = parseInt(input.value);
                let maxVal = parseInt(input.getAttribute('max')) || 99; // 💡 Product ရဲ့ Max Stock အရေအတွက်ကို ရယူခြင်း

                if (this.classList.contains('plus-btn')) {
                    if (currentVal < maxVal) { // 💡 Stock မပြည့်သေးမှ တိုးမည်
                        currentVal += 1;
                    } else {
                        alert("Stock အရေအတွက် " + maxVal + " ခုထက် ပိုဝယ်၍မရပါ!");
                    }
                } else if (this.classList.contains('minus-btn') && currentVal > 1) {
                    currentVal -= 1;
                }

                input.value = currentVal;
                updateCart(id, currentVal);
            });
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function () {
                const id = this.closest('tr').getAttribute('data-id');
                let maxVal = parseInt(this.getAttribute('max')) || 99;

                if (parseInt(this.value) > maxVal) { // 💡 Stock ထက် ကျော်ရိုက်ပါက Max ထိပဲ ပြန်လျှော့မည်
                    this.value = maxVal;
                    alert("Hit " + maxVal + " maximum stock!");
                }
                if (parseInt(this.value) < 1 || !this.value) this.value = 1;

                updateCart(id, this.value);
            });
        });

        function updateCart(id, quantity) {
            axios.patch('{{ route('cart.update') }}', {
                id: id,
                quantity: quantity
            })
                .then(response => {
                    window.location.reload();
                });
        }

        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', function () {
                if (confirm("Are you sure you want to remove this item?")) {
                    const id = this.closest('tr').getAttribute('data-id');
                    axios.delete('{{ route('cart.remove') }}', {
                        data: { id: id }
                    })
                        .then(response => {
                            window.location.reload();
                        });
                }
            });
        });
    </script>
</x-app-layout>