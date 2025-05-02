<?php

namespace App\Livewire;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cart;

class CategoryDetails extends Component
{
    use WithPagination;

    public $category;
    public $cartItems;

    public function mount($id)
    {
        $this->category = Category::findOrFail($id);
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
        return view('livewire.category-details', [
            'products' => $this->category->products()
                ->where('is_visible', true)
                ->with('media')
                ->latest()
                ->paginate(12)
        ]);
    }
}
