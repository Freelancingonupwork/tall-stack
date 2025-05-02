<div class="container mx-auto px-4 py-8">
    <x-shared-navigation :cartItems="$cartItems" />

    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>

        @if($cartItems->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">Your cart is empty</p>
                <a href="{{ route('products.index') }}" class="button mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors duration-300">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($cartItems as $item)
                    <div class="flex items-center justify-between border-b pb-4 cart-list">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 flex-shrink-0">
                                @if($item->product->getFirstMediaUrl())
                                    <img src="{{ $item->product->getFirstMediaUrl() }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                @else
                                    <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-left">{{ $item->product->name }}</h3>
                                <p class="text-gray-600 text-left">${{ number_format($item->product->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center rounded">
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                        class="px-3 py-1 border-r hover:bg-gray-100">-</button>
                                <span class="px-3 py-1">{{ $item->quantity }}</span>
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                        class="px-3 py-1 border-l hover:bg-gray-100">+</button>
                            </div>
                            <span class="font-semibold">${{ number_format($item->quantity * $item->product->price, 2) }}</span>
                            <button wire:click="removeFromCart({{ $item->id }})" class="remove-btn text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-between items-center">
                <div>
                    <p class="text-lg">Total: <span class="font-bold">${{ number_format($total, 2) }}</span></p>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('products.index') }}" class="inline-block bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition-colors duration-300">
                        Continue Shopping
                    </a>
                    <button wire:click="checkout" 
                            wire:loading.attr="disabled"
                            wire:target="checkout"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="checkout">
                            Checkout
                        </span>
                        <span wire:loading wire:target="checkout">
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
