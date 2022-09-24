<?php

namespace Database\Factories\InvoiceItem;

use App\Models\Invoice\Invoice;
use App\Models\Product\Product;
use App\Models\InvoiceItem\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    protected $model = InvoiceItem::class;

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
