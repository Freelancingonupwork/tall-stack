<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // example model
use Database\Seeders\LocalImages;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $image = LocalImages::getRandomFile();

            Product::create([
                'name' => 'Product ' . $i,
                'price' => rand(100, 500),
                'image_path' => 'uploads/' . $image->getFilename(),
            ]);

            // Optionally move/copy image if needed
            Storage::disk('public')->put(
                'uploads/' . $image->getFilename(),
                file_get_contents($image->getPathname())
            );
        }
    }
}
