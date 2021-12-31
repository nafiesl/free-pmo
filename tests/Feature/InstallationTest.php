<?php

namespace Tests\Feature;

use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Installation Feature Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class InstallationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_cannot_visit_install_page_if_user_already_exists_in_database()
    {
        factory(User::class)->create(['email' => 'member@app.dev']);
        $this->visit(route('app.install'));
        $this->seePageIs(route('auth.login'));
    }

    /** @test */
    public function application_install_form_validation()
    {
        $this->visit(route('app.install'));

        $this->seePageIs(route('app.install'));

        $this->submitForm(__('app_install.button'), [
            'name' => 'Nama Member',
            'email' => 'email',
            'password' => 'password',
            'password_confirmation' => 'password..',
        ]);

        $this->seePageIs(route('app.install'));
    }

    /** @test */
    public function application_install_successfully()
    {
        $this->visit(route('app.install'));
        $this->seePageIs(route('app.install'));

        $this->submitForm(__('app_install.button'), [
            'agency_name' => 'Nama Agensi',
            'agency_website' => 'https://example.com',
            'name' => 'Nama Admin',
            'email' => 'email@mail.com',
            'password' => 'password.111',
            'password_confirmation' => 'password.111',
        ]);

        $this->seePageIs(route('home'));

        $this->see(__('auth.welcome', ['name' => 'Nama Admin']));

        $newAdmin = User::where('email', 'email@mail.com')->first();
        $this->assertEquals('Nama Admin', $newAdmin->name);
        $this->assertTrue($newAdmin->hasRole('admin'));
        $this->assertTrue($newAdmin->hasRole('worker'));

        $this->seeInDatabase('users', [
            'name' => 'Nama Admin',
            'email' => 'email@mail.com',
        ]);

        $this->seeInDatabase('site_options', [
            'key' => 'agency_name',
            'value' => 'Nama Agensi',
        ]);

        $this->seeInDatabase('site_options', [
            'key' => 'agency_website',
            'value' => 'https://example.com',
        ]);

        $this->seeInDatabase('site_options', [
            'key' => 'agency_email',
            'value' => 'email@mail.com',
        ]);
    }
}
