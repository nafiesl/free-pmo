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
        $this->assertTrue(function_exists('dateDifference'));
    }
}
