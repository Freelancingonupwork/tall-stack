<?php

namespace App\Livewire;

use App\Models\Shop\Order;
use App\Models\Cart;
use Livewire\Component;

class OrderDetails extends Component
{
    public Order $order;
    public $cartItems;

    public function mount($id)
    {
        $this->order = Order::where('shop_customer_id', auth('customer')->id())
            ->with(['items.product', 'customer'])
            ->findOrFail($id);

        if (auth('customer')->check()) {
            $this->cartItems = Cart::where('user_id', auth('customer')->id())->get();
        } else {
            $this->cartItems = collect();
        }
    }

    public function render()
    {
        return view('livewire.order-details');
    }
} 