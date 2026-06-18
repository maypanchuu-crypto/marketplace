<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-4xl" x-data="{ 
            showModal: false, 
            otpSent: false,
            generatedOtp: '{{ $randomOtp }}', // Backend က ထုတ်ပေးလိုက်တဲ့ OTP
            showSms: false
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
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Shipping Details
                </h2>

                <form id="checkoutForm" action="{{ route('checkout.placeOrder') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">Customer
                            Name</label>
                        <input type="text" name="customer_name" value="{{ Auth::user()->name }}"
                            class="w-full px-4 py-2.5 border dark:border-gray-800 rounded-xl dark:bg-gray-800 dark:text-white text-sm font-semibold"
                            required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 tracking-wider">Payment
                            Method</label>
                        <div
                            class="p-3 rounded-xl font-black text-xs border-2 border-blue-600 bg-blue-50/50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 flex items-center gap-2 w-full">
                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                            MWallet (Digital Wallet)
                        </div>
                        <input type="hidden" name="payment_method" value="MWallet">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">MWallet Phone
                            Number</label>
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

                    <div x-show="otpSent" x-transition
                        class="p-4 bg-blue-50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900/50 rounded-xl mt-4">
                        <label
                            class="block text-xs font-black text-blue-900 dark:text-blue-300 uppercase mb-1.5 tracking-wider text-center">Enter
                            OTP Verification Code</label>
                        <input type="text" name="otp_code" maxlength="4"
                            class="w-full px-4 py-2.5 tracking-[0.5em] text-center text-base font-black border border-blue-300 dark:border-blue-800 rounded-xl dark:bg-gray-950 dark:text-white bg-white"
                            placeholder="••••" :required="otpSent">
                        <p class="text-[10px] text-blue-500 mt-1.5 font-semibold text-center">Please enter the simulated
                            SMS code to complete your transaction.</p>
                    </div>

                    <button type="button" @click="showModal = true" x-show="!otpSent"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold py-3.5 rounded-xl shadow-lg transition mt-2">
                        Continue to Payment (ငွေချေရန် ဆက်သွားမည်)
                    </button>

                    <button type="submit" x-show="otpSent" x-transition
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold py-3.5 rounded-xl shadow-lg transition mt-2">
                        Verify OTP & Confirm Order (ဝယ်ယူမှု အတည်ပြုမည်)
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
                                <div class="text-xs text-gray-400 font-medium mt-0.5">Qty: {{ $item['quantity'] }}</div>
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

        <div x-show="showModal"
            class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
            x-cloak>
            <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-sm w-full p-6 shadow-2xl relative border dark:border-gray-800 text-center"
                @click.away="if(!otpSent) showModal = false">

                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></div>
                    <h3 class="font-black text-gray-900 dark:text-white text-lg tracking-tight">MWallet Gateway</h3>
                </div>

                <p class="text-xs text-gray-400 mb-6">Secure transactions encrypted via mobile telecommunication
                    network.</p>

                <div class="bg-gray-50 dark:bg-gray-950 p-4 rounded-2xl mb-6 border dark:border-gray-800">
                    <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Total Payable
                        Amount</span>
                    <input type="text" value="{{ number_format($total) }} MMK" readonly
                        class="w-full text-center font-black text-xl text-blue-600 dark:text-blue-400 bg-transparent border-0 focus:ring-0 p-0 select-none">
                </div>

                <div class="space-y-2">
                    <button type="button"
                        @click="showModal = false; otpSent = true; setTimeout(() => { showSms = true }, 1500)"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3 rounded-xl text-xs shadow-md transition">
                        Request OTP to Confirm order
                    </button>

                    <button type="button" @click="showModal = false" x-show="!otpSent"
                        class="w-full text-gray-400 hover:text-gray-600 text-xs font-bold py-2 transition">
                        Cancel Payment
                    </button>
                </div>
            </div>
        </div>

        <div class="fixed top-5 right-5 z-50 max-w-sm w-full" x-show="showSms"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
            x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak>

            <div
                class="bg-gray-900/95 backdrop-blur-md border border-gray-800 text-white p-4 rounded-2xl shadow-2xl flex items-start gap-3">
                <div class="p-2 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-xl text-white shrink-0 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-black tracking-wider uppercase text-blue-400">MWallet Secure
                            SMS</span>
                        <span class="text-[10px] font-bold text-gray-500">Just Now</span>
                    </div>
                    <p class="text-xs text-gray-300 mt-2 font-semibold">
                        Your verification security code is <span
                            class="text-yellow-400 font-black text-sm px-1.5 py-0.5 bg-gray-800 rounded border border-gray-700"
                            x-text="generatedOtp"></span>. Valid for 5 minutes.
                    </p>
                </div>
                <button @click="showSms = false" class="text-gray-500 hover:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</x-app-layout>