<div class="relative" x-data @click.away="$wire.hideSearchResults()">
    <div class="flex relative">
        <input
            type="text"
            wire:model.live="search"
            wire:focus="showSearchResults"
            placeholder="Search products..."
            class="w-64 rounded-md sm:text-sm search-input"
            @keydown.enter.prevent="$wire.submitSearch()"
        >
        <button
            type="button"
            class="search-btn"
            wire:click="submitSearch"
        >
            Search
        </button>
        @if($search)
            <button 
                type="button" 
                class="search-close-btn absolute inset-y-0 right-10 flex items-center pr-3"
                wire:click="clearSearch"
            >
                <svg class="h-5 w-5 text-gray-400 hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        @endif
    </div>

    @if($showResults && count($searchResults) > 0)
        <div class="absolute z-50 mt-1 w-full bg-white rounded-md shadow-lg max-h-60 overflow-auto">
            <ul class="divide-y divide-gray-200">
                @foreach($searchResults as $product)
                    <li>
                        <a href="{{ route('products.show', $product->slug) }}" class="block hover:bg-gray-50 px-4 py-2">
                            <div class="flex items-center">
                                @if($product->getFirstMediaUrl('product-images'))
                                    <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                                @endif
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @elseif($showResults && $search && count($searchResults) === 0)
        <div class="absolute z-50 mt-1 w-full bg-white rounded-md shadow-lg py-2 px-4 border border-gray-200">
            <p class="text-sm text-gray-500">No products found</p>
        </div>
    @endif
</div> 