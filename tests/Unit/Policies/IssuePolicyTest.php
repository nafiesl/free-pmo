<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Entities\Projects\Issue;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Issue Policy Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class IssuePolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_issue()
    {
        $admin = $this->createUser('admin');

        $this->assertTrue($admin->can('create', new Issue()));
    }
}
