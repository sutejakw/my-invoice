<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->numberBetween(10, 1000),
            'customer_id' => Customer::get()->random()->id,
            'date' => $this->faker->date,
            'due_date' => $this->faker->date,
            'reference' => 'REF-'.rand(10, 500),
            'terms_and_conditions' => $this->faker->paragraph(2),
            'sub_total' => $this->faker->numberBetween(100, 1000),
            'discount' => $this->faker->numberBetween(10, 100),
            'total' => $this->faker->numberBetween(20, 2000)
        ];
    }
}
