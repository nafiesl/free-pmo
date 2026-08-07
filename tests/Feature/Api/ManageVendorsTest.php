<?php

namespace Tests\Feature\Api;

use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageVendorsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_list_vendors()
    {
        $user = $this->createUser('admin');
        factory(Vendor::class)->create();

        $this->getJson(route('api.vendors.list'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function admin_can_show_vendor()
    {
        $user = $this->createUser('admin');
        $vendor = factory(Vendor::class)->create();

        $this->getJson(route('api.vendors.show', $vendor), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['id' => $vendor->id]);
    }

    /** @test */
    public function admin_can_update_vendor()
    {
        $user = $this->createUser('admin');
        $vendor = factory(Vendor::class)->create(['name' => 'Old Name']);

        $this->patchJson(route('api.vendors.update', $vendor), [
            'name' => 'Updated Vendor',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('vendor.updated')]);
        $this->seeInDatabase('vendors', ['id' => $vendor->id, 'name' => 'Updated Vendor']);
    }

    /** @test */
    public function admin_can_delete_vendor()
    {
        $user = $this->createUser('admin');
        $vendor = factory(Vendor::class)->create();

        $this->deleteJson(route('api.vendors.destroy', $vendor), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('vendor.deleted')]);
        $this->dontSeeInDatabase('vendors', ['id' => $vendor->id]);
    }

    /** @test */
    public function worker_cannot_update_vendor()
    {
        $user = $this->createUser('worker');
        $vendor = factory(Vendor::class)->create();

        $this->patchJson(route('api.vendors.update', $vendor), [
            'name' => 'Updated Vendor',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_vendors()
    {
        $this->getJson(route('api.vendors.list'));

        $this->seeStatusCode(401);
    }
}
