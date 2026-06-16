<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-1 space-y-6">
                <div class="bg-blue-600 text-white p-6 rounded-2xl shadow-xl">
                    <h3 class="text-sm font-bold opacity-80 uppercase">My Wallet Balance</h3>
                    <div class="text-3xl font-black mt-2">{{ number_format($vendor->balance) }} MMK</div>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-md border dark:border-gray-800">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Request Money (ငွေထုတ်ရန် လျှောက်ထားရန်)
                    </h3>
                    <form action="{{ route('withdraw.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Amount
                                (ထုတ်မည့်ပမာဏ)</label>
                            <input type="number" name="amount" min="1000" max="{{ $vendor->balance }}"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Payment Method</label>
                            <select name="payment_method"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white">
                                <option value="KPay">KBZPay</option>
                                <option value="WaveMoney">Wave Money</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Account Number</label>
                            <input type="text" name="account_number"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white"
                                placeholder="09xxxxxxxxx" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Account Name</label>
                            <input type="text" name="account_name"
                                class="w-full px-3 py-2 border rounded-xl dark:bg-gray-800 dark:text-white" required>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-xl shadow-md">Submit
                            Request</button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-md border dark:border-gray-800 h-full">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Withdrawal History</h3>
                    <div class="space-y-3 overflow-y-auto max-h-[500px]">
                        @forelse($history as $item)
                            <div
                                class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border dark:border-gray-800">
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ number_format($item->amount) }}
                                        MMK</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $item->payment_method }} •
                                        {{ $item->created_at->format('d M Y h:i A') }}</div>
                                    @if($item->admin_note)
                                        <div class="text-xs text-rose-500 mt-1 font-medium">Reason: {{ $item->admin_note }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    @if($item->status === 'pending')
                                        <span
                                            class="text-xs font-bold px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    @elseif($item->status === 'approved')
                                        <span
                                            class="text-xs font-bold px-2.5 py-1 bg-green-100 text-green-800 rounded-full">Success</span>
                                    @else
                                        <span
                                            class="text-xs font-bold px-2.5 py-1 bg-rose-100 text-rose-800 rounded-full">Rejected</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400">ငွေထုတ်ယူမှု မှတ်တမ်းမရှိသေးပါ။</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>