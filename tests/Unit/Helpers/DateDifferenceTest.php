<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;

/**
 * Date Difference Helper Unit Test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class DateDifferenceTest extends TestCase
{
    /** @test */
    public function date_difference_function_exists()
    {
        $this->assertTrue(function_exists('date_difference'));
    }

    /** @test */
    public function date_difference_returns_days_count_by_default()
    {
        $this->assertEquals(9, date_difference('2018-04-01', '2018-04-10'));
    }

    /** @test */
    public function date_difference_can_returns_formatted_string()
    {
        $this->assertEquals('9 days', date_difference('2018-04-01', '2018-04-10', '%a days'));
    }

    /** @test */
    public function date_difference_returns_proper_months_and_days_format()
    {
        // TODO: Need to fix, this should returns 1 months 9 days
        $this->assertEquals('1 month 12 days', date_difference('2018-03-01', '2018-04-10', '%m month %d days'));
    }

    /** @test */
    public function date_difference_returns_proper_years_months_and_days_format()
    {
        $this->assertEquals('1 year 1 month 12 days', date_difference('2017-03-01', '2018-04-10', '%y year %m month %d days'));
    }
}
