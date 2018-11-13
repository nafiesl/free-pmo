<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChangePasswordTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function member_can_change_password()
    {
        $user = $this->adminUserSigningIn();

        $this->visit(route('home'));
        $this->click(trans('auth.change_password'));

        $this->submitForm(trans('auth.change_password'), [
            'old_password'          => 'member1',
            'password'              => 'rahasia',
            'password_confirmation' => 'rahasia',
        ]);
        $this->see(trans('auth.old_password_failed'));
        $this->assertTrue(
            app('hash')->check('member', $user->password),
            'The password shouldn\'t changed!'
        );

        $this->submitForm(trans('auth.change_password'), [
            'old_password'          => 'member',
            'password'              => 'rahasia',
            'password_confirmation' => 'rahasia',
        ]);
        $this->see(trans('auth.password_changed'));

        $this->assertTrue(
            app('hash')->check('rahasia', $user->password),
            'The password should changed!'
        );
    }
}
