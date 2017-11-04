<?php

namespace Tests\Feature\Auth;

use App\Entities\Users\User;
use Tests\TestCase;

class MemberLoginTest extends TestCase
{
    /** @test */
    public function user_can_login_and_logout()
    {
        $user = factory(User::class)->create(['name' => 'Nama Member', 'email' => 'email@mail.com']);

        $this->visit(route('auth.login'));

        $this->submitForm(trans('auth.login'), [
            'email'    => 'email@mail.com',
            'password' => 'member',
        ]);

        $this->seePageIs(route('home'));
        $this->see(trans('auth.welcome', ['name' => $user->name]));

        $this->click(trans('auth.logout'));

        $this->seePageIs(route('auth.login'));
        $this->see(trans('auth.logged_out'));
    }

    /** @test */
    public function member_invalid_login()
    {
        $this->visit(route('auth.login'));
        $this->type('email@mail.com', 'email');
        $this->type('password.112', 'password');
        $this->press(trans('auth.login'));
        $this->seePageIs(route('auth.login'));
        $this->see(trans('auth.failed'));
    }
}
