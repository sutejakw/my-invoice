<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test get all product data.
     *
     * @return void
     */
    public function test_get_all_product(): void
    {
        $response = $this->getJson(route('products.index'));
        $response->assertStatus(200);
    }
}
