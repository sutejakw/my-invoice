<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\InvoiceItem\InvoiceItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceItemTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * Test delete invoice item.
     *
     * @return void
     */
    public function test_delete_invoice_item(): void
    {
        $invoice_item = InvoiceItem::factory()->create();

        $response = $this->delete(route('invoice-items.delete', [
            'id' => $invoice_item->id,
            'invoice_id' => $invoice_item->invoice_id,
        ]));

        $response->assertStatus(200);
    }
}
