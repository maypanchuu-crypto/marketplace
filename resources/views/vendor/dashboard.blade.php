<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-700">Manage Your Products</h3>
                    <a href="{{ route('vendor.product.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm font-semibold">
                        + Add New Product
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-left text-sm uppercase font-semibold">
                                <th class="py-3 px-4 border-b">Image</th>
                                <th class="py-3 px-4 border-b">Product Name</th>
                                <th class="py-3 px-4 border-b">Price</th>
                                <th class="py-3 px-4 border-b">Stock</th>
                                <th class="py-3 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="py-3 px-4">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="product" class="w-12 h-12 object-cover rounded">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="py-3 px-4">{{ number_format($product->price) }} MMK</td>
                                    <td class="py-3 px-4">{{ $product->stock }} units</td>
                                    <td class="py-3 px-4">
                                        <button class="text-blue-600 hover:text-blue-900 mr-2">Edit</button>
                                        <button class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-400">No products uploaded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('vendor.product.create') }}"><button type="submit">Add new product</button></a>
            </div>
        </div>
    </div>
</x-app-layout>
