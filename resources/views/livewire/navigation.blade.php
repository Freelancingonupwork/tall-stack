<nav class="bg-white shadow-lg mb-8">
    <div class="max-w-7x2 mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="main-shop flex-shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}" class="text-xl font-bold text-white text-white-800">
                        Shop
                    </a>
                </div>
                <div class="menu hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('products.index') }}" 
                       class="{{ request()->routeIs('products.*') ? 'text-white text-white-900' : 'border-transparent text-white-500 hover:border-white-300 hover:text-white-700' }} inline-flex items-center px-1 pt-1  text-sm font-medium">
                        Products
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="{{ request()->routeIs('categories.*') ? 'text-white text-white-900' : 'border-transparent text-white-500 hover:border-white-300 hover:text-white-700' }} inline-flex items-center px-1 pt-1  text-sm font-medium">
                        Categories
                    </a>                    
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <a href="{{ route('cart.index') }}" class="p-1 text-white hover:text-black">
                    <span class="sr-only">View cart</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav> 