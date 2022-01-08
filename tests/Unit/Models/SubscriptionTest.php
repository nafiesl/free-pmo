<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use App\Entities\Subscriptions\Type;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_name_link_attribute()
    {
        $subscription = factory(Subscription::class)->create();

        $this->assertEquals(
            link_to_route('subscriptions.show', $subscription->name, $subscription, [
                'title' => __(
                    'app.show_detail_title',
                    ['name' => $subscription->name, 'type' => __('subscription.subscription')]
                ),
            ]), $subscription->name_link
        );
    }

    /** @test */
    public function it_has_near_of_due_date_method()
    {
        $next3Months = Carbon::now()->addMonths(3)->format('Y-m-d');
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
        $next3Months = Carbon::now()->addMonths(3)->format('Y-m-d');
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
    public function it_has_due_date_description_method()
    {
        $next3Months = Carbon::now()->addMonths(2)->format('Y-m-d');
        $subscription = factory(Subscription::class)->make(['due_date' => $next3Months]);

        $dueDateDescription = __('subscription.start_date').' : '.date_id($subscription->start_date)."\n";
        $dueDateDescription .= __('subscription.due_date').' : '.date_id($subscription->due_date);

        $this->assertEquals($dueDateDescription, $subscription->dueDateDescription());
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
        $this->assertEquals(Type::getNameById(1), $subscription->type);

        $subscription = factory(Subscription::class)->create(['type_id' => 2]);

        $this->assertEquals(2, $subscription->type_id);
        $this->assertEquals(Type::getNameById(2), $subscription->type);
    }

    /** @test */
    public function a_subscription_has_type_color_attribute()
    {
        $subscription = factory(Subscription::class)->create();

        $this->assertEquals(1, $subscription->type_id);
        $this->assertEquals(Type::getColorById(1), $subscription->type_color);

        $subscription = factory(Subscription::class)->create(['type_id' => 2]);

        $this->assertEquals(2, $subscription->type_id);
        $this->assertEquals(Type::getColorById(2), $subscription->type_color);
    }

    /** @test */
    public function a_subscription_has_type_label_attribute()
    {
        $subscription = factory(Subscription::class)->make();

        $type = Type::getNameById(1);
        $color = Type::getColorById(1);
        $label = '<span class="badge" style="background-color: '.$color.'">'.$type.'</span>';
        $this->assertEquals($label, $subscription->type_label);

        $subscription = factory(Subscription::class)->make(['type_id' => 2]);

        $type = Type::getNameById(2);
        $color = Type::getColorById(2);
        $label = '<span class="badge" style="background-color: '.$color.'">'.$type.'</span>';
        $this->assertEquals($label, $subscription->type_label);
    }
}
