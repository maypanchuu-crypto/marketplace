<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-gray-50 dark:bg-gray-950 flex flex-col justify-center items-center pt-10 pb-12 px-4 sm:px-6">

        <div
            class="max-w-5xl w-full bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden grid grid-cols-1 md:grid-cols-2 p-6 gap-8">

            <div class="space-y-4 w-full flex flex-col justify-between">
                <div
                    class="relative aspect-square md:h-[400px] md:w-full bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden border dark:border-gray-700 shadow-inner">
                    <div class="w-full h-full flex transition-transform duration-300" id="imageSlider">
                        <div class="w-full h-full flex-shrink-0">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover"
                                alt="{{ $product->name }}">
                        </div>

                        @if($product->images)
                            @foreach($product->images as $img)
                                <div class="w-full h-full flex-shrink-0">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover"
                                        alt="Product Image">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @if($product->images && $product->images->count() > 0)
                        <button onclick="moveSlide(-1)"
                            class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-black/60 backdrop-blur-sm transition">❮</button>
                        <button onclick="moveSlide(1)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-black/60 backdrop-blur-sm transition">❯</button>
                    @endif
                </div>

                @if($product->images && $product->images->count() > 0)
                    <div class="flex gap-2 overflow-x-auto pb-2 justify-center">
                        <div class="w-14 h-14 border-2 border-blue-500 rounded-lg overflow-hidden cursor-pointer flex-shrink-0 shadow-sm transition"
                            onclick="setSlide(0)">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        </div>
                        @foreach($product->images as $index => $img)
                            <div class="w-14 h-14 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden cursor-pointer flex-shrink-0 thumbnail-item shadow-sm transition"
                                data-color="{{ strtolower($img->color) }}" data-index="{{ $index + 1 }}"
                                onclick="setSlide({{ $index + 1 }})">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex flex-col justify-between space-y-5">
                <div class="space-y-4">
                    <div
                        class="flex justify-between items-center text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                        <span class="text-amber-500 dark:text-amber-400 font-bold">
                            {{ $product->vendor->shop_name ?? 'May\'s Store' }}
                        </span>
                         <!-- <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-md border dark:border-gray-700">
                            {{ $product->category->name ?? 'Category' }}
                        </span> -->
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                        {{ $product->name }}
                    </h1>

                    <div class="flex items-center justify-between pt-1">
                        <div class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">
                            {{ number_format($product->price) }} <span
                                class="text-lg font-bold text-gray-500">MMK</span>
                        </div>
                        <div>
                            @if($product->stock > 0)
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    In Stock ({{ $product->stock }})
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800/60">
                        <h3 class="text-xs font-bold text-amber-500 dark:text-amber-400 uppercase mb-2">Description</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                    class="pt-4 border-t border-gray-100 dark:border-gray-800/60 space-y-5">
                    @csrf

                    @if(!empty($product->sizes) || !empty($product->colors))
                        <div class="grid grid-cols-2 gap-4">
                            @if(!empty($product->sizes))
                                <div>
                                    <label for="size"
                                        class="block text-xs font-bold text-amber-500 dark:text-amber-400 uppercase mb-1.5">Size</label>
                                    <select id="size" name="size"
                                        class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 dark:text-white font-medium shadow-sm">
                                        @foreach(json_decode($product->sizes) as $size)
                                            <option value="{{ $size }}">{{ strtoupper($size) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if(!empty($product->colors))
                                <div>
                                    <label for="color"
                                        class="block text-xs text-amber-500 dark:text-amber-400 font-bold uppercase mb-1.5">Color</label>
                                    <select id="color" name="color" onchange="changeProductImageByColor(this.value)"
                                        class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 dark:text-white font-medium shadow-sm">
                                        <option value="">-- Color --</option>
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
                            <div class="flex items-end gap-4">
                                <div class="flex-shrink-0">
                                    <span class="block text-xs font-bold text-amber-500 dark:text-amber-400 uppercase mb-1.5">Qty</span>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                        oninput="if(parseInt(this.value) > {{ $product->stock }}) this.value = {{ $product->stock }}; if(parseInt(this.value) < 1) this.value = 1;"
                                        class="w-20 px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-center bg-gray-50 dark:bg-gray-800 text-sm font-bold focus:outline-none dark:text-white shadow-sm">
                                </div>

                                <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-xl transition flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform active:scale-[0.98]">
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
                                class="w-full px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 font-bold text-sm rounded-xl cursor-not-allowed text-center border dark:border-gray-700">
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        const darkModeRow = document.getElementById('darkModeRow');
        const darkModeToggle = document.getElementById('darkModeToggle');

        function updateTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (darkModeToggle) darkModeToggle.checked = true;
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (darkModeToggle) darkModeToggle.checked = false;
            }
        }

        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            updateTheme(true);
        } else {
            updateTheme(false);
        }

        if (darkModeRow && darkModeToggle) {
            darkModeRow.addEventListener('click', () => {
                updateTheme(!darkModeToggle.checked);
            });
        }

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

            const thumbnails = document.querySelectorAll('.thumbnail-item');

            thumbnails.forEach(thumb => {
                if (thumb.getAttribute('data-color') === selectedColor.toLowerCase()) {
                    const targetIndex = parseInt(thumb.getAttribute('data-index'));
                    setSlide(targetIndex);
                }
            });
        }
    </script>
</x-app-layout>