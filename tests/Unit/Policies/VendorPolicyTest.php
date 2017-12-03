<?php

namespace Tests\Unit\Policies;

use App\Entities\Partners\Vendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class VendorPolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_vendor()
    {
        $user = $this->adminUserSigningIn();
        $this->assertTrue($user->can('create', new Vendor()));
    }

    /** @test */
    public function user_can_view_vendor()
    {
        $user = $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();
        $this->assertTrue($user->can('view', $vendor));
    }

    /** @test */
    public function user_can_update_vendor()
    {
        $user = $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();
        $this->assertTrue($user->can('update', $vendor));
    }

    /** @test */
    public function user_can_delete_vendor()
    {
        $user = $this->adminUserSigningIn();
        $vendor = factory(Vendor::class)->create();
        $this->assertTrue($user->can('delete', $vendor));
    }
}
