<?php

namespace Tests\Unit\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Option;
use Tests\TestCase;

class SiteOptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function option_can_be_set()
    {
        Option::set('testing_key', 'testing_value');

        $this->seeInDatabase('site_options', [
            'key'   => 'testing_key',
            'value' => 'testing_value',
        ]);
    }

    /** @test */
    public function option_value_null_must_be_converted_to_empty_string()
    {
        Option::set('testing_key', null);

        $this->seeInDatabase('site_options', [
            'key'   => 'testing_key',
            'value' => '',
        ]);
    }

    /** @test */
    public function option_can_be_get()
    {
        \DB::table('site_options')->insert([
            'key'   => 'testing_key',
            'value' => 'testing_value',
        ]);

        $this->assertEquals('testing_value', Option::get('testing_key'));
    }

    /** @test */
    public function option_can_has_default_value_if_value_not_exists()
    {
        $this->assertEquals('testing_value', Option::get('testing_key', 'testing_value'));
    }
}
