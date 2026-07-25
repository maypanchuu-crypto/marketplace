<x-app-layout>
    <!-- 💡 CSS x-cloak Fix -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="container mx-auto px-4 py-8 max-w-4xl" x-data="checkoutForm()">

        <h1 class="text-2xl font-black mb-6">Checkout Shipping Details</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- LEFT: SHIPPING FORM -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="font-bold mb-4 text-lg">Shipping Information</h2>

                <!-- Validation Warning Message -->
                <template x-if="errorMessage">
                    <div class="p-3 mb-4 bg-red-100 border border-red-400 text-red-700 text-xs font-bold rounded-lg"
                        x-text="errorMessage"></div>
                </template>

                <form @submit.prevent="submitOrder()" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Customer Name *</label>
                        <input type="text"
                            class="w-full border border-gray-300 p-2.5 rounded-lg text-sm focus:outline-none focus:border-emerald-500 font-semibold"
                            x-model="customer_name" placeholder="Enter recipient name...">
                    </div>

                    <!-- 💡 PHONE INPUT BOX -->
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Phone Number *</label>
                        <div class="relative flex items-center">
                            <!-- 09 အသေပြသပေးထားမည့် Prefix -->
                            <span class="absolute left-3 text-sm font-bold text-gray-600 select-none">09</span>

                            <input type="text" maxlength="9"
                                class="w-full border border-gray-300 p-2.5 pl-9 rounded-lg text-sm font-semibold focus:outline-none focus:border-emerald-500"
                                x-model="phoneSuffix" @input="filterPhoneInput($event)" placeholder="xxxxxxxxx">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Delivery Address *</label>
                        <textarea
                            class="w-full border border-gray-300 p-2.5 rounded-lg text-sm focus:outline-none focus:border-emerald-500"
                            x-model="address" rows="3" placeholder="Enter full address..."></textarea>
                    </div>

                    <button type="submit" @if($total <= 0) disabled @endif
                        class="w-full bg-emerald-600 hover:bg-emerald-500 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-3 rounded-xl transition shadow-md">
                        Order Now
                    </button>
                </form>
            </div>

            <!-- RIGHT: SUMMARY -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm h-fit">
                <h2 class="font-bold mb-4 text-lg">Order Summary</h2>
                <div class="flex justify-between items-center border-t pt-4">
                    <span class="font-semibold text-gray-600">Total Amount:</span>
                    <span class="text-2xl font-black text-emerald-600">
                        {{ number_format($total) }} MMK
                    </span>
                </div>
            </div>
        </div>

        <!-- 💡 QR CODE MODAL -->
        <div x-cloak x-show="showModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white p-6 rounded-2xl w-96 text-center shadow-2xl flex flex-col items-center">
                <h2 class="font-extrabold text-lg mb-1">Scan QR Code to Pay</h2>
                <p class="text-xs text-gray-500 mb-4">Please scan with your mobile app</p>

                <!-- QR Image Wrapper -->
                <div
                    class="p-3 bg-white border-2 border-dashed border-gray-300 rounded-2xl mb-3 shadow-inner min-h-[220px] flex items-center justify-center">
                    <template x-if="qrCode">
                        <img :src="qrCode" alt="Payment QR Code" class="w-56 h-56 mx-auto rounded-lg">
                    </template>
                </div>

                <!-- <p class="text-[11px] text-emerald-600 font-bold animate-pulse mt-1">
                    ငွေချေမှုကို စောင့်ဆိုင်းနေပါသည်...
                </p> -->
                <p class="text-[11px] text-emerald-600 font-bold animate-pulse mt-1">
                    waiting for payment confirmation...
                </p>

                <button @click="closeModal()" class="mt-4 text-xs text-gray-400 hover:text-gray-600 underline">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- 💡 Alpine.js Logic -->
    <script>
        function checkoutForm() {
            return {
                showModal: false,
                qrCode: null,
                txId: null,
                customer_name: '{{ Auth::user()->name }}',
                phoneSuffix: '', // 09 နောက်က ရိုက်ထည့်မည့် ဂဏန်းများ
                address: '',
                errorMessage: '',
                pollInterval: null,

                // 💡 ဂဏန်းမဟုတ်တာ ရိုက်ရင် အလိုအလျောက် ဖျက်ပေးမည့် Filter
                filterPhoneInput(e) {
                    this.phoneSuffix = e.target.value.replace(/[^0-9]/g, '');
                },

                submitOrder() {
                    const fullPhone = '09' + this.phoneSuffix;

                    // ၁။ Validation စစ်ဆေးခြင်း
                    if (!this.customer_name.trim()) {
                        this.errorMessage = 'ကျေးဇူးပြု၍ နာမည် ဖြည့်ပေးပါ!';
                        return;
                    }

                    // ဖုန်းနံပါတ် စုစုပေါင်း ၈ လုံးမှ ၁၁ လုံးအတွင်း စစ်ခြင်း
                    if (fullPhone.length < 8 || fullPhone.length > 11) {
                        this.errorMessage = 'ဖုန်းနံပါတ်သည် (09) အပါအဝင် စုစုပေါင်း ၈ လုံးမှ ၁၁ လုံးအထိ ဖြစ်ရပါမည်!';
                        return;
                    }

                    if (!this.address.trim()) {
                        this.errorMessage = 'ကျေးဇူးပြု၍ လိပ်စာ အပြည့်အစုံ ဖြည့်ပေးပါ!';
                        return;
                    }

                    this.errorMessage = '';

                    // ၂။ Order Place Request
                    fetch('{{ route('checkout.placeOrder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            customer_name: this.customer_name,
                            phone: fullPhone, // 💡 "09xxxxxxxxx" အပြည့်အစုံ ပို့ပေးမည်
                            address: this.address
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                this.qrCode = data.qr_code;
                                this.txId = data.order_id;
                                this.showModal = true;

                                this.checkPaymentStatus();
                            } else {
                                alert('Order တင်၍ မအောင်မြင်ပါ!');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Server Error ဖြစ်သွားပါသည်။');
                        });
                },

                checkPaymentStatus() {
                    this.pollInterval = setInterval(() => {
                        if (!this.txId || !this.showModal) return;

                        fetch('/api/check-order-status/' + this.txId)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'paid') {
                                    clearInterval(this.pollInterval);
                                    alert('ငွေပေးချေမှု အောင်မြင်ပါသည်။');
                                    window.location.href = '/';
                                }
                            })
                            .catch(err => console.error(err));
                    }, 2000);
                },

                closeModal() {
                    this.showModal = false;
                    if (this.pollInterval) {
                        clearInterval(this.pollInterval);
                    }
                }
            }
        }
    </script>
</x-app-layout>