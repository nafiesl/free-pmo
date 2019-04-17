<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Site Options Feature Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class SiteOptionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_user_can_visit_site_options_page()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('site-options.page-1'));
        $this->seePageIs(route('site-options.page-1'));
    }

    /** @test */
    public function admin_user_can_update_money_sign_data()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('site-options.page-1'));

        $this->submitForm(trans('app.update'), [
            'money_sign'         => '$',
            'money_sign_in_word' => 'Dollars',
        ]);

        $this->see(trans('option.updated'));
        $this->visit(route('site-options.page-1'));

        $this->seeInDatabase('site_options', [
            'key'   => 'money_sign',
            'value' => '$',
        ]);

        $this->seeInDatabase('site_options', [
            'key'   => 'money_sign_in_word',
            'value' => 'Dollars',
        ]);
    }
}
