<?php

namespace Tests\Feature\Auth;

use App\Entities\Users\User;
use Tests\TestCase;

class MemberChangePasswordTest extends TestCase
{
    /** @test */
    public function member_can_change_password()
    {
        $user = factory(User::class)->create();
        $user->assignRole('customer');
        $this->actingAs($user);

        $this->visit(route('home'));
        $this->click(trans('auth.change_password'));

        $this->submitForm(trans('auth.change_password'), [
            'old_password' => 'member1',
            'password' => 'rahasia',
            'password_confirmation' => 'rahasia',
        ]);
        $this->see(trans('auth.old_password_failed'));
        $this->assertTrue(
            app('hash')->check('member', $user->password),
            'The password shouldn\'t changed!'
        );

        $this->submitForm(trans('auth.change_password'), [
            'old_password' => 'member',
            'password' => 'rahasia',
            'password_confirmation' => 'rahasia',
        ]);
        $this->see(trans('auth.password_changed'));

        $this->assertTrue(
            app('hash')->check('rahasia', $user->password),
            'The password should changed!'
        );
    }
}
