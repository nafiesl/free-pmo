<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Entities\Projects\Comment;

class CommentPolicyTest extends TestCase
{
    /** @test */
    public function admin_can_edit_any_comments()
    {
        $admin = $this->createUser('admin');
        $comment = factory(Comment::class)->create();

        $this->assertTrue($admin->can('update', $comment));
    }

    /** @test */
    public function worker_can_only_edit_their_comments()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $comment = factory(Comment::class)->create(['creator_id' => $worker->id]);

        $this->assertTrue($admin->can('update', $comment));
        $this->assertTrue($worker->can('update', $comment));
    }
}
