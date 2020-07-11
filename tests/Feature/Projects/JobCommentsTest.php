<?php

namespace Tests\Feature\Projects;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_job_comments()
    {
        $this->adminUserSigningIn();
        $job = factory(Job::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'jobs',
            'commentable_id'   => $job->id,
            'body'             => 'This is job comment.',
        ]);

        $this->visitRoute('jobs.comments.index', $job);
        $this->seeRouteIs('jobs.comments.index', $job);

        $this->seeText('This is job comment.');
    }

    /** @test */
    public function admin_can_add_comment_to_a_job()
    {
        $admin = $this->adminUserSigningIn();
        $job = factory(Job::class)->create();

        $this->visitRoute('jobs.comments.index', $job);

        $this->submitForm(__('comment.create'), [
            'body' => 'Komentar pertama.',
        ]);

        $this->seePageIs(route('jobs.comments.index', $job));
        $this->see(__('comment.created'));

        $this->seeInDatabase('comments', [
            'commentable_type' => 'jobs',
            'commentable_id'   => $job->id,
            'body'             => 'Komentar pertama.',
            'creator_id'       => $admin->id,
        ]);
    }

    /** @test */
    public function user_can_edit_comment()
    {
        $this->adminUserSigningIn();
        $job = factory(Job::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'jobs',
            'commentable_id'   => $job->id,
            'body'             => 'This is job comment.',
        ]);

        $this->visitRoute('jobs.comments.index', $job);
        $this->seeElement('a', ['id' => 'edit-comment-'.$comment->id]);
        $this->click('edit-comment-'.$comment->id);
        $this->seeRouteIs('jobs.comments.index', [$job, 'action' => 'comment-edit', 'comment_id' => $comment->id]);

        $this->submitForm(__('comment.update'), [
            'body' => 'Komentar pertama.',
        ]);

        $this->seePageIs(route('jobs.comments.index', $job));
        $this->see(__('comment.updated'));

        $this->seeInDatabase('comments', [
            'id'               => $comment->id,
            'commentable_type' => 'jobs',
            'commentable_id'   => $job->id,
            'body'             => 'Komentar pertama.',
        ]);
    }

    /** @test */
    public function user_can_delete_comment()
    {
        $this->adminUserSigningIn();
        $job = factory(Job::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'jobs',
            'commentable_id'   => $job->id,
            'body'             => 'This is job comment.',
        ]);

        $this->visitRoute('jobs.comments.index', $job);
        $this->seeElement('button', ['id' => 'delete-comment-'.$comment->id]);
        $this->press('delete-comment-'.$comment->id);

        $this->seePageIs(route('jobs.comments.index', $job));
        $this->see(__('comment.deleted'));

        $this->dontSeeInDatabase('comments', [
            'id' => $comment->id,
        ]);
    }
}
