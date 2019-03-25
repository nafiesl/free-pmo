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

    /** @test */
    public function admin_can_add_comment_to_an_issue()
    {
        $admin = $this->adminUserSigningIn();
        $issue = factory(Issue::class)->create();

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);

        $this->submitForm(__('comment.create'), [
            'body' => 'First comment.',
        ]);

        $this->seePageIs(route('projects.issues.show', [$issue->project, $issue]));
        $this->see(__('comment.created'));

        $this->seeInDatabase('comments', [
            'commentable_type' => 'issues',
            'commentable_id'   => $issue->id,
            'body'             => 'First comment.',
            'creator_id'       => $admin->id,
        ]);
    }
}
