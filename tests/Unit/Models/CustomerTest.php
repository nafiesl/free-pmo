<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class CustomerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_name_attribute()
    {
        $customer = factory(Customer::class)->create(['name' => 'Customer 1 name']);
        $this->assertEquals('Customer 1 name', $customer->name);
    }
}
