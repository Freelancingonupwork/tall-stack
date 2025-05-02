<?php

namespace App\Console\Commands;

use App\Models\Shop\Product;
use Illuminate\Console\Command;

class ReRegisterMediaCollections extends Command
{
    protected $signature = 'media:re-register';
    protected $description = 'Re-register media collections for products';

    public function handle()
    {
        $products = Product::all();
        $bar = $this->output->createProgressBar(count($products));

        foreach ($products as $product) {
            $product->registerMediaCollections();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Media collections re-registered successfully!');
    }
} 