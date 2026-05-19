<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-6 text-gray-800">ရရှိနိုင်သော ပစ္စည်းများ</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="border rounded-lg p-4 shadow-sm bg-gray-50 flex flex-col justify-between">
                            <div>
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-4">
                                @else
                                    <div class="w-full h-48 bg-gray-250 flex items-center justify-center rounded-md mb-4 text-gray-400">No Image</div>
                                @endif
                                
                                <h4 class="font-semibold text-lg text-gray-900">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-600 my-2">{{ $product->description }}</p>
                            </div>
                            
                            <div class="mt-4">
                                <span class="text-green-600 font-bold text-md">{{ number_format($product->price) }} MMK</span>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs text-gray-500">လက်ကျန်: {{ $product->stock }} ခု</span>
                                    <button class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">ဝယ်ယူရန်</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
