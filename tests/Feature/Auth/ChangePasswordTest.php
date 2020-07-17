<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

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
            app('hash')->check('secret', $user->password),
            'The password shouldn\'t changed!'
        );

        $this->submitForm(trans('auth.change_password'), [
            'old_password'          => 'secret',
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
