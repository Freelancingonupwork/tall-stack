<nav class="main-header bg-white shadow-lg mb-8">
    <div class="max-w-7x2 mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="main-logo flex-shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}" class="text-xl font-bold text-white text-gray-800 text-white hover:text-black">
                        Shop
                    </a>
                </div>
                <div class="menu hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('products.index') }}" 
                       class="border-transparent inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-black">
                        Products
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="border-transparent inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-black">
                        Categories
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}" 
                           class="border-transparent inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-black">
                            My Orders
                        </a>
                    @endauth                    
                </div>
            </div>
            <div class="cart-btn hidden sm:ml-6 sm:flex sm:items-center">
                <a href="{{ route('cart') }}" class="p-1 rounded-full relative text-white hover:text-black">
                    <span class="sr-only">View cart</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(isset($cartItems) && $cartItems->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartItems->count() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</nav> 