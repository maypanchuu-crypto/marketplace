<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-gray-50 dark:bg-gray-950 flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">

        <div
            class="max-w-5xl w-full bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-6 sm:p-8">

            <h1 class="text-2xl sm:text-3xl font-black text-center text-gray-900 dark:text-white mb-8 tracking-tight">
                Shopping Cart
            </h1>

            @if(session('cart') && count(session('cart')) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-gray-100 dark:border-gray-800 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                                <th class="pb-4">Product</th>
                                <th class="pb-4 text-center">Quantity</th>
                                <th class="pb-4 text-right">Total</th>
                                <th class="pb-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800/50">
                            @foreach($cart as $id => $details)
                                <tr data-id="{{ $id }}" class="text-sm text-gray-700 dark:text-gray-300">
                                    <td class="py-6 flex items-center gap-4">
                                        <div
                                            class="w-20 h-20 rounded-xl overflow-hidden bg-gray-50 border dark:border-gray-700 flex-shrink-0 shadow-sm">
                                            <img src="{{ asset('storage/' . $details['image']) }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 dark:text-white">{{ $details['name'] }}</h4>
                                            <p class="text-xs text-gray-400 mt-1">{{ number_format($details['price']) }} MMK</p>

                                            @if($details['size'] || $details['color'])
                                                <div class="flex gap-2 mt-2">
                                                    @if($details['size'])
                                                        <span
                                                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-[11px] font-medium text-gray-600 dark:text-gray-400 rounded-md border dark:border-gray-700">
                                                            Size: {{ strtoupper($details['size']) }}
                                                        </span>
                                                    @endif
                                                    @if($details['color'])
                                                        <span
                                                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-[11px] font-medium text-gray-600 dark:text-gray-400 rounded-md border dark:border-gray-700 flex items-center gap-1">
                                                            Color: {{ ucfirst($details['color']) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="py-6 text-center">
                                        <div
                                            class="inline-flex items-center border dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 p-1 shadow-inner">
                                            <button
                                                class="px-2.5 py-1 text-gray-500 hover:text-black dark:hover:text-white font-bold update-cart-btn minus-btn transition-colors">-</button>
                                            <input type="number" value="{{ $details['quantity'] }}" min="1"
                                                class="w-12 text-center bg-transparent border-none text-xs font-bold focus:outline-none quantity-input dark:text-white">
                                            <button
                                                class="px-2.5 py-1 text-gray-500 hover:text-black dark:hover:text-white font-bold update-cart-btn plus-btn transition-colors">+</button>
                                        </div>
                                    </td>

                                    <td class="py-6 text-right font-bold text-blue-600 dark:text-blue-400">
                                        {{ number_format($details['price'] * $details['quantity']) }} MMK
                                    </td>

                                    <td class="py-6 text-center">
                                        <button
                                            class="text-rose-500 hover:text-rose-700 remove-from-cart p-2 rounded-full hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                                            ✕
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 border-t border-gray-100 dark:border-gray-800 pt-6 flex flex-col items-end">
                    <div class="w-full sm:w-80 space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <!-- <div class="flex justify-between">
                                        <span>Subtotal</span>
                                        <span class="font-semibold text-gray-800 dark:text-white">{{ number_format($subtotal) }}
                                            MMK</span>
                                    </div> -->
                        <div class="flex justify-between  pt-3 text-base font-bold text-blue-600 dark:text-blue-400">
                            <span>Total</span>
                            <span>{{ number_format($subtotal) }} MMK</span>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ url('/') }}"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-xl transition text-center">
                            Continue Shopping
                        </a>
                        <a href="{{ route('checkout.index') }}"
                            class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold inline-flex items-center">
                            <button
                                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md hover:shadow-lg transition text-center">
                                Continue to Payment ❯
                            </button>
                        </a>
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div
                        class="w-16 h-16 bg-gray-50 dark:bg-gray-850 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Your shopping cart is empty.</p>
                    <a href="{{ url('/') }}"
                        class="mt-5 inline-block px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md transition">
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

                if (this.classList.contains('plus-btn')) {
                    currentVal += 1;
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
                if (this.value < 1) this.value = 1;
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