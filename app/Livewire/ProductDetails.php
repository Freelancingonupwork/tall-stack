<?php

namespace App\Livewire;

use App\Models\Shop\Product;
use Livewire\Component;
use App\Models\Cart;

class ProductDetails extends Component
{
    public $product;
    public $cartItems;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)
            ->with(['categories', 'brand'])
            ->firstOrFail();
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        if (auth('customer')->check()) {
            $this->cartItems = Cart::where('user_id', auth('customer')->id())->get();
        } else {
            $this->cartItems = collect();
        }
    }

    public function addToCart()
    {
        if (!auth('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $cartItem = Cart::firstOrNew([
            'user_id' => auth('customer')->id(),
            'product_id' => $this->product->id
        ]);

        $cartItem->quantity = ($cartItem->quantity ?? 0) + 1;
        $cartItem->save();

        $this->updateCartCount();
        $this->dispatch('productAddedToCart');
    }

    public function render()
    {
        return view('livewire.product-details');
    }
}
