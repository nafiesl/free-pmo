<?php

namespace Tests\Unit\Policies;

use App\Entities\Projects\Issue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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

    /** @test */
    public function admin_can_add_comment_to_an_issue()
    {
        $admin = $this->createUser('admin');
        $issue = factory(Issue::class)->create();

        $this->assertTrue($admin->can('comment-on', $issue));
    }
}
