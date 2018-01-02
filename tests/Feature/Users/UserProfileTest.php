<?php

namespace Tests\Feature\Users;

use Tests\TestCase;

/**
 * User Profile Feature Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
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
            'lang'  => 'en', // en, id
        ]);

        $this->see(trans('auth.profile_updated'));
        $this->seePageIs(route('users.profile.show'));

        $this->seeInDatabase('users', [
            'id'    => $user->id,
            'name'  => 'Nama Saya',
            'email' => 'me@domain.com',
            'lang'  => 'en',
        ]);
    }
}
