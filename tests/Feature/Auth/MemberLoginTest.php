<?php

namespace Tests\Feature\Auth;

use App\Entities\Users\User;
use Tests\TestCase;

class MemberLoginTest extends TestCase
{
    /** @test */
    public function member_register_and_login_successfully()
    {
        $user = factory(User::class)->create(['name' => 'Nama Member', 'email' => 'email@mail.com']);
        $user->assignRole('customer');

        $this->visit(route('auth.login'));
        $this->type('email@mail.com','email');
        $this->type('member','password');
        $this->press(trans('auth.login'));
        $this->seePageIs(route('home'));
        $this->see('Selamat datang kembali Nama Member.');
        $this->click(trans('auth.logout'));
        $this->seePageIs(route('auth.login'));
        $this->see('Anda telah logout.');
    }

    /** @test */
    public function member_invalid_login()
    {
        $this->visit(route('auth.login'));
        $this->type('email@mail.com','email');
        $this->type('password.112','password');
        $this->press(trans('auth.login'));
        $this->seePageIs(route('auth.login'));
        $this->see('Mohon maaf, anda tidak dapat login');
    }
}
