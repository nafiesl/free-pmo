<?php

namespace Tests\Feature\Users;

use App\Entities\Agencies\Agency;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    /** @test */
    public function a_user_can_visit_their_profile_page()
    {
        $user = $this->userSigningIn();
        $this->visit(route('users.profile.show'));
        $this->seePageIs(route('users.profile.show'));
    }

    /** @test */
    public function a_user_can_visit_their_profile_edit_page()
    {
        $user = $this->userSigningIn();
        $this->visit(route('users.profile.edit'));
        $this->seePageIs(route('users.profile.edit'));
    }

    /** @test */
    public function a_user_can_update_their_profile()
    {
        $user = $this->userSigningIn();
        $this->visit(route('users.profile.edit'));

        $this->submitForm(trans('auth.update_profile'), [
            'name'  => 'Nama Saya',
            'email' => 'me@domain.com',
        ]);

        $this->see(trans('auth.profile_updated'));
        $this->seePageIs(route('users.profile.edit'));

        $this->seeInDatabase('users', [
            'id'    => $user->id,
            'name'  => 'Nama Saya',
            'email' => 'me@domain.com',
        ]);
    }

    /** @test */
    public function a_user_can_update_their_agency_data()
    {
        $user   = $this->userSigningIn();
        $agency = factory(Agency::class)->create(['owner_id' => $user]);
        $this->visit(route('users.profile.edit'));

        $this->submitForm(trans('agency.update'), [
            'name'    => 'Nama Agensi Saya',
            'email'   => 'nama_agensi@domain.com',
            'address' => 'Jln. Kalimantan, No. 20, Kota',
            'phone'   => '081234567890',
            'website' => 'https://example.com',
        ]);

        $this->see(trans('agency.updated'));
        $this->seePageIs(route('users.profile.edit'));

        $this->seeInDatabase('agencies', [
            'id'      => $agency->id,
            'name'    => 'Nama Agensi Saya',
            'email'   => 'nama_agensi@domain.com',
            'address' => 'Jln. Kalimantan, No. 20, Kota',
            'phone'   => '081234567890',
            'website' => 'https://example.com',
        ]);
    }
}
