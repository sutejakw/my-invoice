<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Invoice\Invoice;
use App\Models\Product\Product;
use App\Models\Customer\Customer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;

class InvoiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use CreatesApplication;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * Test get all invoice data.
     *
     * @return void
     */
    public function test_get_all_invoice(): void
    {
        $response = $this->getJson(route('invoices.index'));
        $response->assertStatus(200);
    }

    /**
     * Test search invoice by id.
     *
     * @return void
     */
    public function test_search_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoices.search'), [
            's' => $invoice->id
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test access form invoice.
     *
     * @return void
     */
    public function test_create_invoice_form(): void
    {
        $response = $this->getJson(route('invoices.create'));
        $response->assertStatus(200);
    }

    /**
     * Test store invoice.
     *
     * @return void
     */
    public function test_store_invoice(): void
    {
        $product = Product::factory()->create();
        $discount = $this->faker->numberBetween(1, 100);

        $invoice_items[] = [
                'id' => $product->id,
                'item_code' => $product->item_code,
                'description' => $product->description,
                'unit_price' => $product->unit_price,
                'quantity' => 1,
        ];

        $sub_total = $invoice_items[0]['unit_price'] * $invoice_items[0]['quantity'];
        $total = ($discount / 100) * $sub_total;
        $grand_total = ceil($sub_total - $total);

        $invoice = [
            'customer_id' => Customer::factory()->create()->id,
            'date' => date('Y-m-d'),
            'due_date' => date('Y-m-d'),
            'number' => 'INV-'.$this->faker->numberBetween(1, 1000),
            'reference' => $this->faker->word,
            'discount' => $discount,
            'sub_total' => $sub_total,
            'total' => $grand_total,
            'terms_and_conditions' => $this->faker->sentence(3),
            'invoice_item' => json_encode($invoice_items, true),
        ];

        $response = $this->post('/api/invoices/store', $invoice);

        $response->assertStatus(200);
    }

    /**
     * Test show invoice.
     *
     * @return void
     */
    public function test_show_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get('/api/invoices/show/'.$invoice->id);
        $response->assertStatus(200);
    }

    /**
     * Test delete invoice.
     *
     * @return void
     */
    public function test_delete_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->delete(route('invoices.destroy', [
            'id' => $invoice->id
        ]));

        $response->assertStatus(200);
    }
}