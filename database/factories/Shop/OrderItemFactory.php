<?php

namespace Database\Factories\Shop;

use App\Models\Shop\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'shop_order_id' => null, // This will be set when creating orders
            'shop_product_id' => null, // This will be set when creating orders
            'qty' => $this->faker->numberBetween(1, 10),
            'unit_price' => $this->faker->randomFloat(2, 100, 500),
            'sort' => 0,
        ];
    }
}
