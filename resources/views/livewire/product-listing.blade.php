<div>
    <div class="container mx-auto px-4 py-8">
        <x-shared-navigation :cartItems="$cartItems" />
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="relative pb-[100%]">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            @if($product->getFirstMediaUrl('product-images'))
                                <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" 
                                     class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                    </div>
                    <div class="p-4">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 product-title">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>
                        </a>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900 product-price">${{ number_format($product->price, 2) }}</span>
                            <button type="button"
                                    wire:click="addToCart({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="addToCart({{ $product->id }})"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                    Add to Cart
                                </span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})">
                                    Adding...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>

    <div x-data="{ show: false, message: '' }"
         x-show="show"
         x-init="
            Livewire.on('productAddedToCart', () => {
                show = true;
                message = 'Product added to cart successfully!';
                setTimeout(() => show = false, 3000);
            })
         "
         class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         style="display: none;">
        <p x-text="message"></p>
    </div>
</div>
