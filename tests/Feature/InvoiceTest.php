<?php

namespace Tests\Feature;

use App\Models\Invoice\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
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
        $response = $this->getJson(route('invoices.search'), [
            's' => Invoice::get()->random()->id
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
}