<?php

namespace Tests\Feature\Auth;

use App\Entities\Users\User;
use Tests\TestCase;

class MemberRegistrationTest extends TestCase
{
    /** @test */
    public function registration_validation()
    {
        factory(User::class)->create(['email' => 'member@app.dev']);

        $this->visit(route('auth.register'));

        $this->submitForm(trans('auth.register'), [
            'name'                  => '',
            'email'                 => 'member@app.dev',
            'password'              => '',
            'password_confirmation' => '',
        ]);

        $this->seePageIs(route('auth.register'));
        $this->see('Nama harus diisi.');
        $this->see('Email ini sudah terdaftar.');
        $this->see('Password harus diisi.');
        $this->see('Konfirmasi password harus diisi.');

        $this->submitForm(trans('auth.register'), [
            'name'                  => 'Nama Member',
            'email'                 => 'email',
            'password'              => 'password',
            'password_confirmation' => 'password..',
        ]);

        $this->seePageIs(route('auth.register'));
        $this->see('Email tidak valid.');
        $this->see('Konfirmasi password tidak sesuai.');
    }

    /** @test */
    public function member_register_successfully()
    {
        $this->visit(route('auth.register'));
        $this->submitForm(trans('auth.register'), [
            'name'                  => 'Nama Member',
            'email'                 => 'email@mail.com',
            'password'              => 'password.111',
            'password_confirmation' => 'password.111',
        ]);

        $this->seePageIs(route('home'));

        $this->see(trans('auth.welcome', ['name' => 'Nama Member']));

        $this->seeInDatabase('users', [
            'name'  => 'Nama Member',
            'email' => 'email@mail.com',
        ]);
    }
}
