<div class="min-h-screen bg-gray-100">
    <x-shared-navigation />

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Checkout</h2>

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Details -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Customer Details</h3>
                            <div class="space-y-4 checkout-form">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" wire:model="email" readonly class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Shipping Address -->
                                <div class="border-t pt-4 mt-4">
                                    <h4 class="text-lg font-medium mb-4">Shipping Address</h4>
                                    
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <label class="block text-sm font-medium text-gray-700">Country</label>
                                            <div class="mt-1 relative" x-data @click.away="$wire.closeDropdown()">
                                                <div class="relative">
                                                    <input
                                                        type="text"
                                                        wire:model.live="search"
                                                        wire:focus="focusSearch"
                                                        placeholder="Search country..."
                                                        class="block w-full rounded-md border-gray-300"
                                                        value="{{ $country ?: '' }}"
                                                    >
                                                    @if($country)
                                                        <button 
                                                            type="button" 
                                                            class="absolute inset-y-0 right-8 flex items-center pr-2 country-btn"
                                                            wire:click="selectCountry('')"
                                                        >
                                                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                        <button 
                                                            type="button" 
                                                            class="absolute inset-y-0 right-0 flex items-center pr-2 country-btn"
                                                            wire:click="focusSearch"
                                                        >
                                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                @if($showDropdown && !$country)
                                                    <div class="absolute z-10 w-full mt-1 bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                                        @if(empty($filteredCountries))
                                                            <div class="relative cursor-default select-none py-2 px-4 text-gray-700">
                                                                No countries found.
                                                            </div>
                                                        @else
                                                            @foreach($filteredCountries as $filteredCountry)
                                                                <div
                                                                    wire:key="country-{{ $filteredCountry }}"
                                                                    wire:click="selectCountry('{{ $filteredCountry }}')"
                                                                    class="relative cursor-pointer select-none py-2 px-4 text-gray-900 hover:bg-indigo-600 hover:text-white"
                                                                >
                                                                    {{ $filteredCountry }}
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Street address</label>
                                            <input type="text" wire:model="street" class="mt-1 block w-full rounded-md border-gray-300">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">City</label>
                                            <input type="text" wire:model="city" class="mt-1 block w-full rounded-md border-gray-300">
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">State / Province</label>
                                                <input type="text" wire:model="state" class="mt-1 block w-full rounded-md border-gray-300">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Zip / Postal code</label>
                                                <input type="text" wire:model="zip" class="mt-1 block w-full rounded-md border-gray-300">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                    <textarea wire:model="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Special notes for delivery"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Order Summary</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-4">
                                    @foreach($cartItems as $item)
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h4 class="font-medium">{{ $item->product->name }}</h4>
                                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                            </div>
                                            <p class="font-medium">${{ number_format($item->quantity * $item->product->price, 2) }}</p>
                                        </div>
                                    @endforeach

                                    <div class="border-t pt-4 mt-4">
                                        <div class="flex justify-between items-center font-medium">
                                            <span>Total</span>
                                            <span>${{ number_format($total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-x-4">
                                <button wire:click="placeOrder" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Place Order
                                </button>
                                <a href="{{ route('cart') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Back to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 