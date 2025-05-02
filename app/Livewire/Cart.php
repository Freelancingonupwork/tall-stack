<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus;

class Cart extends Component
{
    public $cartItems;
    public $total = 0;

    protected $listeners = ['productAddedToCart' => 'updateCart'];

    public function mount()
    {
        $this->updateCart();
    }

    public function updateCart()
    {
        if (auth('customer')->check()) {
            $this->cartItems = CartModel::where('user_id', auth('customer')->id())
                ->with('product')
                ->get();

            $this->total = $this->cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        } else {
            $this->cartItems = collect();
            $this->total = 0;
        }
    }

    public function checkout()
    {
        if (!auth('customer')->check()) {
            return redirect()->route('customer.login');
        }

        if ($this->cartItems->isEmpty()) {
            return;
        }

        return redirect()->route('checkout');
    }

    public function addToCart($productId)
    {
        if (!auth('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $cartItem = CartModel::firstOrNew([
            'user_id' => auth('customer')->id(),
            'product_id' => $productId
        ]);

        $cartItem->quantity = ($cartItem->quantity ?? 0) + 1;
        $cartItem->save();

        $this->updateCart();
        $this->dispatch('productAddedToCart');
    }

    public function removeFromCart($cartItemId)
    {
        $cartItem = CartModel::find($cartItemId);
        if ($cartItem && $cartItem->user_id === auth('customer')->id()) {
            $cartItem->delete();
        }
        $this->updateCart();
        $this->dispatch('productAddedToCart');
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        if ($quantity < 1) {
            $this->removeFromCart($cartItemId);
            return;
        }

        $cartItem = CartModel::find($cartItemId);
        if ($cartItem && $cartItem->user_id === auth('customer')->id()) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }
        $this->updateCart();
        $this->dispatch('productAddedToCart');
    }

    public function render()
    {
        return view('livewire.cart');
    }
} 