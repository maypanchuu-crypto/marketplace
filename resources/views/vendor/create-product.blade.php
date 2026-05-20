<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
                        <strong class="font-bold">Whoops! Something went wrong.</strong>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Price (MMK)</label>
                            <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Stock Qty</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border rounded p-2" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Product Image</label>
                        <input type="file" name="image" class="w-full border rounded p-2" required>
                        <span class="text-xs text-gray-500">Allowed formats: jpeg, png, jpg, webp (Max: 5MB)</span>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('vendor.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Product</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>