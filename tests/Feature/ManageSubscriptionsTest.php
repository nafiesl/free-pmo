<?php

namespace Tests\Feature;

use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageSubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_entry_subscription()
    {
        $user = $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();
        $project = factory(Project::class)->create();

        $this->visit(route('subscriptions.index'));
        $this->click(__('subscription.create'));

        // Fill Form
        $this->submitForm(__('subscription.create'), [
            'name' => 'www.domain.com',
            'price' => 100000,
            'start_date' => '2015-05-02',
            'due_date' => '2016-05-02',
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'type_id' => 1,
            'notes' => 'epp_code:EPPCODE',
        ]);

        $this->see(__('subscription.created'));
        $this->seePageIs(route('subscriptions.index'));

        $this->seeInDatabase('subscriptions', [
            'name' => 'www.domain.com',
            'price' => 100000,
            'start_date' => '2015-05-02',
            'due_date' => '2016-05-02',
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'type_id' => 1,
            'notes' => 'epp_code:EPPCODE',
        ]);
    }

    /** @test */
    public function admin_can_edit_subscription_data()
    {
        $user = $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();
        $project = factory(Project::class)->create();

        $subscription = factory(Subscription::class)->create(['project_id' => $project->id]);

        $this->visit(route('subscriptions.edit', $subscription->id));

        // Fill Form
        $this->submitForm(__('subscription.update'), [
            'start_date' => '2015-05-02',
            'due_date' => '2016-05-02',
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'type_id' => 1,
            'status_id' => 1,
            'notes' => 'epp_code:EPPCODE1',
        ]);

        $this->seePageIs(route('subscriptions.edit', $subscription->id));
        $this->see(__('subscription.updated'));

        $this->seeInDatabase('subscriptions', [
            'start_date' => '2015-05-02',
            'due_date' => '2016-05-02',
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'type_id' => 1,
            'status_id' => 1,
            'notes' => 'epp_code:EPPCODE1',
        ]);
    }

    /** @test */
    public function admin_can_delete_a_subscription()
    {
        $user = $this->adminUserSigningIn();
        $subscription = factory(Subscription::class)->create();

        $this->visit(route('subscriptions.edit', $subscription->id));
        $this->click(__('subscription.delete'));

        $this->press(__('app.delete_confirm_button'));

        $this->seePageIs(route('subscriptions.index'));
        $this->see(__('subscription.deleted'));

        $this->dontSeeInDatabase('subscriptions', ['id' => $subscription->id]);
    }

    /** @test */
    public function admin_can_see_a_subscription()
    {
        $user = $this->adminUserSigningIn();
        $subscription = factory(Subscription::class)->create();

        $this->visit(route('subscriptions.show', $subscription->id));

        $this->see($subscription->name);
        $this->see(format_money($subscription->price));
        $this->see(date_id($subscription->start_date));
        $this->see(date_id($subscription->due_date));
    }
}
