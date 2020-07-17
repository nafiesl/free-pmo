<?php

namespace Tests\Unit\Policies;

use App\Entities\Projects\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentPolicyTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    public function admin_can_delete_any_comments()
    {
        $admin = $this->createUser('admin');
        $comment = factory(Comment::class)->create();

        $this->assertTrue($admin->can('delete', $comment));
    }

    /** @test */
    public function worker_can_only_delete_their_comments()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $comment = factory(Comment::class)->create(['creator_id' => $worker->id]);

        $this->assertTrue($admin->can('delete', $comment));
        $this->assertTrue($worker->can('delete', $comment));
    }
}
