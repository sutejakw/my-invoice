<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_code' => 'IC-1000'.$this->faker->numberBetween(1, 10000),
            'description' => $this->faker->sentence(3),
            'unit_price' => mt_rand(100, 1000)
        ];
    }
}
