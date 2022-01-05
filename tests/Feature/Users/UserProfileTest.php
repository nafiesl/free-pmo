<?php

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * User Profile Feature Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class UserProfileTest extends TestCase
{
    use RefreshDatabase;

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

        $this->submitForm(__('auth.update_profile'), [
            'name' => 'Nama Saya',
            'email' => 'me@domain.com',
            'lang' => 'en', // en, id, de
        ]);

        $this->see(__('auth.profile_updated'));
        $this->seePageIs(route('users.profile.show'));

        $this->seeInDatabase('users', [
            'id' => $user->id,
            'name' => 'Nama Saya',
            'email' => 'me@domain.com',
            'lang' => 'en',
        ]);
    }

    /** @test */
    public function user_get_locale_bases_on_their_lang_profile_value()
    {
        $user = $this->userSigningIn(['lang' => 'en']);
        $this->visit(route('home'));

        $this->assertEquals('en', app()->getLocale());

        $user = $this->userSigningIn(['lang' => 'id']);
        $this->visit(route('home'));

        $this->assertEquals('id', app()->getLocale());
    }

    /** @test */
    public function user_can_switch_lang_from_sidebar()
    {
        $user = $this->userSigningIn(['lang' => 'id']);

        $this->visit('/');

        $this->submitForm('switch_lang_en', ['lang' => 'en']);

        $this->assertEquals('en', app()->getLocale());
        $this->assertEquals('en', $user->fresh()->lang);

        $this->submitForm('switch_lang_id', ['lang' => 'id']);

        $this->assertEquals('id', app()->getLocale());
        $this->assertEquals('id', $user->fresh()->lang);

        $this->submitForm('switch_lang_id', ['lang' => 'de']);

        $this->assertEquals('de', app()->getLocale());
        $this->assertEquals('de', $user->fresh()->lang);
    }
}
