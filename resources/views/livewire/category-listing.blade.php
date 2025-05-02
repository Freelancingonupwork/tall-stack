<div class="container mx-auto px-4 py-8">
    <x-shared-navigation :cartItems="$cartItems" />
    
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Categories</h1>

    <div class="category-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <a href="{{ route('categories.show', $category->id) }}" class="block">
                    <div class="relative pb-[75%]">
                        @if($category->getFirstMediaUrl())
                            <img src="{{ $category->getFirstMediaUrl() }}" alt="{{ $category->name }}" 
                                 class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">{{ $category->products_count }} Products</span>
                            <span class="button inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                View Category
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if($categories->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No Categories Found</h3>
            <p class="mt-1 text-gray-500">Check back later for new categories.</p>
        </div>
    @endif

    <div class="mt-8">
        {{ $categories->links() }}
    </div>
</div>
