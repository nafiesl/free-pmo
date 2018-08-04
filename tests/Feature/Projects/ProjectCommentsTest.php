<?php

namespace Tests\Feature\Projects;

use Tests\TestCase;
use App\Entities\Projects\Comment;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectCommentsTest extends TestCase
{
    use DatabaseMigrations;

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
}
