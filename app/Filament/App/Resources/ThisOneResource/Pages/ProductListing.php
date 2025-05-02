<?php

namespace App\Filament\App\Resources\ThisOneResource\Pages;

use App\Filament\App\Resources\ThisOneResource;
use App\Models\Shop\Product;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class ProductListing extends Page
{
    protected static string $resource = ThisOneResource::class;

    protected static string $view = 'livewire.product-listing';

    public function mount(): void
    {
        $this->products = Product::where('is_visible', true)
            ->latest()
            ->paginate(12);
    }

    public function render(): View
    {
        return view('livewire.product-listing', [
            'products' => $this->products
        ]);
    }
}
