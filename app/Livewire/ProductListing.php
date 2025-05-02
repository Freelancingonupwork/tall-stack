<?php

namespace App\Livewire;

use App\Models\Shop\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cart;

class ProductListing extends Component
{
    use WithPagination;

    public $cartItems;

    public function mount()
    {
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

    public function addToCart($productId)
    {
        if (!auth('customer')->check()) {            
            return redirect()->route('customer.login');
        }

        $cartItem = Cart::firstOrNew([
            'user_id' => auth('customer')->id(),
            'product_id' => $productId
        ]);

        $cartItem->quantity = ($cartItem->quantity ?? 0) + 1;
        $cartItem->save();

        $this->updateCartCount();
        $this->dispatch('productAddedToCart');
    }

    public function render()
    {
        $query = Product::where('is_visible', true)->with('media');

        if (request()->has('search') && request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        return view('livewire.product-listing', [
            'products' => $query->latest()->paginate(12)
        ]);
    }
}
