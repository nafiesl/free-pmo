<?php

use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MemberRegistrationAndLoginTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function registration_validation()
    {
        // $user = factory(User::class)->create(['email' => 'member@app.dev']);
        // $user->assignRole('customer');

        $this->visit(route('auth.register'));
        $this->type('', 'name');
        $this->type('', 'username');
        $this->type('member@app.dev', 'email');
        $this->type('', 'password');
        $this->type('', 'password_confirmation');
        $this->press('Buat Akun Baru');
        $this->seePageIs(route('auth.register'));
        $this->see('Nama harus diisi.');
        $this->see('Username harus diisi.');
        $this->see('Email ini sudah terdaftar.');
        $this->see('Password harus diisi.');
        $this->see('Konfirmasi password harus diisi.');

        $this->type('Nama Member', 'name');
        $this->type('namamember', 'username');
        $this->type('email', 'email');
        $this->type('password', 'password');
        $this->type('password..', 'password_confirmation');
        $this->press('Buat Akun Baru');
        $this->seePageIs(route('auth.register'));
        $this->see('Email tidak valid.');
        $this->see('Konfirmasi password tidak sesuai.');
    }

    /** @test */
    public function member_register_successfully()
    {
        $this->visit(route('auth.register'));
        $this->type('Nama Member', 'name');
        $this->type('namamember', 'username');
        $this->type('email@mail.com', 'email');
        $this->type('password.111', 'password');
        $this->type('password.111', 'password_confirmation');
        $this->press('Buat Akun Baru');
        $this->seePageIs(route('home'));
        $this->see('Selamat datang Nama Member.');
    }

    /** @test */
    public function member_register_and_login_successfully()
    {
        $this->visit(route('auth.register'));
        $this->type('Nama Member', 'name');
        $this->type('namamember', 'username');
        $this->type('email@mail.com', 'email');
        $this->type('password.111', 'password');
        $this->type('password.111', 'password_confirmation');
        $this->press('Buat Akun Baru');
        $this->seePageIs(route('home'));
        $this->see('Selamat datang Nama Member.');
        $this->click('Keluar');

        $this->visit(route('auth.login'));
        $this->type('namamember','username');
        $this->type('password.111','password');
        $this->press('Login');
        $this->seePageIs(route('home'));
        $this->see('Selamat datang kembali Nama Member.');
        $this->click('Keluar');
        $this->seePageIs(route('auth.login'));
        $this->see('Anda telah logout.');
    }

    /** @test */
    public function member_invalid_login()
    {
        $this->visit(route('auth.login'));
        $this->type('namamember','username');
        $this->type('password.112','password');
        $this->press('Login');
        $this->seePageIs(route('auth.login'));
        $this->see('Mohon maaf, anda tidak dapat login');
    }
}
