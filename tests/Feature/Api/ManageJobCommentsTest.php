<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageJobCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_add_comment_to_job()
    {
        $user = $this->createUser('admin');
        $job = factory(Job::class)->create();

        $this->postJson(route('api.jobs.comments.store', $job), [
            'body' => 'Feature 7 POD upload form done, 10:30 attachment controller tested.',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('comment.created')]);
        $this->seeInDatabase('comments', ['body' => 'Feature 7 POD upload form done, 10:30 attachment controller tested.']);
    }

    /** @test */
    public function admin_can_list_job_comments()
    {
        $user = $this->createUser('admin');
        $job = factory(Job::class)->create();
        $job->comments()->create(['body' => 'Test comment', 'creator_id' => $user->id]);

        $this->getJson(route('api.jobs.comments.index', $job), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function worker_cannot_add_comment_to_job_of_other_worker()
    {
        $user = $this->createUser('worker');
        $otherWorker = $this->createUser('worker');
        $job = factory(Job::class)->create(['worker_id' => $otherWorker->id]);

        $this->postJson(route('api.jobs.comments.store', $job), [
            'body' => 'Not allowed comment',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }
}
