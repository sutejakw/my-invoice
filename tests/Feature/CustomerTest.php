<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use CreatesApplication;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

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
