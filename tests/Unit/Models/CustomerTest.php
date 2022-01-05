<?php

namespace Tests\Unit\Models;

use App\Entities\Invoices\Invoice;
use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_customer_has_many_projects()
    {
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Collection::class, $customer->projects);
        $this->assertInstanceOf(Project::class, $customer->projects->first());
    }

    /** @test */
    public function a_customer_has_many_payments_relation()
    {
        $customer = factory(Customer::class)->create();
        $payment = factory(Payment::class)->create([
            'partner_id'   => $customer->id,
            'partner_type' => 'App\Entities\Partners\Customer',
        ]);

        $this->assertInstanceOf(Collection::class, $customer->payments);
        $this->assertInstanceOf(Payment::class, $customer->payments->first());
    }

    /** @test */
    public function a_customer_has_many_subscriptions_relation()
    {
        $customer = factory(Customer::class)->create();
        $subscription = factory(Subscription::class)->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Collection::class, $customer->subscriptions);
        $this->assertInstanceOf(Subscription::class, $customer->subscriptions->first());
    }

    /** @test */
    public function a_customer_has_many_invoices_through_projects_relation()
    {
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);
        $invoice = factory(Invoice::class)->create(['project_id' => $project->id]);

        $this->assertInstanceOf(Collection::class, $customer->invoices);
        $this->assertInstanceOf(Invoice::class, $customer->invoices->first());
    }

    /** @test */
    public function a_customer_has_name_link_method()
    {
        $customer = factory(Customer::class)->create();

        $this->assertEquals(
            link_to_route('customers.show', $customer->name, [$customer->id], [
                'title' => __(
                    'app.show_detail_title',
                    ['name' => $customer->name, 'type' => __('customer.customer')]
                ),
            ]), $customer->nameLink()
        );
    }

    /** @test */
    public function a_customer_has_status_attribute()
    {
        $customer = factory(Customer::class)->make(['is_active' => 1]);

        $this->assertEquals(1, $customer->is_active);
        $this->assertEquals(__('app.active'), $customer->status);

        $customer = factory(Customer::class)->make(['is_active' => 0]);

        $this->assertEquals(0, $customer->is_active);
        $this->assertEquals(__('app.in_active'), $customer->status);
    }

    /** @test */
    public function a_customer_has_status_label_attribute()
    {
        $customer = factory(Customer::class)->make(['is_active' => 1]);

        $this->assertEquals(1, $customer->is_active);
        $activeLabel = '<span class="badge" style="background-color: #337ab7">'.__('app.active').'</span>';
        $this->assertEquals($activeLabel, $customer->status_label);

        $customer = factory(Customer::class)->make(['is_active' => 0]);

        $this->assertEquals(0, $customer->is_active);
        $inActiveLabel = '<span class="badge">'.__('app.in_active').'</span>';
        $this->assertEquals($inActiveLabel, $customer->status_label);
    }
}
