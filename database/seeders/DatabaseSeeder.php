<?php

namespace Database\Seeders;

use App\Models\Counter\Counter;
use App\Models\Invoice\Invoice;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;
use App\Models\Customer\Customer;
use App\Models\InvoiceItem\InvoiceItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Counter::factory(1)->create();
        Product::factory(5)->create();
        Customer::factory(5)->create();
        Invoice::factory(5)->create();
        InvoiceItem::factory(5)->create();
    }
}
