<?php

namespace Tests\Feature\Projects;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_project_comments()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'projects',
            'commentable_id'   => $project->id,
            'body'             => 'This is project comment.',
        ]);

        $this->visitRoute('projects.comments.index', $project);
        $this->seeRouteIs('projects.comments.index', $project);

        $this->seeText('This is project comment.');
    }

    /** @test */
    public function admin_can_add_comment_to_a_project()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();

        $this->visitRoute('projects.comments.index', $project);

        $this->submitForm(__('comment.create'), [
            'body' => 'Komentar pertama.',
        ]);

        $this->seePageIs(route('projects.comments.index', $project));
        $this->see(__('comment.created'));

        $this->seeInDatabase('comments', [
            'commentable_type' => 'projects',
            'commentable_id'   => $project->id,
            'body'             => 'Komentar pertama.',
            'creator_id'       => $admin->id,
        ]);
    }

    /** @test */
    public function user_can_edit_comment()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'projects',
            'commentable_id'   => $project->id,
            'body'             => 'This is project comment.',
        ]);

        $this->visitRoute('projects.comments.index', $project);
        $this->seeElement('a', ['id' => 'edit-comment-'.$comment->id]);
        $this->click('edit-comment-'.$comment->id);
        $this->seeRouteIs('projects.comments.index', [$project, 'action' => 'comment-edit', 'comment_id' => $comment->id]);

        $this->submitForm(__('comment.update'), [
            'body' => 'Komentar pertama.',
        ]);

        $this->seePageIs(route('projects.comments.index', $project));
        $this->see(__('comment.updated'));

        $this->seeInDatabase('comments', [
            'id'               => $comment->id,
            'commentable_type' => 'projects',
            'commentable_id'   => $project->id,
            'body'             => 'Komentar pertama.',
        ]);
    }

    /** @test */
    public function user_can_delete_comment()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'projects',
            'commentable_id'   => $project->id,
            'body'             => 'This is project comment.',
        ]);

        $this->visitRoute('projects.comments.index', $project);
        $this->seeElement('button', ['id' => 'delete-comment-'.$comment->id]);
        $this->press('delete-comment-'.$comment->id);

        $this->seePageIs(route('projects.comments.index', $project));
        $this->see(__('comment.deleted'));

        $this->dontSeeInDatabase('comments', [
            'id' => $comment->id,
        ]);
    }
}
