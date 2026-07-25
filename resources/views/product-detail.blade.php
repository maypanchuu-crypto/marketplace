<x-app-layout :hideNav="true">
    <div
        class="min-h-screen bg-gray-100 dark:bg-gray-950 flex flex-col justify-center items-center pt-10 pb-12 px-4 sm:px-6">

        <!-- 🧊 🌈 3D FLOATING RAINBOW BLOCK CARD (အောက်ခြေနှင့် ဘေးဘက် 3D Solid Wall ပါရှိသော စနစ်) -->
        <div
            class="max-w-5xl w-full bg-gradient-to-br from-red-500 via-amber-400 via-green-500 via-cyan-500 to-purple-600 rounded-3xl p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8 border border-white/40 shadow-none">

            <!-- 🟢 Left Side: Image Slider Section -->
            <div class="space-y-4 w-full flex flex-col justify-between">
                <div
                    class="relative aspect-square md:h-[400px] md:w-full bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border-2 border-white/80 shadow-[6px_8px_0px_0px_rgba(0,0,0,0.3)]">
                    <div class="w-full h-full flex transition-transform duration-300" id="imageSlider">
                        <!-- 💡 Slide 0: Main Cover Image -->
                        <div class="w-full h-full flex-shrink-0">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover"
                                alt="{{ $product->name }}">
                        </div>

                        <!-- 💡 Slide 1, 2, 3... : Color Specific Images ($img->image_path ကို သုံးရပါမည်) -->
                        @if($product->images && $product->images->count() > 0)
                            @foreach($product->images as $img)
                                <div class="w-full h-full flex-shrink-0">
                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                        class="w-full h-full object-contain p-2" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- 🧊 3D Slider Buttons -->
                    @if($product->images && $product->images->count() > 0)
                        <button type="button" onclick="moveSlide(-1)"
                            class="absolute left-3 top-1/2 -translate-y-1/2 bg-white text-gray-900 w-9 h-9 rounded-full flex items-center justify-center font-black shadow-[2px_4px_0px_0px_rgba(0,0,0,0.5)] border border-gray-300 active:translate-y-[-40%] active:shadow-none transition-all z-10">❮</button>
                        <button type="button" onclick="moveSlide(1)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-white text-gray-900 w-9 h-9 rounded-full flex items-center justify-center font-black shadow-[2px_4px_0px_0px_rgba(0,0,0,0.5)] border border-gray-300 active:translate-y-[-40%] active:shadow-none transition-all z-10">❯</button>
                    @endif
                </div>

                @if($product->images && $product->images->count() > 0)
                    <div class="flex gap-3 overflow-x-auto pb-2 justify-center">
                        <div class="w-14 h-14 border-2 border-white rounded-xl overflow-hidden cursor-pointer flex-shrink-0 shadow-[3px_4px_0px_0px_rgba(0,0,0,0.3)] transition transform hover:-translate-y-1"
                            onclick="setSlide(0)">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        </div>
                        @foreach($product->images as $index => $img)
                            <div class="w-14 h-14 border-2 border-white rounded-xl overflow-hidden cursor-pointer flex-shrink-0 thumbnail-item shadow-[3px_4px_0px_0px_rgba(0,0,0,0.3)] transition transform hover:-translate-y-1"
                                data-color="{{ strtolower(trim($img->color ?? '')) }}" data-index="{{ $index + 1 }}"
                                onclick="setSlide({{ $index + 1 }})">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 🟢 Right Side: Details Container (Card ကြီး၏ အပေါ်တွင် 3D အနက်ဖြင့် ကြွတက်နေသော ဘုတ်ပြား) -->
            <div
                class="flex flex-col justify-between space-y-5 bg-white/95 dark:bg-gray-900/95 p-6 sm:p-7 rounded-2xl border-t-2 border-l-2 border-white shadow-[8px_12px_0px_0px_rgba(0,0,0,0.25)]">
                <div class="space-y-4">

                    <!-- 🧊 Vendor Badge -->
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider">
                        <span
                            class="text-amber-800 dark:text-amber-300 font-extrabold bg-amber-200/80 dark:bg-amber-900/60 px-3.5 py-1.5 rounded-full border border-amber-400 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.2)]">
                            {{ $product->vendor->shop_name ?? 'May\'s Store' }}
                        </span>
                    </div>

                    <!-- 🧊 Title -->
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- 🧊 Price & Stock -->
                    <div class="flex items-center justify-between pt-1">
                        <div class="text-3xl sm:text-4xl font-black text-red-600 dark:text-red-500 tracking-tight">
                            {{ number_format($product->price) }} <span
                                class="text-lg font-black text-red-600 dark:text-red-500">MMK</span>
                        </div>
                        <div>
                            @if($product->stock > 0)
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-black rounded-full bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-300 border border-green-400 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.15)]">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    In Stock ({{ $product->stock }})
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-black rounded-full bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-300 border border-rose-400 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.15)]">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="pt-4 border-t-2 border-gray-100 dark:border-gray-800">
                        <h3 class="text-xs font-black text-amber-600 dark:text-amber-400 uppercase mb-2 tracking-wide">
                            Description</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed font-semibold">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                    class="pt-4 border-t-2 border-gray-100 dark:border-gray-800 space-y-5">
                    @csrf

                    @if(!empty($product->sizes) || !empty($product->colors))
                        <div class="grid grid-cols-2 gap-4">
                            @if(!empty($product->sizes))
                                <div>
                                    <label for="size"
                                        class="block text-xs font-black text-amber-600 dark:text-amber-400 uppercase mb-1.5">Size</label>
                                    <select id="size" name="size"
                                        class="w-full px-3 py-2.5 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 dark:text-white font-black shadow-[2px_3px_0px_0px_rgba(0,0,0,0.15)]">
                                        @foreach(json_decode($product->sizes) as $size)
                                            <option value="{{ $size }}">{{ strtoupper($size) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if(!empty($product->colors))
                                <div>
                                    <label for="color"
                                        class="block text-xs text-amber-600 dark:text-amber-400 font-black uppercase mb-1.5">Color</label>
                                    <select id="color" name="color" onchange="changeProductImageByColor(this.value)"
                                        class="w-full px-3 py-2.5 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 dark:text-white font-black shadow-[2px_3px_0px_0px_rgba(0,0,0,0.15)]">
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
                                    <span
                                        class="block text-xs font-black text-amber-600 dark:text-amber-400 uppercase mb-1.5">Qty</span>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                        oninput="if(parseInt(this.value) > {{ $product->stock }}) this.value = {{ $product->stock }}; if(parseInt(this.value) < 1) this.value = 1;"
                                        class="w-20 px-3 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-center bg-white dark:bg-gray-800 text-sm font-black focus:outline-none dark:text-white shadow-[2px_3px_0px_0px_rgba(0,0,0,0.15)]">
                                </div>

                                <!-- 🧊 3D Add to Cart Button -->
                                <button type="submit"
                                    class="flex-1 bg-amber-500 hover:bg-amber-400 text-gray-950 font-black py-3 px-6 rounded-xl transition-all flex items-center justify-center gap-2 border-b-4 border-r-2 border-amber-800 shadow-[4px_6px_0px_0px_rgba(0,0,0,0.4)] active:translate-y-1 active:shadow-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-[2.5]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 000-4z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </div>
                        @else
                            <button disabled type="button"
                                class="w-full px-6 py-3 bg-gray-200 dark:bg-gray-800 text-gray-500 font-black text-sm rounded-xl cursor-not-allowed text-center border-b-4 border-gray-400 dark:border-gray-900 shadow-sm">
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

        // 💡 Color ရွေးလိုက်လျှင် သက်ဆိုင်ရာ Image ရဲ့ Slide ထံ တိုက်ရိုက် ရွှေ့ပေးမည့် Function
        function changeProductImageByColor(selectedColor) {
            if (!selectedColor) return;

            // စာသား အပို Space များနှင့် အကြီးအသေးများကို ညှိယူပါမည်
            const targetColor = selectedColor.toString().trim().toLowerCase();
            const thumbnails = document.querySelectorAll('.thumbnail-item');

            for (let thumb of thumbnails) {
                const thumbColor = (thumb.getAttribute('data-color') || '').toString().trim().toLowerCase();

                if (thumbColor === targetColor) {
                    const targetIndex = parseInt(thumb.getAttribute('data-index'));
                    setSlide(targetIndex);
                    break;
                }
            }
        }
    </script>
</x-app-layout>