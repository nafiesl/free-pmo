<?php

use App\Entities\Users\User;

class MemberResetPasswordTest extends TestCase
{
    /** @test */
    public function member_can_reset_password_by_their_email()
    {
        $user = factory(User::class)->create();

        // Reset Request
        $this->visit(route('auth.reset-request'));
        $this->notSeeInDatabase('password_resets', [
            'email' => $user->email
        ]);
        $this->see('Reset Password');
        $this->type($user->email,'email');
        $this->press('Kirim Link Reset Password');
        $this->seePageIs(route('auth.reset-request'));
        $this->see('Kami sudah mengirim email');
        $this->seeInDatabase('password_resets', [
            'email' => $user->email
        ]);

        // Reset Action
        $resetData = DB::table('password_resets')->where('email', $user->email)->first();
        $token = $resetData->token;

        $this->visit('password/reset/' . $token);
        $this->see('Reset Password');
        $this->see('Password Baru');

        // Enter an invalid email
        $this->type('mail@mail.com','email');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Reset Password');
        $this->see('Kami tidak dapat menemukan pengguna dengan email tersebut');

        // Enter a valid email
        $this->type($user->email,'email');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Reset Password');

        $this->seePageIs(route('home'));

        $this->notSeeInDatabase('password_resets', [
            'email' => $user->email
        ]);

        // Logout and login using new Password
        $this->click('Keluar');
        $this->seePageIs(route('auth.login'));
        $this->type($user->username,'username');
        $this->type('rahasia','password');
        $this->press('Login');
        $this->seePageIs(route('home'));
    }

}
