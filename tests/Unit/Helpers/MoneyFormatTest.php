<?php

namespace Tests\Unit\Helpers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Money Format Helper Unit Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class MoneyFormatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function format_money_returns_string_with_default_money_sign()
    {
        $this->assertEquals('Rp. 1.000', format_money(1000));
        $this->assertEquals('Rp. 0', format_money(0));
        $this->assertEquals('- Rp. 1.000', format_money(-1000));
    }

    /** @test */
    public function format_money_returns_string_based_on_site_option_money_sign()
    {
        \DB::table('site_options')->insert([
            'key'   => 'money_sign',
            'value' => 'USD',
        ]);

        $this->assertEquals('USD 1.000', format_money(1000));
        $this->assertEquals('USD 0', format_money(0));
        $this->assertEquals('- USD 1.000', format_money(-1000));
    }
}
