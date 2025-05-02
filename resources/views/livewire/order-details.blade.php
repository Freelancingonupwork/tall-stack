<div class="container mx-auto px-4 py-8">
    <x-shared-navigation :cartItems="$cartItems" />
    

    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-900 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Orders
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Order #{{ $order->number }}</h1>
                        <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                        @if($order->status->value === 'new') bg-blue-100 text-blue-800
                        @elseif($order->status->value === 'processing') bg-yellow-100 text-yellow-800
                        @elseif($order->status->value === 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status->value === 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ $order->status->getLabel() }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                <div class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <div class="py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                @if($item->product->getFirstMedia())
                                    <img src="{{ $item->product->getFirstMedia()->getUrl('thumb') }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 object-cover rounded">
                                @endif
                                <div>
                                    <h3 class="font-medium">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ number_format($item->unit_price, 2) }} {{ $order->currency }} × {{ $item->qty }}
                                    </p>
                                </div>
                            </div>
                            <p class="font-medium">
                                {{ number_format($item->unit_price * $item->qty, 2) }} {{ $order->currency }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 border-t pt-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">{{ number_format($order->items->sum(fn($item) => $item->unit_price * $item->qty), 2) }} {{ $order->currency }}</span>
                        </div>

                        @if($order->shipping_price)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping ({{ $order->shipping_method }})</span>
                                <span class="font-medium">{{ number_format($order->shipping_price, 2) }} {{ $order->currency }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-lg font-bold pt-2 border-t">
                            <span>Total</span>
                            <span>{{ number_format($order->total_price, 2) }} {{ $order->currency }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 