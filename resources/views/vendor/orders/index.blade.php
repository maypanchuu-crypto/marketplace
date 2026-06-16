<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-5xl">

        <div class="mb-8">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Shop Sales & Items</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Track and manage individual product sales and automated
                net earnings after commission.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div
                class="bg-white dark:bg-gray-900 p-5 rounded-2xl border dark:border-gray-800 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Items Sold</span>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mt-0.5">{{ $myOrders->count() }} Items
                    </h3>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-900 p-5 rounded-2xl border dark:border-gray-800 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V5">
                        </path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Estimated Profit</span>
                    <h3 class="text-xl font-black text-emerald-600 mt-0.5">
                        @php
                            $totalProfit = $myOrders->sum(function ($item) {
                                return ($item->price * $item->quantity) * 0.95;
                            });
                        @endphp
                        {{ number_format($totalProfit) }} MMK
                    </h3>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($myOrders as $item)
                <div
                    class="bg-white dark:bg-gray-900 p-6 rounded-2xl border dark:border-gray-800 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 transition hover:shadow-md">

                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <span
                                class="text-[10px] font-black bg-gray-100 dark:bg-gray-800 text-gray-500 px-2 py-1 rounded-md">
                                INVOICE #{{ $item->order->id }}
                            </span>
                            <span
                                class="text-[10px] font-bold text-gray-400">{{ $item->created_at->format('d M Y') }}</span>
                        </div>

                        <div>
                            <h3 class="text-sm font-black text-gray-900 dark:text-white tracking-tight">
                                {{ $item->product->name ?? 'Product Deleted' }}
                            </h3>
                            <p class="text-xs text-gray-400 font-medium mt-0.5">
                                Qty: <span class="text-gray-700 dark:text-gray-300 font-bold">{{ $item->quantity }}</span>
                                | Original Price: {{ number_format($item->price) }} MMK
                                @if($item->color || $item->size)
                                    <span class="text-indigo-500 dark:text-indigo-400 font-bold ml-1">
                                        ({{ $item->color ?? '' }} {{ $item->size ? '[' . $item->size . ']' : '' }})
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div
                            class="pt-2 border-t dark:border-gray-800/60 flex items-start gap-1.5 text-gray-500 dark:text-gray-400 text-xs">
                            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <span
                                    class="font-bold text-gray-700 dark:text-gray-300">{{ $item->order->customer_name }}</span>
                                <span class="text-gray-400">({{ $item->order->customer_phone }})</span>
                                <div class="text-[11px] text-gray-400 font-normal mt-0.5">
                                    {{ $item->order->shipping_address }}</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-full sm:w-auto flex sm:flex-col justify-between sm:justify-center items-center sm:items-end border-t sm:border-t-0 pt-4 sm:pt-0 dark:border-gray-800 gap-2">
                        <div>
                            @if($item->order->status === 'completed')
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-black rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">
                                    Approved
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-black rounded-full bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400">
                                    Processing
                                </span>
                            @endif
                        </div>

                        <div class="text-right sm:mt-2">
                            <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Your Net
                                Earning:</span>
                            <span class="text-base font-black text-indigo-600 dark:text-indigo-400">
                                {{ number_format(($item->price * $item->quantity) * 0.95) }} MMK
                            </span>
                            <span class="block text-[9px] font-semibold text-gray-400 mt-0.5">(5% Commission
                                Deducted)</span>
                        </div>
                    </div>

                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-900 p-12 text-center rounded-2xl border dark:border-gray-800 text-gray-400 font-medium">
                    No product sales records yet.
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>