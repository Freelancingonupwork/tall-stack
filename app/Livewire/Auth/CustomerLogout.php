<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerLogout extends Component
{
    public function logout()
    {
        Auth::guard('customer')->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('customer.login');
    }

    public function render()
    {
        return <<<'blade'
            <button wire:click="logout" class="text-gray-600 hover:text-gray-900">
                Logout
            </button>
        blade;
    }
} 