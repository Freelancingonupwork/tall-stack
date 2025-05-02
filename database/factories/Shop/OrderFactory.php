<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'shop_customer_id' => \App\Models\User::factory(),
            'number' => 'ORD-' . uniqid(),
            'total_price' => $this->faker->randomFloat(2, 100, 2000),
            'status' => $this->faker->randomElement(['new', 'processing', 'shipped', 'delivered', 'cancelled']),
            'currency' => 'USD',
            'shipping_price' => $this->faker->randomFloat(2, 5, 50),
            'shipping_method' => $this->faker->randomElement(['standard', 'express', 'overnight']),
            'notes' => $this->faker->realText(100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Order $order) {
            $order->address()->save(OrderAddressFactory::new()->make());
        });
    }
}
