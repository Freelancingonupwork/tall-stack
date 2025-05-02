<div class="container mx-auto px-4 py-8">
    <x-shared-navigation :cartItems="$cartItems" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($product->getFirstMediaUrl('product-images'))
                <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" 
                     class="w-full h-auto object-cover">
            @else
                <div class="bg-gray-200 h-96 flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
            
            <div class="mb-4">
                <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @if($product->old_price > $product->price)
                    <span class="ml-2 text-lg line-through text-gray-500">${{ number_format($product->old_price, 2) }}</span>
                @endif
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Description</h2>
                <p class="text-gray-600">{{ $product->description }}</p>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Details</h2>
                <ul class="list-disc px-6 text-gray-600">
                    <li>SKU: {{ $product->sku }}</li>
                    <li>Brand: {{ $product->brand?->name ?? 'N/A' }}</li>
                    <li>Categories: 
                        @if($product->categories->count() > 0)
                            {{ $product->categories->pluck('name')->join(', ') }}
                        @else
                            N/A
                        @endif
                    </li>
                    <li>Type: {{ ucfirst($product->type) }}</li>
                </ul>
            </div>

            <div class="flex items-center space-x-4">
                <button type="button"
                        wire:click="addToCart" 
                        wire:loading.attr="disabled"
                        wire:target="addToCart"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
                    <span wire:loading wire:target="addToCart">Adding...</span>
                </button>
                <a href="{{ route('products.index') }}" 
                   class="back-to-products">Back to Products</a>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    <div x-data="{ show: false, message: '' }"
         x-on:product-added.window="show = true; message = 'Product added to cart!'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
         style="display: none;">
        <span x-text="message"></span>
    </div>
</div>
