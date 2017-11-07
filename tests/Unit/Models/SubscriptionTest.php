<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Tests\TestCase as TestCase;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function it_has_project_relation()
    {
        $subscription = factory(Subscription::class)->create();
        $this->assertInstanceOf(Project::class, $subscription->project);
    }

    /** @test */
    public function it_has_customer_relation()
    {
        $subscription = factory(Subscription::class)->create();
        $this->assertInstanceOf(Customer::class, $subscription->customer);
    }

    /** @test */
    public function it_has_vendor_relation()
    {
        $subscription = factory(Subscription::class)->create();
        $this->assertInstanceOf(Vendor::class, $subscription->vendor);
    }

    /** @test */
    public function a_subscription_has_type_attribute()
    {
        $subscription = factory(Subscription::class)->create();

        $this->assertEquals(1, $subscription->type_id);
        $this->assertEquals(trans('subscription.types.domain'), $subscription->type);

        $subscription = factory(Subscription::class)->create(['type_id' => 2]);

        $this->assertEquals(2, $subscription->type_id);
        $this->assertEquals(trans('subscription.types.hosting'), $subscription->type);
    }
}
