<x-app-layout :hideNav="true">
    <div class="max-w-2xl mx-auto pt-10 pb-12 px-4 sm:px-6">

        <div
            class="bg-white dark:bg-gray-850 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col p-6">

            <div class="space-y-4 w-full">
                <div
                    class="relative aspect-[4/3] w-full bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden border dark:border-gray-700">
                    <div class="w-full h-full flex transition-transform duration-300" id="imageSlider">
                        <div class="min-w-full h-full flex-shrink-0">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain"
                                alt="{{ $product->name }}">
                        </div>

                        @if($product->images)
                            @foreach($product->images as $img)
                                <div class="min-w-full h-full flex-shrink-0">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-contain"
                                        alt="Product Image">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @if($product->images && $product->images->count() > 0)
                        <button onclick="moveSlide(-1)"
                            class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-black/70 transition">❮</button>
                        <button onclick="moveSlide(1)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-black/70 transition">❯</button>
                    @endif
                </div>

                @if($product->images && $product->images->count() > 0)
                    <div class="flex gap-2 overflow-x-auto pb-2 justify-center">
                        <div class="w-14 h-14 border-2 border-blue-500 rounded-lg overflow-hidden cursor-pointer flex-shrink-0"
                            onclick="setSlide(0)">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        </div>
                        @foreach($product->images as $index => $img)
                            <div class="w-14 h-14 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden cursor-pointer flex-shrink-0 thumbnail-item"
                                data-color="{{ strtolower($img->color) }}" data-index="{{ $index + 1 }}"
                                onclick="setSlide({{ $index + 1 }})">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-6 space-y-4">

                <div
                    class="flex justify-between items-center text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    <span>Shop: {{ $product->vendor->shop_name ?? 'May\'s Store' }}</span>
                    <span
                        class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 rounded">{{ $product->category->name ?? 'Category' }}</span>
                </div>

                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                    {{ $product->name }}
                </h1>

                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        {{ number_format($product->price) }} MMK
                    </div>
                    <div>
                        @if($product->stock > 0)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                In Stock ({{ $product->stock }})
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Out of Stock
                            </span>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100 dark:border-gray-800">
                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                    class="pt-4 border-t border-gray-100 dark:border-gray-800 space-y-4">
                    @csrf

                    @if(!empty($product->sizes) || !empty($product->colors))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            @if(!empty($product->sizes))
                                <div>
                                    <label for="size"
                                        class="block text-xs font-bold text-gray-400 uppercase mb-1.5">Size</label>
                                    <select id="size" name="size"
                                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 dark:text-white">
                                        @foreach(json_decode($product->sizes) as $size)
                                            <option value="{{ $size }}">{{ strtoupper($size) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if(!empty($product->colors))
                                <div>
                                    <label for="color"
                                        class="block text-xs font-bold text-gray-400 uppercase mb-1.5">Color</label>
                                    <select id="color" name="color" onchange="changeProductImageByColor(this.value)"
                                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 dark:text-white">
                                        <option value="">-- Choose Color --</option>
                                        @foreach(json_decode($product->colors) as $color)
                                            <option value="{{ strtolower($color) }}">{{ ucfirst($color) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>
                    @endif

                    <div class="pt-2">
                        @if($product->stock > 0)
                            <div class="space-y-4">
                                <div>
                                    <span class="block text-xs font-bold text-gray-400 uppercase mb-1">QUANTITY</span>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                        class="w-20 px-3 py-2 border rounded-xl text-center bg-gray-50 text-sm focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                </div>

                                <button type="submit"
                                    class="w-full bg-blue-600 text-white font-medium py-3 px-6 rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2 shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </div>
                        @else
                            <button disabled type="button"
                                class="w-full px-6 py-3 bg-gray-200 dark:bg-gray-800 text-gray-400 dark:text-gray-500 font-bold text-sm rounded-xl cursor-not-allowed text-center">
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slider = document.getElementById('imageSlider');
        const totalSlides = slider ? slider.children.length : 0;

        function updateSlider() {
            if (slider) slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function moveSlide(direction) {
            currentSlide += direction;
            if (currentSlide >= totalSlides) currentSlide = 0;
            if (currentSlide < 0) currentSlide = totalSlides - 1;
            updateSlider();
        }

        function setSlide(index) {
            currentSlide = index;
            updateSlider();
        }

        function changeProductImageByColor(selectedColor) {
            if (!selectedColor) return;

            // find every thumbnail items from html
            const thumbnails = document.querySelectorAll('.thumbnail-item');

            thumbnails.forEach(thumb => {
                // find image suit with color
                if (thumb.getAttribute('data-color') === selectedColor.toLowerCase()) {
                    const targetIndex = parseInt(thumb.getAttribute('data-index'));
                    setSlide(targetIndex); // 💡 automatic slide image suit with selected color
                }
            });
        }
    </script>
</x-app-layout>