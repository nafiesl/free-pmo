<?php

namespace Tests\Unit\Policies;

use App\Entities\Partners\Partner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase as TestCase;

class PartnerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_partner()
    {
        $user = $this->adminUserSigningIn();
        $this->assertTrue($user->can('create', new Partner));
    }

    /** @test */
    public function user_can_view_partner()
    {
        $user    = $this->adminUserSigningIn();
        $partner = factory(Partner::class)->create(['name' => 'Partner 1 name']);
        $this->assertTrue($user->can('view', $partner));
    }

    /** @test */
    public function user_can_update_partner()
    {
        $user    = $this->adminUserSigningIn();
        $partner = factory(Partner::class)->create(['name' => 'Partner 1 name']);
        $this->assertTrue($user->can('update', $partner));
    }

    /** @test */
    public function user_can_delete_partner()
    {
        $user    = $this->adminUserSigningIn();
        $partner = factory(Partner::class)->create(['name' => 'Partner 1 name']);
        $this->assertTrue($user->can('delete', $partner));
    }
}
