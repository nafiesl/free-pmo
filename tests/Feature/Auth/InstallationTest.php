<?php

namespace Tests\Feature\Auth;

use App\Entities\Users\User;
use Tests\TestCase;

/**
 * Installation Feature Test
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class InstallationTest extends TestCase
{
    /** @test */
    public function user_cannot_visit_register_page_if_user_already_exists_in_database()
    {
        factory(User::class)->create(['email' => 'member@app.dev']);
        $this->visit(route('app.install'));
        $this->seePageIs(route('auth.login'));
    }

    /** @test */
    public function registration_validation()
    {
        $this->visit(route('app.install'));

        $this->seePageIs(route('app.install'));

        $this->submitForm(trans('auth.register'), [
            'name'                  => 'Nama Member',
            'email'                 => 'email',
            'password'              => 'password',
            'password_confirmation' => 'password..',
        ]);

        $this->seePageIs(route('app.install'));
    }

    /** @test */
    public function member_register_successfully()
    {
        $this->visit(route('app.install'));
        $this->seePageIs(route('app.install'));

        $this->submitForm(trans('auth.register'), [
            'agency_name'           => 'Nama Agensi',
            'agency_website'        => 'https://example.com',
            'name'                  => 'Nama Admin',
            'email'                 => 'email@mail.com',
            'password'              => 'password.111',
            'password_confirmation' => 'password.111',
        ]);

        $this->seePageIs(route('home'));

        $this->see(trans('auth.welcome', ['name' => 'Nama Admin']));

        $this->seeInDatabase('users', [
            'name'  => 'Nama Admin',
            'email' => 'email@mail.com',
        ]);

        $this->seeInDatabase('site_options', [
            'key'   => 'agency_name',
            'value' => 'Nama Agensi',
        ]);

        $this->seeInDatabase('site_options', [
            'key'   => 'agency_website',
            'value' => 'https://example.com',
        ]);
    }
}
