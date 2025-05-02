<div class="container mx-auto px-4 py-8">
    <x-shared-navigation :cartItems="$cartItems" />
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        @if($category->description)
            <p class="mt-2 text-gray-600">{{ $category->description }}</p>
        @endif
    </div>

    <div class="category-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>
                    </a>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
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

    @if($products->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No Products Found</h3>
            <p class="mt-1 text-gray-500">There are no products in this category yet.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Browse All Products
                </a>
            </div>
        </div>
    @endif

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
