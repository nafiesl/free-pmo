<?php

namespace Tests\Feature\Users;

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
        $this->seePageIs(route('users.profile.show'));

        $this->seeInDatabase('users', [
            'id'    => $user->id,
            'name'  => 'Nama Saya',
            'email' => 'me@domain.com',
        ]);
    }
    /** @test */
    public function a_user_can_visit_their_agency_page()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('users.agency.show'));
        $this->seePageIs(route('users.agency.show'));
    }

    /** @test */
    public function a_user_can_update_their_agency_data()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('users.agency.edit'));

        $this->submitForm(trans('agency.update'), [
            'name'    => 'Nama Agensi Saya',
            'email'   => 'nama_agensi@domain.com',
            'address' => 'Jln. Kalimantan, No. 20, Kota',
            'phone'   => '081234567890',
            'website' => 'https://example.com',
        ]);

        $this->see(trans('agency.updated'));
        $this->seePageIs(route('users.agency.show'));

        $this->seeInDatabase('site_options', [
            'key'   => 'agency_name',
            'value' => 'Nama Agensi Saya',
        ]);
        $this->seeInDatabase('site_options', [
            'key'   => 'agency_email',
            'value' => 'nama_agensi@domain.com',
        ]);
        $this->seeInDatabase('site_options', [
            'key'   => 'agency_address',
            'value' => 'Jln. Kalimantan, No. 20, Kota',
        ]);
        $this->seeInDatabase('site_options', [
            'key'   => 'agency_phone',
            'value' => '081234567890',
        ]);
        $this->seeInDatabase('site_options', [
            'key'   => 'agency_website',
            'value' => 'https://example.com',
        ]);
    }
}
