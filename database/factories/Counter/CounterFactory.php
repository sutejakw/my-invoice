<?php

namespace Database\Factories\Counter;

use App\Models\Counter\Counter;
use Illuminate\Database\Eloquent\Factories\Factory;

class CounterFactory extends Factory
{
    protected $model = Counter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key' => 'invoice', 
            'prefix' => 'INV-',
            'value' => 20000
        ];
    }
}
