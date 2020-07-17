<?php

namespace Tests\Feature\Projects;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Issue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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

    /** @test */
    public function user_can_edit_an_issue_comment()
    {
        $this->adminUserSigningIn();
        $issue = factory(Issue::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'issues',
            'commentable_id'   => $issue->id,
            'body'             => 'This is issue comment.',
        ]);

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);
        $this->seeElement('a', ['id' => 'edit-comment-'.$comment->id]);
        $this->click('edit-comment-'.$comment->id);
        $this->seeRouteIs('projects.issues.show', [$issue->project, $issue, 'action' => 'comment-edit', 'comment_id' => $comment->id]);

        $this->submitForm(__('comment.update'), [
            'body' => 'Edited comment.',
        ]);

        $this->seePageIs(route('projects.issues.show', [$issue->project, $issue]));
        $this->see(__('comment.updated'));

        $this->seeInDatabase('comments', [
            'id'               => $comment->id,
            'commentable_type' => 'issues',
            'commentable_id'   => $issue->id,
            'body'             => 'Edited comment.',
        ]);
    }

    /** @test */
    public function user_can_delete_an_issue_comment()
    {
        $this->adminUserSigningIn();
        $issue = factory(Issue::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'issues',
            'commentable_id'   => $issue->id,
            'body'             => 'This is issue comment.',
        ]);

        $this->visitRoute('projects.issues.show', [$issue->project, $issue]);
        $this->seeElement('button', ['id' => 'delete-comment-'.$comment->id]);
        $this->press('delete-comment-'.$comment->id);

        $this->seePageIs(route('projects.issues.show', [$issue->project, $issue]));
        $this->see(__('comment.deleted'));

        $this->dontSeeInDatabase('comments', [
            'id' => $comment->id,
        ]);
    }
}
