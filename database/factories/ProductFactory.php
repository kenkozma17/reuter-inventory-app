<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'quantity' => $this->faker->numberBetween(0,1000),
            'size' => $this->faker->numberBetween(0,1000),
            'color' => $this->faker->colorName,
            'price' => $this->faker->numberBetween(0, 10000),
            'has_notification' => $this->faker->boolean,
            'notification_quantity' => $this->faker->numberBetween(0, 100),
        ];
    }
}
