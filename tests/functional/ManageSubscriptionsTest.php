<?php

use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use App\Entities\Users\User;

class ManageSubscriptionsTest extends TestCase
{
    /** @test */
    public function admin_can_entry_subscription()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $customer = factory(User::class)->create();
        $customer->assignRole('customer');

        $vendor = factory(User::class)->create();
        $vendor->assignRole('vendor');

        $this->visit('subscriptions');
        $this->seePageIs('subscriptions');
        $this->see(trans('subscription.subscriptions'));
        $this->click(trans('subscription.create'));
        $this->seePageIs('subscriptions/create');

        // Fill Form
        $this->type('www.domain.com','domain_name');
        $this->type(100000,'domain_price');
        $this->type('100000','epp_code');
        $this->type('3GB','hosting_capacity');
        $this->type(500000,'hosting_price');
        $this->type('2015-05-02','start_date');
        $this->type('2016-05-02','due_date');
        $this->select($project->id, 'project_id');
        $this->select($customer->id, 'customer_id');
        $this->select($vendor->id, 'vendor_id');
        $this->type('','remark');
        $this->press(trans('subscription.create'));

        $this->seePageIs('subscriptions');
        $this->see(trans('subscription.created'));
        $this->seeInDatabase('subscriptions', [
            'project_id' => $project->id,
            'domain_price' => 100000,
            'status_id' => 1,
            'start_date' => '2015-05-02',
            'due_date' => '2016-05-02',
            'customer_id' => $customer->id,
            'vendor_id' => $vendor->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_subscription_data()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $customer = factory(User::class)->create();
        $customer->assignRole('customer');

        $vendor = factory(User::class)->create();
        $vendor->assignRole('vendor');

        $subscription = factory(Subscription::class)->create(['customer_id' => $customer->id, 'project_id' => $project->id]);

        $this->visit('subscriptions/' . $subscription->id . '/edit');
        $this->seePageIs('subscriptions/' . $subscription->id . '/edit');

        // Fill Form
        $this->type($eppCode = str_random(10),'epp_code');
        $this->type('4GB','hosting_capacity');
        $this->type(500000,'hosting_price');
        $this->type('2015-05-02','start_date');
        $this->type('2016-05-02','due_date');
        $this->select($project->id, 'project_id');
        $this->select($customer->id, 'customer_id');
        $this->select($vendor->id, 'vendor_id');
        $this->select(1,'status_id');
        $this->press(trans('subscription.update'));

        $this->seePageIs('subscriptions/' . $subscription->id . '/edit');
        $this->see(trans('subscription.updated'));
        $this->seeInDatabase('subscriptions', [
            'epp_code' => $eppCode,
            'customer_id' => $customer->id,
            'project_id' => $project->id,
            'status_id' => 1,
            'hosting_capacity' => '4GB',
            'hosting_price' => '500000',
            'start_date' => '2015-05-02',
            'due_date' => '2016-05-02',
            'customer_id' => $customer->id,
            'vendor_id' => $vendor->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_subscription()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $subscription = factory(Subscription::class)->create();

        $this->visit('/subscriptions');
        $this->click(trans('app.edit'));
        $this->click(trans('subscription.delete'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('subscriptions');
        $this->see(trans('subscription.deleted'));
    }

    /** @test */
    public function admin_can_see_a_subscription()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $subscription = factory(Subscription::class)->create();

        $this->visit('/subscriptions');
        $this->click(trans('app.show'));
        $this->seePageIs('subscriptions/' . $subscription->id);
        $this->see(trans('subscription.show'));
        $this->see($subscription->domain_name);
        $this->see(formatRp($subscription->domain_price));
        $this->see($subscription->hosting_capacity);
        $this->see(formatRp($subscription->hosting_price));
        $this->see(dateId($subscription->start_date));
        $this->see(dateId($subscription->due_date));
    }

    // /** @test */
    // public function admin_can_see_all_subscriptions()
    // {
    //     $user = factory(User::class)->create();
    //     $user->assignRole('admin');
    //     $this->actingAs($user);

    //     $subscriptions = factory(Subscription::class, 5)->create();
    //     $this->assertEquals(5, $subscriptions->count());

    //     $this->visit('/subscriptions');
    //     $this->see($subscriptions[4]->domain_name);
    //     $this->see($subscriptions[4]->hosting_capacity);
    //     $this->see(dateId($subscriptions[4]->start_date));
    //     $this->see(dateId($subscriptions[4]->due_date));
    //     $this->see(formatRp($subscriptions[4]->domain_price + $subscriptions[4]->hosting_price));

    // }
}
