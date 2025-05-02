<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use Livewire\Component;

class NavigationCart extends Component
{
    public $cartCount = 0;

    protected $listeners = ['productAddedToCart' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        if (auth('customer')->check()) {
            $this->cartCount = CartModel::where('user_id', auth('customer')->id())->count();
        } else {
            $this->cartCount = 0;
        }
    }

    public function render()
    {
        return view('livewire.navigation-cart');
    }
} 