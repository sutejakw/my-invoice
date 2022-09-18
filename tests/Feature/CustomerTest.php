<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * Test get all customer data.
     *
     * @return void
     */
    public function test_get_all_customer(): void
    {
        $response = $this->getJson(route('customers.index'));
        $response->assertStatus(200);
    }
}
