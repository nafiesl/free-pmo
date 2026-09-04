<?php

namespace Tests\Feature\Api;

use App\Entities\Partners\Customer;
use App\Entities\Partners\Vendor;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageSubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_list_subscriptions()
    {
        $user = $this->createUser('admin');
        factory(Subscription::class)->create();

        $this->getJson(route('api.subscriptions.index'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function admin_can_show_subscription()
    {
        $user = $this->createUser('admin');
        $subscription = factory(Subscription::class)->create();

        $this->getJson(route('api.subscriptions.show', $subscription), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['id' => $subscription->id]);
    }

    /** @test */
    public function admin_can_create_subscription()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $vendor = factory(Vendor::class)->create();

        $this->postJson(route('api.subscriptions.store'), [
            'name' => 'www.example.com',
            'price' => 125000,
            'start_date' => '2026-01-01',
            'due_date' => '2027-01-01',
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'type_id' => 1,
            'notes' => 'Domain subscription',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('subscription.created')]);
        $this->seeInDatabase('subscriptions', ['name' => 'www.example.com']);
    }

    /** @test */
    public function subscription_customer_id_from_project()
    {
        $user = $this->createUser('admin');
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);
        $vendor = factory(Vendor::class)->create();

        $this->postJson(route('api.subscriptions.store'), [
            'name' => 'www.example.com',
            'price' => 125000,
            'start_date' => '2026-01-01',
            'due_date' => '2027-01-01',
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'type_id' => 1,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeInDatabase('subscriptions', [
            'name' => 'www.example.com',
            'customer_id' => $customer->id,
        ]);
    }

    /** @test */
    public function admin_can_update_subscription()
    {
        $user = $this->createUser('admin');
        $subscription = factory(Subscription::class)->create(['name' => 'Old Name']);

        $this->patchJson(route('api.subscriptions.update', $subscription), [
            'name' => 'Updated Name',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('subscription.updated')]);
        $this->seeInDatabase('subscriptions', ['id' => $subscription->id, 'name' => 'Updated Name']);
    }

    /** @test */
    public function admin_can_delete_subscription()
    {
        $user = $this->createUser('admin');
        $subscription = factory(Subscription::class)->create();

        $this->deleteJson(route('api.subscriptions.destroy', $subscription), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('subscription.deleted')]);
        $this->dontSeeInDatabase('subscriptions', ['id' => $subscription->id]);
    }

    /** @test */
    public function worker_cannot_create_subscription()
    {
        $user = $this->createUser('worker');
        $project = factory(Project::class)->create();
        $vendor = factory(Vendor::class)->create();

        $this->postJson(route('api.subscriptions.store'), [
            'name' => 'www.example.com',
            'price' => 125000,
            'start_date' => '2026-01-01',
            'due_date' => '2027-01-01',
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'type_id' => 1,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_subscriptions()
    {
        $this->getJson(route('api.subscriptions.index'));

        $this->seeStatusCode(401);
    }

    /** @test */
    public function admin_can_set_subscription_inactive()
    {
        $user = $this->createUser('admin');
        $subscription = factory(Subscription::class)->create(['status_id' => 1]);

        $this->patchJson(route('api.subscriptions.update', $subscription), [
            'status_id' => 0,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeInDatabase('subscriptions', ['id' => $subscription->id, 'status_id' => 0]);
    }

    /** @test */
    public function admin_can_set_subscription_active()
    {
        $user = $this->createUser('admin');
        $subscription = factory(Subscription::class)->create(['status_id' => 0]);

        $this->patchJson(route('api.subscriptions.update', $subscription), [
            'status_id' => 1,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeInDatabase('subscriptions', ['id' => $subscription->id, 'status_id' => 1]);
    }

    /** @test */
    public function admin_can_update_subscription_without_status_id()
    {
        $user = $this->createUser('admin');
        $subscription = factory(Subscription::class)->create(['status_id' => 1, 'due_date' => '2027-01-01']);

        $this->patchJson(route('api.subscriptions.update', $subscription), [
            'due_date' => '2028-01-01',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeInDatabase('subscriptions', [
            'id' => $subscription->id,
            'due_date' => '2028-01-01',
            'status_id' => 1,
        ]);
    }

    /** @test */
    public function worker_cannot_update_subscription_status()
    {
        $user = $this->createUser('worker');
        $subscription = factory(Subscription::class)->create(['status_id' => 1]);

        $this->patchJson(route('api.subscriptions.update', $subscription), [
            'status_id' => 0,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }
}
