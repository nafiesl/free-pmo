<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Agency Profile Feature Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class AgencyProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_user_can_visit_agency_page()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('users.agency.show'));
        $this->seePageIs(route('users.agency.show'));
    }

    /** @test */
    public function admin_user_can_update_agency_data()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('users.agency.edit'));

        $this->submitForm(__('agency.update'), [
            'name' => 'Nama Agensi Saya',
            'tagline' => 'Tagline agensi saya',
            'email' => 'nama_agensi@domain.com',
            'address' => 'Jln. Kalimantan, No. 20, Kota',
            'phone' => '081234567890',
            'city' => 'Jakarta',
            'website' => 'https://example.com',
            'tax_id' => '14.817.xxx.x-xxx.000',
        ]);

        $this->see(__('agency.updated'));
        $this->seePageIs(route('users.agency.show'));

        $this->seeInDatabase('site_options', [
            'key' => 'agency_name',
            'value' => 'Nama Agensi Saya',
        ]);
        $this->seeInDatabase('site_options', [
            'key' => 'agency_email',
            'value' => 'nama_agensi@domain.com',
        ]);
        $this->seeInDatabase('site_options', [
            'key' => 'agency_address',
            'value' => 'Jln. Kalimantan, No. 20, Kota',
        ]);
        $this->seeInDatabase('site_options', [
            'key' => 'agency_city',
            'value' => 'Jakarta',
        ]);
        $this->seeInDatabase('site_options', [
            'key' => 'agency_phone',
            'value' => '081234567890',
        ]);
        $this->seeInDatabase('site_options', [
            'key' => 'agency_website',
            'value' => 'https://example.com',
        ]);
        $this->seeInDatabase('site_options', [
            'key' => 'agency_tagline',
            'value' => 'Tagline agensi saya',
        ]);
        $this->seeInDatabase('site_options', [
            'key' => 'agency_tax_id',
            'value' => '14.817.xxx.x-xxx.000',
        ]);
    }

    /** @test */
    public function admin_user_can_update_agency_logo_image()
    {
        $user = $this->adminUserSigningIn();
        $this->visit(route('users.agency.edit'));

        $this->attach(storage_path('app/sample-image.png'), 'logo');
        $this->press(__('agency.logo_upload'));

        $this->see(__('agency.updated'));
        $this->seePageIs(route('users.agency.show'));

        $this->seeInDatabase('site_options', [
            'key' => 'agency_logo_path',
            'value' => 'sample-image.png',
        ]);

        $this->assertFileExistsThenDelete(storage_path('app/public/assets/imgs/sample-image.png'));
    }
}
