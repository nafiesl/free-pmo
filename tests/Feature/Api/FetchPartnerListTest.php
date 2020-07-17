<?php

namespace Tests\Feature\Api;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchPartnerListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_fetch_customer_listing()
    {
        $user = $this->createUser('admin');
        $customer = factory(Customer::class)->create();

        $this->postJson(route('api.customers.index'), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeJson([
            $customer->id => $customer->name,
        ]);
    }

    /** @test */
    public function user_can_fetch_vendor_listing()
    {
        $user = $this->createUser('admin');
        $vendor = factory(Vendor::class)->create();

        $this->postJson(route('api.vendors.index'), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeJson([
            $vendor->id => $vendor->name,
        ]);
    }
}
