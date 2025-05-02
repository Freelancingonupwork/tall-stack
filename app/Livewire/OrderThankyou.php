<?php

namespace App\Livewire;

use App\Models\Shop\Order;
use Livewire\Component;

class OrderThankyou extends Component
{
    public Order $order;

    public function mount($id)
    {
        $this->order = Order::where('shop_customer_id', auth('customer')->id())
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.order-thankyou');
    }
} 