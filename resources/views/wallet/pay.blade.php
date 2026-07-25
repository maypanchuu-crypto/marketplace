<x-app-layout>
    <div class="max-w-md mx-auto my-8 p-6 bg-white rounded-2xl shadow-lg text-center">

        <h2 class="text-xl font-black mb-2 text-gray-800">Scan QR Code to Pay</h2>
        <p class="text-xs text-gray-500 mb-6">Camera အား ဖွင့်၍ Order QR ကို ဖတ်ပေးပါ</p>

        <!-- Camera Video ရိုက်မည့် Box -->
        <div id="reader"
            class="w-full bg-black rounded-xl overflow-hidden border-2 border-emerald-500 shadow-inner mb-4"></div>

        <div id="status-text" class="text-sm font-bold text-emerald-600 hidden">
            Scanning Successful! Processing Payment...
        </div>

    </div>

    <!-- HTML5 QR Scanner JS Library -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Scanned Result: ${decodedText}`);

            // Scan အောင်မြင်သွားလျှင် Camera ခဏပိတ်မည်
            html5QrcodeScanner.clear();

            document.getElementById('status-text').classList.remove('hidden');

            // Scanned URL ဆီသို့ တိုက်ရိုက် လမ်းကြောင်းပြောင်းမည်
            window.location.href = decodedText;
        }

        // Scanner စတင်ဖွင့်လှစ်ခြင်း
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            {
                fps: 10,
                qrbox: { width: 220, height: 220 }
            },
        /* verbose= */ false
        );

        html5QrcodeScanner.render(onScanSuccess);
    </script>
</x-app-layout>