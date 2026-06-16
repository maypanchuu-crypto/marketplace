<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-6xl" x-data="{ openSlipModal: null }">

        <div class="mb-8">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Order & Finance Overview</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Review incoming customer payments, approve orders, and
                distribute automated commissions.</p>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show"
                class="mb-6 flex items-center justify-between p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/50 rounded-2xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="p-1.5 bg-emerald-500 rounded-lg text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div
                class="bg-white dark:bg-gray-900 p-5 rounded-2xl border dark:border-gray-800 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Orders</span>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mt-0.5">{{ $orders->count() }}</h3>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-900 p-5 rounded-2xl border dark:border-gray-800 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Pending Actions</span>
                    <h3 class="text-xl font-black text-amber-600 mt-0.5">
                        {{ $orders->where('status', 'pending')->count() }}
                    </h3>
                </div>
            </div>
            <div
                class="bg-white dark:bg-gray-900 p-5 rounded-2xl border dark:border-gray-800 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 8h6m-5 4h3m-7 8h10a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Completed Sales</span>
                    <h3 class="text-xl font-black text-emerald-600 mt-0.5">
                        {{ $orders->where('status', 'completed')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @forelse($orders as $order)
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl border dark:border-gray-800 shadow-sm overflow-hidden transition hover:shadow-md">

                    <div
                        class="p-5 bg-gray-50/70 dark:bg-gray-800/40 border-b dark:border-gray-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center space-x-3">
                            <div
                                class="px-3 py-1.5 bg-gray-200 dark:bg-gray-800 rounded-xl text-xs font-bold text-gray-700 dark:text-gray-300">
                                ORDER #{{ $order->id }}
                            </div>
                            <span
                                class="text-xs text-gray-400 font-medium">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div>
                            @if($order->status === 'pending')
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Approval
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div class="space-y-3">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Customer Details</h4>
                            <div class="space-y-1.5">
                                <div class="text-sm font-black text-gray-800 dark:text-white">{{ $order->customer_name }}
                                </div>
                                <div
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.72.5l.54 1.84a1 1 0 01-.27.9l-1.2 1.2a13.04 13.04 0 005.62 5.62l1.2-1.2a1 1 0 01.9-.27l1.84.54a1 1 0 01.72.94V19a2 2 0 01-2 2h-1C7.82 21 3 16.18 3 10V5z">
                                        </path>
                                    </svg>
                                    {{ $order->customer_phone }}
                                </div>
                                <div class="text-xs text-gray-400 leading-relaxed">{{ $order->shipping_address }}</div>
                            </div>

                            @if($order->payment_slip)
                                <button @click="openSlipModal = '{{ asset('storage/' . $order->payment_slip) }}'"
                                    class="mt-2 inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/40 hover:bg-blue-100 px-3 py-2 rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    View Payment Slip
                                </button>
                            @endif
                        </div>

                        <div class="md:col-span-2 space-y-3">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ordered Products</h4>
                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                    <div
                                        class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800/40 border dark:border-gray-800 rounded-xl text-xs">
                                        <div>
                                            <span
                                                class="font-black text-gray-900 dark:text-white">{{ $item->product->name ?? 'Product Deleted' }}
                                            </span>
                                            <span class="text-gray-400 ml-1 font-medium">
                                                (x{{ $item->quantity }})
                                            </span>
                                            @if($item->color || $item->size)
                                                <div class="text-[10px] text-gray-400 font-medium mt-0.5">
                                                    @if($item->color) Option: {{ $item->color }} @endif
                                                    @if($item->size) [{{ $item->size }}] @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <span
                                                class="font-black text-gray-900 dark:text-white">{{ number_format($item->price * $item->quantity) }}
                                                MMK</span>
                                            @if($order->status === 'completed')
                                                <div class="text-[10px] font-bold mt-0.5 text-emerald-600 dark:text-emerald-400">
                                                    Shop: +{{ number_format($item->vendor_amount) }} | Comm:
                                                    {{ number_format($item->admin_commission) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="border-t dark:border-gray-800 pt-4 mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <span class="text-xs font-bold text-gray-400 block">Grand Total:</span>
                                    <span
                                        class="text-lg font-black text-blue-600 dark:text-blue-400">{{ number_format($order->total_amount) }}
                                        MMK</span>
                                </div>

                                @if($order->status === 'pending')
                                    <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST"
                                        class="w-full sm:w-auto">
                                        @csrf
                                        <button type="submit"
                                            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-3 rounded-xl shadow-md shadow-blue-500/10 transition">
                                            Approve Order & Distribute Income
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-900 p-12 text-center rounded-2xl border dark:border-gray-800 text-gray-400 font-medium">
                    No order records found in system.
                </div>
            @endforelse
        </div>

        <div x-show="openSlipModal"
            class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
            x-cloak>
            <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-lg w-full p-6 shadow-2xl relative border dark:border-gray-800"
                @click.away="openSlipModal = null">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-black text-gray-900 dark:text-white text-base">Payment Verification Slip</h3>
                    <button @click="openSlipModal = null"
                        class="p-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div
                    class="bg-gray-50 dark:bg-gray-950 rounded-xl p-2 flex justify-center overflow-hidden max-h-[70vh]">
                    <img :src="openSlipModal" class="object-contain w-full h-auto rounded-lg"
                        alt="KPay Transaction Record">
                </div>
            </div>
        </div>

    </div>
</x-app-layout>