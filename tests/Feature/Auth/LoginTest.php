<?php

namespace Tests\Feature\Auth;

use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_and_logout()
    {
        $user = factory(User::class)->create(['name' => 'Nama Member', 'email' => 'email@mail.com']);

        $this->visit(route('auth.login'));

        $this->submitForm(__('auth.login'), [
            'email' => 'email@mail.com',
            'password' => 'secret',
        ]);

        $this->see(__('auth.welcome', ['name' => $user->name]));
        $this->seePageIs(route('home'));
        $this->seeIsAuthenticated();

        $this->click(__('auth.logout'));

        $this->seePageIs(route('auth.login'));
        $this->see(__('auth.logged_out'));
    }

    /** @test */
    public function member_invalid_login()
    {
        $this->visit(route('auth.login'));

        $this->submitForm(__('auth.login'), [
            'email' => 'email@mail.com',
            'password' => 'member',
        ]);

        $this->seePageIs(route('auth.login'));
        $this->dontSeeIsAuthenticated();
    }
}
