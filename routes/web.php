<?php

use App\Livewire\Form;
use App\Livewire\ProductListing;
use App\Livewire\ProductDetails;
use App\Livewire\CategoryListing;
use App\Livewire\CategoryDetails;
use App\Livewire\ShoppingCart;
use App\Livewire\Cart;
use App\Livewire\OrderListing;
use App\Livewire\OrderDetails;
use App\Livewire\Checkout;
use App\Livewire\OrderThankyou;

\Illuminate\Support\Facades\Route::get('form', Form::class);
\Illuminate\Support\Facades\Route::get('products', ProductListing::class)->name('products.index');
\Illuminate\Support\Facades\Route::get('products/{slug}', ProductDetails::class)->name('products.show');
\Illuminate\Support\Facades\Route::get('categories', CategoryListing::class)->name('categories.index');
\Illuminate\Support\Facades\Route::get('categories/{id}', CategoryDetails::class)->name('categories.show');
\Illuminate\Support\Facades\Route::get('/cart', Cart::class)->name('cart');

Route::redirect('/', '/products');

Route::middleware(['auth:customer'])->group(function () {
    Route::get('orders', OrderListing::class)->name('orders.index');
    Route::get('orders/{id}', OrderDetails::class)->name('orders.show');
    Route::get('checkout', Checkout::class)->name('checkout');
    Route::get('order/thankyou/{id}', OrderThankyou::class)->name('order.thankyou');
});

Route::get('/test-image', function () {
    $product = \App\Models\Shop\Product::first();
    return view('test-image', ['product' => $product]);
});

// Customer Authentication Routes
Route::middleware('guest:customer')->group(function () {
    Route::get('/login', App\Livewire\Auth\CustomerLogin::class)->name('customer.login');
    Route::get('/register', App\Livewire\Auth\CustomerRegister::class)->name('customer.register');
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
    
    Route::post('/logout', function () {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    })->name('customer.logout');
});
