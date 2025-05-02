<?php

namespace App\Livewire;

use App\Models\Shop\Product;
use Livewire\Component;

class SearchProducts extends Component
{
    public $search = '';
    public $showResults = false;
    public $searchResults = [];

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->select(['id', 'name', 'price', 'slug'])
            ->take(5)
            ->get();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->searchResults = [];
        $this->showResults = false;
    }

    public function showSearchResults()
    {
        $this->showResults = true;
    }

    public function hideSearchResults()
    {
        $this->showResults = false;
    }

    public function submitSearch()
    {
        if (!empty($this->search)) {
            return redirect()->route('products.index', ['search' => $this->search]);
        }
    }

    public function render()
    {
        return view('livewire.search-products');
    }
} 