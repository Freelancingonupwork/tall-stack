<?php

namespace App\Livewire\Auth;

use App\Models\Shop\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CustomerRegister extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:shop_customers,email',
        'password' => 'required|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $customer = Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::guard('customer')->login($customer);

        session()->flash('success', 'Account created successfully!');
        return redirect()->intended(route('customer.dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.customer-register');
    }
} 