<?php

namespace Tests\Unit\Models;

use App\Entities\Projects\Comment;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_has_belongs_to_creator_relation()
    {
        $comment = factory(Comment::class)->make();

        $this->assertInstanceOf(User::class, $comment->creator);
        $this->assertEquals($comment->creator_id, $comment->creator->id);
    }

    /** @test */
    public function a_comment_has_time_display_attribute()
    {
        $comment = factory(Comment::class)->create(['created_at' => now()->subHour()]);
        $this->assertEquals($comment->created_at->diffForHumans(), $comment->time_display);

        $comment = factory(Comment::class)->create(['created_at' => now()->subDays(3)]);
        $this->assertEquals($comment->created_at, $comment->time_display);
    }
}
