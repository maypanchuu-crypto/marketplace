<x-app-layout :hideNav="true">
    <div class="max-w-5xl mx-auto px-4 py-8 bg-white dark:bg-gray-900 rounded-2xl shadow-sm mt-6">
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-8">Shopping Cart</h1>

        @if(session('cart'))
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="pb-4">Product</th>
                            <th class="pb-4 text-center">Quantity</th>
                            <th class="pb-4 text-right">Total</th>
                            <th class="pb-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($cart as $id => $details)
                            <tr data-id="{{ $id }}" class="text-sm text-gray-700 dark:text-gray-300">
                                <td class="py-6 flex items-center gap-4">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 border flex-shrink-0">
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
                                                        class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-[11px] font-medium text-gray-600 dark:text-gray-400 rounded-md">
                                                        Size: {{ strtoupper($details['size']) }}
                                                    </span>
                                                @endif
                                                @if($details['color'])
                                                    <span
                                                        class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-[11px] font-medium text-gray-600 dark:text-gray-400 rounded-md flex items-center gap-1">
                                                        Color: {{ ucfirst($details['color']) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-6 text-center">
                                    <div class="inline-flex items-center border border-gray-200 rounded-lg bg-gray-50 p-1">
                                        <button
                                            class="px-2 py-1 text-gray-500 hover:text-black font-bold update-cart-btn minus-btn">-</button>
                                        <input type="number" value="{{ $details['quantity'] }}" min="1"
                                            class="w-12 text-center bg-transparent border-none text-xs font-semibold focus:outline-none quantity-input">
                                        <button
                                            class="px-2 py-1 text-gray-500 hover:text-black font-bold update-cart-btn plus-btn">+</button>
                                    </div>
                                </td>

                                <td class="py-6 text-right font-semibold text-blue-600">
                                    {{ number_format($details['price'] * $details['quantity']) }} MMK
                                </td>

                                <td class="py-6 text-center">
                                    <button class="text-rose-500 hover:text-rose-700 remove-from-cart">
                                        ✕
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 border-t border-gray-100 pt-6 flex flex-col items-end">
                <div class="w-full sm:w-80 space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold text-gray-800 dark:text-white">{{ number_format($subtotal) }} MMK</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-3 text-base font-bold text-blue-600">
                        <span>Total</span>
                        <span>{{ number_format($subtotal) }} MMK</span>
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ url('/') }}"
                        class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition">Continue
                        Shopping</a>
                    <button
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md transition">Continue
                        to Payment ❯</button>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-400 text-sm">Your shopping cart is empty.</p>
                <a href="{{ url('/') }}"
                    class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white text-xs font-semibold rounded-xl">Shop Now</a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // + သို့မဟုတ် - ခလုတ်နှိပ်သည့်အခါ အရေအတွက်ပြောင်းလဲခြင်း
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

        // Input အကွက်ထဲ တိုက်ရိုက် ဂဏန်းပြောင်းလဲသည့်အခါ
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
                    window.location.reload(); // စာမျက်နှာကို Refresh လုပ်ပြီး ဈေးနှုန်းများ ပြန်တွက်မည်
                });
        }

        // Cart ထဲမှ ပစ္စည်းဖျက်ခြင်း
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