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
    public function user_can_fetch_customer_reference()
    {
        $user = $this->createUser('admin');
        $customer = factory(Customer::class)->create();

        $this->getJson(route('api.references.customers'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            $customer->id => $customer->name,
        ]);
    }

    /** @test */
    public function user_can_fetch_vendor_reference()
    {
        $user = $this->createUser('admin');
        $vendor = factory(Vendor::class)->create();

        $this->getJson(route('api.references.vendors'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            $vendor->id => $vendor->name,
        ]);
    }
}
