<x-app-layout>
<div class="container mx-auto px-4 py-8 max-w-4xl"
    x-data="{
        showModal: false,
        qrCode: null,
        txId: null,
        polling: null,

        generateQR() {
            fetch('/checkout/qr-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: {{ $total }},
                    vendor_id: 1
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log('QR RESPONSE:', data);

                this.qrCode = data.qr;   // plain JSON string
                this.txId = data.tx_id;
                this.showModal = true;

                this.startPolling(this.txId);
            });
        },

        startPolling(txId) {
            this.polling = setInterval(() => {
                fetch('/qr/status/' + txId)
                    .then(res => res.json())
                    .then(data => {

                        if (data.status === 'completed') {
                            clearInterval(this.polling);
                            alert('Payment Successful!');
                            window.location.href = '/dashboard';
                        }

                        if (data.status === 'expired') {
                            clearInterval(this.polling);
                            alert('QR expired');
                        }

                    });
            }, 2000);
        }
    }">

    <h1 class="text-2xl font-black mb-6">
        Checkout (MMQR Payment Demo)
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- LEFT -->
        <div class="bg-white p-6 rounded-xl border">

            <h2 class="font-bold mb-4">Shipping</h2>

            <form class="space-y-4">
                @csrf

                <input class="w-full border p-2 rounded"
                    value="{{ Auth::user()->name }}">

                <input class="w-full border p-2 rounded"
                    placeholder="Phone">

                <textarea class="w-full border p-2 rounded"
                    placeholder="Address"></textarea>

                <button type="button"
                    @click="generateQR()"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl">
                    Continue to Payment
                </button>

            </form>
        </div>

        <!-- RIGHT -->
        <div class="bg-gray-50 p-6 rounded-xl border">

            <h2 class="font-bold mb-4">Summary</h2>

            <div class="text-xl font-bold text-blue-600">
                {{ number_format($total) }} MMK
            </div>

        </div>
    </div>

    <!-- QR MODAL -->
    <div x-show="showModal"
        class="fixed inset-0 bg-black/60 flex items-center justify-center p-4"
        x-cloak>

        <div class="bg-white p-6 rounded-xl w-96 text-center">

            <h2 class="font-bold mb-3">MMQR Payload</h2>

            <!-- FIXED DISPLAY -->
            <div class="p-4 bg-gray-100 rounded-xl text-xs break-all">
                <span x-text="qrCode"></span>
            </div>

            <p class="text-xs text-gray-500 mt-3">
                Scan this payload (demo mode)
            </p>

            <button @click="showModal = false"
                class="mt-4 text-gray-500">
                Close
            </button>

        </div>
    </div>

</div>
</x-app-layout>