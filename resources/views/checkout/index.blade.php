<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-4xl" x-data="{ 
            paymentMethod: 'KBZPay', 
            showSmsModal: false,
            init() {
                // စာမျက်နှာ စတင်ပွင့်လာပြီး ၁ စက္ကန့်အကြာတွင် ဖုန်းထဲသို့ SMS ဝင်လာသည့် ပုံစံမျိုး Pop-up ပြသခြင်း
                setTimeout(() => { this.showSmsModal = true }, 1000);
            }
         }">

        <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">Checkout (ငွေချေစနစ်)</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-2xl">
                <ul class="list-disc list-inside text-xs font-bold text-red-600 dark:text-red-400 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-md border dark:border-gray-800">
                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    Mobile Wallet Payment
                </h2>

                <form action="{{ route('checkout.placeOrder') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">Customer
                            Name</label>
                        <input type="text" name="customer_name" value="{{ Auth::user()->name }}"
                            class="w-full px-4 py-2.5 border dark:border-gray-800 rounded-xl dark:bg-gray-800 dark:text-white text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Select
                            Payment Method</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" @click="paymentMethod = 'KBZPay'"
                                :class="paymentMethod === 'KBZPay' ? 'border-2 border-blue-600 bg-blue-50/50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400' : 'border border-gray-200 dark:border-gray-800 bg-transparent text-gray-500 dark:text-gray-400'"
                                class="p-3 rounded-xl font-black text-xs transition flex items-center justify-center gap-2">
                                <span class="w-2 h-2 rounded-full"
                                    :class="paymentMethod === 'KBZPay' ? 'bg-blue-600' : 'bg-gray-300'"></span>
                                KBZPay (Digital Wallet)
                            </button>
                            <button type="button" @click="paymentMethod = 'WavePay'"
                                :class="paymentMethod === 'WavePay' ? 'border-2 border-yellow-500 bg-yellow-50/30 dark:bg-yellow-950/10 text-yellow-600 dark:text-yellow-400' : 'border border-gray-200 dark:border-gray-800 bg-transparent text-gray-500 dark:text-gray-400'"
                                class="p-3 rounded-xl font-black text-xs transition flex items-center justify-center gap-2">
                                <span class="w-2 h-2 rounded-full"
                                    :class="paymentMethod === 'WavePay' ? 'bg-yellow-500' : 'bg-gray-300'"></span>
                                WavePay (Digital Wallet)
                            </button>
                        </div>
                        <input type="hidden" name="payment_method" :value="paymentMethod">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">
                            Wallet Phone Number <span class="text-[10px] text-gray-400 font-normal lowercase">(between 8
                                to 11 digits)</span>
                        </label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                            class="w-full px-4 py-2.5 border dark:border-gray-800 rounded-xl dark:bg-gray-800 dark:text-white text-sm font-semibold placeholder-gray-400"
                            placeholder="e.g. 0995123456" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">Shipping
                            Address</label>
                        <textarea name="shipping_address" rows="2"
                            class="w-full px-4 py-2.5 border dark:border-gray-800 rounded-xl dark:bg-gray-800 dark:text-white text-sm font-medium"
                            placeholder="မြို့နယ်၊ တိုက်အမှတ်၊ လမ်းနာမည်..."
                            required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 border dark:border-gray-800 rounded-xl">
                        <label
                            class="block text-xs font-black text-gray-700 dark:text-gray-300 uppercase mb-1.5 tracking-wider">Enter
                            OTP Verification Code</label>
                        <input type="text" name="otp_code" maxlength="4"
                            class="w-full px-4 py-2.5 tracking-[0.5em] text-center text-base font-black border dark:border-gray-700 rounded-xl dark:bg-gray-950 dark:text-white bg-white"
                            placeholder="••••" required>
                        <p class="text-[10px] text-gray-400 mt-1.5 font-medium">Please enter the 4-digit code generated
                            by the simulator window.</p>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold py-3.5 rounded-xl shadow-lg shadow-blue-500/10 transition mt-2">
                        Verify OTP & Pay Now (ငွေချေမှုကို အတည်ပြုမည်)
                    </button>
                </form>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800/40 p-6 rounded-2xl border dark:border-gray-800 h-fit">
                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Order Summary</h2>
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($cart as $item)
                        <div class="py-3 flex justify-between items-center">
                            <div>
                                <div class="font-bold text-sm text-gray-900 dark:text-white tracking-tight">
                                    {{ $item['name'] }}</div>
                                <div class="text-xs text-gray-400 font-medium mt-0.5">
                                    Qty: <span
                                        class="font-bold text-gray-600 dark:text-gray-400">{{ $item['quantity'] }}</span>
                                    @if(isset($item['color'])) • Color: {{ $item['color'] }} @endif
                                    @if(isset($item['size'])) • Size: {{ $item['size'] }} @endif
                                </div>
                            </div>
                            <div class="text-sm font-black text-gray-900 dark:text-white">
                                {{ number_format($item['price'] * $item['quantity']) }} MMK
                            </div>
                        </div>
                    @endforeach
                </div>

                <div
                    class="border-t dark:border-gray-800 mt-4 pt-4 flex justify-between items-center font-black text-lg">
                    <span class="text-gray-900 dark:text-white text-base">Total Amount:</span>
                    <span class="text-blue-600 dark:text-blue-400 text-xl">{{ number_format($total) }} MMK</span>
                </div>
            </div>
        </div>

        <div class="fixed top-5 right-5 z-50 max-w-sm w-full pointer-events-auto" x-show="showSmsModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-[-20px] scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" x-cloak>

            <div
                class="bg-gray-900/95 backdrop-blur border border-gray-800 text-white p-4 rounded-2xl shadow-2xl flex items-start gap-3">
                <div class="p-2 bg-gradient-to-tr from-blue-500 to-indigo-600 text-white rounded-xl shrink-0 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black tracking-wider uppercase text-blue-400"
                            x-text="paymentMethod + ' SMS Network'"></span>
                        <span class="text-[10px] font-bold text-gray-500">Just Now</span>
                    </div>
                    <h4 class="text-xs font-bold text-gray-200 mt-1">Verification Code Received!</h4>
                    <p class="text-xs text-gray-400 mt-1 leading-normal font-semibold">
                        Use <span
                            class="text-yellow-400 font-black text-sm px-1.5 py-0.5 bg-gray-800 rounded border border-gray-700 tracking-wider">{{ $randomOtp }}</span>
                        to authorize your transaction payment of <span
                            class="font-bold text-white">{{ number_format($total) }} MMK</span>.
                    </p>
                </div>

                <button @click="showSmsModal = false"
                    class="p-1 hover:bg-gray-800 rounded-lg text-gray-500 hover:text-gray-300 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</x-app-layout>