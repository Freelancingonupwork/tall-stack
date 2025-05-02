<?php

namespace App\Livewire;

use App\Models\Shop\Category;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cart;

class CategoryListing extends Component
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

    public function render()
    {
        return view('livewire.category-listing', [
            'categories' => Category::where('is_visible', true)
                ->withCount('products')
                ->latest()
                ->paginate(12)
        ]);
    }
}
