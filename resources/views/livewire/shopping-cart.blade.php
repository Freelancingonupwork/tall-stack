<div class="container mx-auto px-4 py-8">
    <x-shared-navigation :cartItems="$cartItems" />

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if($cartItems && $cartItems->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="divide-y divide-gray-200">
                @foreach($cartItems as $item)
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-24 h-24">
                                @if($item->product->getFirstMediaUrl())
                                    <img src="{{ $item->product->getFirstMediaUrl() }}" alt="{{ $item->product->name }}" 
                                         class="w-full h-full object-cover rounded-md">
                                @else
                                    <div class="w-full h-full bg-gray-200 rounded-md flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-6 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $item->product->name }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ Str::limit($item->product->description, 100) }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center border rounded-md">
                                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                                    class="px-3 py-1 text-gray-600 hover:text-gray-700 focus:outline-none">
                                                -
                                            </button>
                                            <span class="px-3 py-1 text-gray-900">{{ $item->quantity }}</span>
                                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                                    class="px-3 py-1 text-gray-600 hover:text-gray-700 focus:outline-none">
                                                +
                                            </button>
                                        </div>
                                        <span class="ml-4 text-lg font-medium text-gray-900">
                                            ${{ number_format($item->product->price * $item->quantity, 2) }}
                                        </span>
                                        <button wire:click="removeFromCart({{ $item->id }})" 
                                                class="ml-4 text-red-600 hover:text-red-800">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-6 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-900">Total: ${{ number_format($total, 2) }}</span>
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h3>
            <p class="mt-1 text-gray-500">Start shopping to add items to your cart.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Continue Shopping
                </a>
            </div>
        </div>
    @endif
</div>
