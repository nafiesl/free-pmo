<?php

use App\Entities\Users\User;

class MemberChangePasswordTest extends TestCase
{
    /** @test */
    public function member_can_change_password()
    {
        $user = factory(User::class)->create();
        $user->assignRole('customer');
        $this->actingAs($user);

        $this->visit(route('home'));
        $this->seePageIs(route('home'));
        $this->click(trans('auth.change_password'));

        $this->type('member1','old_password');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Ganti Password');
        $this->see('Password lama tidak cocok');

        $this->type('member','old_password');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Ganti Password');
        $this->see('Password berhasil diubah');

        // Logout and login using new Password
        $this->click('Keluar');
        $this->seePageIs(route('auth.login'));
        $this->type($user->username,'username');
        $this->type('rahasia','password');
        $this->press('Login');
        $this->seePageIs(route('home'));
    }
}
