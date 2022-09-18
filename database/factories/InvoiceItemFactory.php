<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::get()->random();
        return [
            'invoice_id' => Invoice::get()->random()->id,
            'product_id' => $product->id,
            'unit_price' => $product->unit_price,
            'quantity' => $this->faker->numberBetween(1, 5)
        ];
    }
}
