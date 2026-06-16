<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Withdrawal Requests
            (ငွေထုတ်ရန်တောင်းဆိုမှုများ)</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl border font-bold text-sm">{{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border dark:border-gray-800 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-xs font-bold text-gray-400 uppercase">
                        <th class="p-4">Vendor Shop</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Payment Account</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                    @foreach($requests as $req)
                        <tr class="dark:text-gray-300">
                            <td class="p-4">
                                <div class="font-bold">{{ $req->user->shop_name }}</div>
                                <div class="text-xs text-gray-400">{{ $req->user->name }}</div>
                            </td>
                            <td class="p-4 font-black text-blue-600 dark:text-blue-400">{{ number_format($req->amount) }}
                                MMK</td>
                            <td class="p-4">
                                <span
                                    class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded text-xs font-bold">{{ $req->payment_method }}</span>
                                <div class="font-semibold mt-1">{{ $req->account_number }}</div>
                                <div class="text-xs text-gray-400">Name: {{ $req->account_name }}</div>
                            </td>
                            <td class="p-4">
                                @if($req->status === 'pending')
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-yellow-50 text-yellow-700">Pending</span>
                                @elseif($req->status === 'approved')
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-50 text-green-700">Approved</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-50 text-rose-700">Rejected</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                @if($req->status === 'pending')
                                    <form action="{{ route('admin.withdraw.approve', $req->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="bg-green-600 text-white px-3 py-1.5 rounded-xl text-xs font-bold">Approve
                                            (လွှဲပြီး)</button>
                                    </form>

                                    <button
                                        onclick="document.getElementById('reject-modal-{{$req->id}}').classList.remove('hidden')"
                                        class="bg-rose-600 text-white px-3 py-1.5 rounded-xl text-xs font-bold">Reject</button>

                                    <div id="reject-modal-{{$req->id}}"
                                        class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center text-left">
                                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl max-w-sm w-full m-4">
                                            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Reject Request</h3>
                                            <form action="{{ route('admin.withdraw.reject', $req->id) }}" method="POST">
                                                @csrf
                                                <textarea name="admin_note" placeholder="ငြင်းပယ်ရသည့် အကြောင်းပြချက်ရေးရန်..."
                                                    class="w-full border rounded-xl p-3 dark:bg-gray-700 dark:text-white mb-4"
                                                    required></textarea>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        onclick="document.getElementById('reject-modal-{{$req->id}}').classList.add('hidden')"
                                                        class="px-4 py-2 text-sm">Cancel</button>
                                                    <button
                                                        class="bg-rose-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Confirm
                                                        Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Processed</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>