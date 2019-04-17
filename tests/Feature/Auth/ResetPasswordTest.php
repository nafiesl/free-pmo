<?php

namespace Tests\Feature\Auth;

use Notification;
use Tests\TestCase;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_reset_password_by_their_email()
    {
        Notification::fake();

        $user = factory(User::class)->create(['email' => 'testing@app.dev']);

        $this->notSeeInDatabase('password_resets', [
            'email' => 'testing@app.dev',
        ]);

        // Reset Request
        $this->visit('password/reset');
        $this->see(trans('auth.reset_password'));
        $this->type('testing@app.dev', 'email');
        $this->press(trans('auth.send_reset_password_link'));

        $this->seePageIs('password/reset');
        $this->see(trans('passwords.sent'));
        $this->seeInDatabase('password_resets', [
            'email' => 'testing@app.dev',
        ]);

        Notification::assertSentTo(
            $user,
            'Illuminate\Auth\Notifications\ResetPassword',
            function ($notification, $channels) use ($user) {
                $userPasswordReset = \DB::table('password_resets')
                    ->where('email', $user->email)->first();

                return password_verify($notification->token, $userPasswordReset->token);
            }
        );
    }
}
