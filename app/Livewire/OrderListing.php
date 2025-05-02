<?php

namespace App\Livewire;

use App\Models\Shop\Order;
use App\Models\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class OrderListing extends Component
{
    use WithPagination;

    public $cartItems;

    public function mount()
    {
        if (auth('customer')->check()) {
            $this->cartItems = Cart::where('user_id', auth('customer')->id())->get();
        } else {
            $this->cartItems = collect();
        }
    }

    public function render()
    {
        return view('livewire.order-listing', [
            'orders' => Order::where('shop_customer_id', auth('customer')->id())
                ->with(['items.product'])
                ->latest()
                ->paginate(10)
        ]);
    }
} 