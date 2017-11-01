<?php

namespace Tests\Unit\Models;

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Customer;
use App\Entities\Projects\Project;
use Illuminate\Support\Collection;
use Tests\TestCase as TestCase;

class CustomerTest extends TestCase
{
    /** @test */
    public function a_customer_has_an_owner()
    {
        $agency   = factory(Agency::class)->create();
        $customer = factory(Customer::class)->create(['owner_id' => $agency->id]);

        $this->assertTrue($customer->owner instanceof Agency);
        $this->assertEquals($customer->owner->id, $agency->id);
    }

    /** @test */
    public function a_customer_has_many_projects()
    {
        $customer = factory(Customer::class)->create();
        $project  = factory(Project::class)->create(['customer_id' => $customer->id]);

        $this->assertTrue($customer->projects instanceof Collection);
        $this->assertTrue($customer->projects->first() instanceof Project);
    }

    /** @test */
    public function a_customer_has_name_link_method()
    {
        $customer = factory(Customer::class)->make();
        $this->assertEquals(
            link_to_route('customers.show', $customer->name, [$customer->id], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $customer->name, 'type' => trans('customer.customer')]
                ),
            ]), $customer->nameLink()
        );
    }
}
