<?php

namespace Tests\Feature\Projects;

use Tests\TestCase;
use App\Entities\Projects\Issue;
use App\Entities\Projects\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_issue_comments()
    {
        $this->adminUserSigningIn();
        $issue = factory(Issue::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'issues',
            'commentable_id'   => $issue->id,
            'body'             => 'This is issue comment.',
        ]);

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);

        $this->seeText('This is issue comment.');
    }
}
