<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagePaymentsTest extends TestCase
{
    /** @test */
    public function ()
    {
        $this->visit('/');
    }
}
