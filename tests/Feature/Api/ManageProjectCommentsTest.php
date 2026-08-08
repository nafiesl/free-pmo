<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageProjectCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_list_project_comments()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $project->comments()->create(['body' => 'Test comment', 'creator_id' => $user->id]);

        $this->getJson(route('api.projects.comments.index', $project), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function admin_can_add_project_comment()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->postJson(route('api.projects.comments.store', $project), [
            'body' => 'Milestone 1 done.',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('comment.created')]);
        $this->seeInDatabase('comments', ['body' => 'Milestone 1 done.']);
    }

    /** @test */
    public function worker_can_add_comment_on_assigned_project()
    {
        $user = $this->createUser('worker');
        $project = factory(Project::class)->create();
        factory(Job::class)->create(['project_id' => $project->id, 'worker_id' => $user->id]);

        $this->postJson(route('api.projects.comments.store', $project), [
            'body' => 'Worker comment.',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
    }

    /** @test */
    public function worker_cannot_add_comment_on_unassigned_project()
    {
        $user = $this->createUser('worker');
        $project = factory(Project::class)->create();

        $this->postJson(route('api.projects.comments.store', $project), [
            'body' => 'Not allowed comment.',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_project_comments()
    {
        $project = factory(Project::class)->create();

        $this->getJson(route('api.projects.comments.index', $project));

        $this->seeStatusCode(401);
    }

    /** @test */
    public function admin_can_update_project_comment()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $comment = $project->comments()->create(['body' => 'Old comment', 'creator_id' => $user->id]);

        $this->patchJson(route('api.projects.comments.update', [$project, $comment]), [
            'body' => 'Updated comment',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('comment.updated')]);
        $this->seeInDatabase('comments', ['id' => $comment->id, 'body' => 'Updated comment']);
    }

    /** @test */
    public function admin_can_delete_project_comment()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $comment = $project->comments()->create(['body' => 'Test comment', 'creator_id' => $user->id]);

        $this->deleteJson(route('api.projects.comments.destroy', [$project, $comment]), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('comment.deleted')]);
        $this->dontSeeInDatabase('comments', ['id' => $comment->id]);
    }

    /** @test */
    public function worker_cannot_update_comment_of_other_creator()
    {
        $user = $this->createUser('worker');
        $otherWorker = $this->createUser('worker');
        $project = factory(Project::class)->create();
        factory(Job::class)->create(['project_id' => $project->id, 'worker_id' => $user->id]);
        $comment = $project->comments()->create(['body' => 'Test comment', 'creator_id' => $otherWorker->id]);

        $this->patchJson(route('api.projects.comments.update', [$project, $comment]), [
            'body' => 'Hijacked comment',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function worker_cannot_delete_comment_of_other_creator()
    {
        $user = $this->createUser('worker');
        $otherWorker = $this->createUser('worker');
        $project = factory(Project::class)->create();
        factory(Job::class)->create(['project_id' => $project->id, 'worker_id' => $user->id]);
        $comment = $project->comments()->create(['body' => 'Test comment', 'creator_id' => $otherWorker->id]);

        $this->deleteJson(route('api.projects.comments.destroy', [$project, $comment]), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function cannot_update_comment_of_other_project()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $otherProject = factory(Project::class)->create();
        $comment = $otherProject->comments()->create(['body' => 'Test comment', 'creator_id' => $user->id]);

        $this->patchJson(route('api.projects.comments.update', [$project, $comment]), [
            'body' => 'Hijacked comment',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(404);
    }
}
