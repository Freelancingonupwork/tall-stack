<?php

namespace Database\Seeders;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\Address;
use App\Models\Blog\Author;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Link;
use App\Models\Blog\Post;
use App\Models\Comment;
use App\Models\Shop\Brand;
use App\Models\Shop\Category as ShopCategory;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\User;
use Closure;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::raw('SET time_zone=\'+00:00\'');

        // Clear images
        Storage::deleteDirectory('public');

        // Admin
        $this->command->warn(PHP_EOL . 'Creating admin user...');
        $user = $this->withProgressBar(1, fn () => User::firstOrCreate(
            ['email' => 'admin@filamentphp.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        ));
        $adminUser = $user->first();
        $this->command->info('Admin user created.');

        // Shop
        $this->command->warn(PHP_EOL . 'Creating shop brands...');
        $brands = $this->withProgressBar(20, fn () => Brand::factory()
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        Brand::query()->update(['sort' => new Expression('id')]);
        $this->command->info('Shop brands created.');

        $this->command->warn(PHP_EOL . 'Creating shop categories...');
        $categories = $this->withProgressBar(20, fn () => ShopCategory::factory()
            ->has(ShopCategory::factory()->count(3), 'children')
            ->create());
        $this->command->info('Shop categories created.');

        $this->command->warn(PHP_EOL . 'Creating shop products...');
        $products = $this->withProgressBar(50, fn () => Product::factory()
            ->sequence(fn ($sequence) => ['shop_brand_id' => $brands->random()->id])
            ->hasAttached($categories->random(rand(3, 6)), ['created_at' => now(), 'updated_at' => now()])
            ->create());
        $this->command->info('Shop products created.');

        $this->command->warn(PHP_EOL . 'Creating orders...');
        $orders = $this->withProgressBar(50, fn () => Order::factory()
            ->create([
                'shop_customer_id' => $adminUser->id,
                'number' => 'ORD-' . uniqid(),
                'currency' => 'USD',
                'total_price' => 0, // Will be updated after items are added
            ])
            ->each(function ($order) use ($products) {
                $items = OrderItem::factory()
                    ->count(rand(2, 5))
                    ->make([
                        'shop_product_id' => $products->random()->id,
                        'shop_order_id' => $order->id,
                        'sort' => 0,
                    ]);
                
                $order->items()->saveMany($items);
                
                // Update order total
                $order->update([
                    'total_price' => $order->items->sum(function ($item) {
                        return $item->qty * $item->unit_price;
                    })
                ]);
            }));
        $this->command->info('Shop orders created.');

        if ($orders->isNotEmpty()) {
            foreach ($orders->random(min($orders->count(), rand(5, 8))) as $order) {
                Notification::make()
                    ->title('New order')
                    ->icon('heroicon-o-shopping-bag')
                    ->body("{$order->customer->name} ordered {$order->items->count()} products.")
                    ->actions([
                        Action::make('View')
                            ->url(OrderResource::getUrl('edit', ['record' => $order])),
                    ])
                    ->sendToDatabase($adminUser);
            }
        }

        // Blog
        $this->command->warn(PHP_EOL . 'Creating blog categories...');
        $blogCategories = $this->withProgressBar(20, fn () => BlogCategory::factory()
            ->count(20)
            ->create());
        $this->command->info('Blog categories created.');

        $this->command->warn(PHP_EOL . 'Creating blog authors and posts...');
        $this->withProgressBar(20, fn () => Author::factory()
            ->has(
                Post::factory()->count(5)
                    ->has(
                        Comment::factory()->count(rand(5, 10))
                            ->state(fn (array $attributes, Post $post) => ['customer_id' => null]),
                    )
                    ->state(fn (array $attributes, Author $author) => ['blog_category_id' => $blogCategories->random()->id]),
                'posts'
            )
            ->create());
        $this->command->info('Blog authors and posts created.');

        $this->command->warn(PHP_EOL . 'Creating blog links...');
        $this->withProgressBar(20, fn () => Link::factory()
            ->count(20)
            ->create());
        $this->command->info('Blog links created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);
        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $result = $createCollectionOfOne();
            if ($result instanceof Model) {
                $items->push($result);
            } elseif ($result instanceof Collection) {
                $items = $items->merge($result);
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln('');

        return $items;
    }
}
