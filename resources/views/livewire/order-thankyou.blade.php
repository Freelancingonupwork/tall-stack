<div class="min-h-screen bg-gray-100">
    <x-shared-navigation />

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>

                    <h2 class="mt-4 text-2xl font-semibold text-gray-900">Thank you for your order!</h2>
                    <p class="mt-2 text-gray-600">Your order number is: {{ $order->number }}</p>

                    <div class="mt-6 space-y-4">
                        <p class="text-gray-600">We'll send you a confirmation email with your order details.</p>
                        
                        <div class="space-x-4">
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Order Details
                            </a>
                            <a href="{{ route('products.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 