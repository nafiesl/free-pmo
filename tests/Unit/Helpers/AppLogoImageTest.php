<?php

namespace Tests\Unit\Helpers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppLogoImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function app_logo_path_function_returns_correct_logo_image_path_based_on_agency_logo_path_setting()
    {
        \DB::table('site_options')->insert([
            'key'   => 'agency_logo_path',
            'value' => 'icon_user_1.png',
        ]);

        $this->assertEquals(asset('storage/assets/imgs/icon_user_1.png'), app_logo_path());
    }

    /** @test */
    public function app_logo_path_function_returns_default_logo_image_path_if_no_image_logo_path_setting()
    {
        $this->assertEquals(asset('assets/imgs/default-logo.png'), app_logo_path());
    }

    /** @test */
    public function app_logo_image_function_returns_default_logo_image_element_if_no_agency_logo_path_setting()
    {
        $logoString = '<img';
        $logoString .= ' src="'.asset('assets/imgs/default-logo.png').'"';
        $logoString .= ' alt="Logo Laravel">';

        $this->assertEquals($logoString, app_logo_image());
    }

    /** @test */
    public function app_logo_image_function_returns_correct_logo_image_elemet_based_on_agency_logo_path_setting()
    {
        \DB::table('site_options')->insert([
            'key'   => 'agency_logo_path',
            'value' => 'icon_user_1.png',
        ]);

        $logoString = '<img';
        $logoString .= ' src="'.asset('storage/assets/imgs/icon_user_1.png').'"';
        $logoString .= ' alt="Logo Laravel">';

        $this->assertEquals($logoString, app_logo_image());
    }

    /** @test */
    public function app_logo_image_function_has_overrideable_attributes()
    {
        \DB::table('site_options')->insert([
            'key'   => 'agency_name',
            'value' => 'My Agency Name',
        ]);

        $logoString = '<img';
        $logoString .= ' src="'.asset('assets/imgs/default-logo.png').'"';
        $logoString .= ' class="123"';
        $logoString .= ' style="display: inline"';
        $logoString .= ' alt="Logo My Agency Name">';

        $overrides = [
            'class' => '123',
            'style' => 'display: inline',
        ];
        $this->assertEquals($logoString, app_logo_image($overrides));
    }

    /** @test */
    public function app_logo_image_function_returns_default_logo_image_if_agency_logo_file_doesnt_exists()
    {
        \DB::table('site_options')->insert([
            'key'   => 'agency_logo_path',
            'value' => 'agency_logo.jpg',
        ]);

        $logoString = '<img';
        $logoString .= ' src="'.asset('assets/imgs/default-logo.png').'"';
        $logoString .= ' alt="Logo Laravel">';

        $this->assertEquals($logoString, app_logo_image());
    }
}
