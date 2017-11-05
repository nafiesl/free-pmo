<?php

namespace Tests\Feature;

use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Tests\TestCase;

class ManageSubscriptionsTest extends TestCase
{
    /** @test */
    public function admin_can_entry_subscription()
    {
        $user    = $this->adminUserSigningIn();
        $vendor  = factory(Vendor::class)->create();
        $project = factory(Project::class)->create();

        $this->visit(route('subscriptions.index'));
        $this->click(trans('subscription.create'));

        // Fill Form
        $this->submitForm(trans('subscription.create'), [
            'domain_name'      => 'www.domain.com',
            'domain_price'     => 100000,
            'epp_code'         => 'EPPCODE',
            'hosting_capacity' => '3GB',
            'hosting_price'    => 500000,
            'start_date'       => '2015-05-02',
            'due_date'         => '2016-05-02',
            'project_id'       => $project->id,
            'vendor_id'        => $vendor->id,
            'type_id'          => 1,
            'remark'           => '',
        ]);

        $this->see(trans('subscription.created'));
        $this->seePageIs(route('subscriptions.index'));

        $this->seeInDatabase('subscriptions', [
            'project_id'   => $project->id,
            'domain_price' => 100000,
            'epp_code'     => 'EPPCODE',
            'status_id'    => 1,
            'start_date'   => '2015-05-02',
            'due_date'     => '2016-05-02',
            'vendor_id'    => $vendor->id,
            'type_id'      => 1,
        ]);
    }

    /** @test */
    public function admin_can_edit_subscription_data()
    {
        $user    = $this->adminUserSigningIn();
        $vendor  = factory(Vendor::class)->create();
        $project = factory(Project::class)->create();

        $subscription = factory(Subscription::class)->create(['project_id' => $project->id]);

        $this->visit(route('subscriptions.edit', $subscription->id));

        // Fill Form
        $this->submitForm(trans('subscription.update'), [
            'epp_code'         => 'EPPCODE1',
            'hosting_capacity' => '4GB',
            'hosting_price'    => 500000,
            'start_date'       => '2015-05-02',
            'due_date'         => '2016-05-02',
            'project_id'       => $project->id,
            'vendor_id'        => $vendor->id,
            'status_id'        => 1,
        ]);

        $this->seePageIs(route('subscriptions.edit', $subscription->id));
        $this->see(trans('subscription.updated'));

        $this->seeInDatabase('subscriptions', [
            'epp_code'         => 'EPPCODE1',
            'project_id'       => $project->id,
            'status_id'        => 1,
            'hosting_capacity' => '4GB',
            'hosting_price'    => '500000',
            'start_date'       => '2015-05-02',
            'due_date'         => '2016-05-02',
            'vendor_id'        => $vendor->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_a_subscription()
    {
        $user         = $this->adminUserSigningIn();
        $subscription = factory(Subscription::class)->create();

        $this->visit(route('subscriptions.edit', $subscription->id));
        $this->click(trans('subscription.delete'));
        $this->press(trans('app.delete_confirm_button'));

        $this->seePageIs(route('subscriptions.index'));
        $this->see(trans('subscription.deleted'));

        $this->dontSeeInDatabase('subscriptions', ['id' => $subscription->id]);
    }

    /** @test */
    public function admin_can_see_a_subscription()
    {
        $user         = $this->adminUserSigningIn();
        $subscription = factory(Subscription::class)->create();

        $this->visit(route('subscriptions.show', $subscription->id));

        $this->see($subscription->domain_name);
        $this->see(formatRp($subscription->domain_price));
        $this->see($subscription->hosting_capacity);
        $this->see(formatRp($subscription->hosting_price));
        $this->see(dateId($subscription->start_date));
        $this->see(dateId($subscription->due_date));
    }
}
