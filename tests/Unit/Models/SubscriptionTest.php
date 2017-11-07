<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Carbon\Carbon;
use Tests\TestCase as TestCase;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function it_has_name_link_method()
    {
        $subscription = factory(Subscription::class)->create();

        $this->assertEquals(
            link_to_route('subscriptions.show', $subscription->name, [$subscription->id], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $subscription->name, 'type' => trans('subscription.subscription')]
                ),
            ]), $subscription->nameLink()
        );
    }

    /** @test */
    public function it_has_near_of_due_date_method()
    {
        $next3Months = Carbon::now()->addMonths(2)->format('Y-m-d');
        $subscription = factory(Subscription::class)->make(['due_date' => $next3Months]);

        $this->assertFalse($subscription->nearOfDueDate());

        $next1Months = Carbon::now()->addMonth()->format('Y-m-d');
        $subscription = factory(Subscription::class)->make(['due_date' => $next1Months]);

        $this->assertTrue($subscription->nearOfDueDate());
    }

    /** @test */
    public function it_has_near_of_due_date_sign_method()
    {
        // Due date within next 3 months
        $next3Months = Carbon::now()->addMonths(2)->format('Y-m-d');
        $subscription = factory(Subscription::class)->make(['due_date' => $next3Months]);

        $this->assertEquals('', $subscription->nearOfDueDateSign());

        // Due date within next month
        $next1Months = Carbon::now()->addMonth()->format('Y-m-d');
        $subscription = factory(Subscription::class)->make(['due_date' => $next1Months]);

        $this->assertEquals(
            '<i class="fa fa-exclamation-circle" style="color: red"></i>',
            $subscription->nearOfDueDateSign()
        );
    }

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
