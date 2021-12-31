<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Project;
use App\Entities\Users\Event;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Manage Events API Feature Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ApiEventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_existing_events()
    {
        $user = factory(User::class)->create();
        $events = factory(Event::class, 2)->create(['user_id' => $user->id]);

        $this->getJson(route('api.events.index'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            '*' => [
                'user',
                'title',
                'body',
                'start',
                'end',
                'allDay',
                'project_id',
            ],
        ]);
    }

    /** @test */
    public function user_can_create_new_event()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();

        $this->postJson(route('api.events.store'), [
            'title' => 'New Event Title',
            'body' => 'New Event Body',
            'start' => '2016-07-21 12:20:00',
            'project_id' => $project->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);

        $this->seeJson([
            'message' => __('event.created'),
            'project_id' => $project->id,
            'user' => $user->name,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
            'start' => '2016-07-21 12:20:00',
            'end' => null,
            'allDay' => false,
        ]);

        $this->seeInDatabase('user_events', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
            'start' => '2016-07-21 12:20:00',
            'end' => null,
            'is_allday' => 0,
        ]);
    }

    /** @test */
    public function user_can_update_their_event()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $event = factory(Event::class)->create(['user_id' => $user->id]);
        // dump($event->toArray());
        $this->patchJson(route('api.events.update'), [
            'id' => $event->id,
            'project_id' => $project->id,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
            'is_allday' => 'true',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);

        $this->seeJson([
            'message' => __('event.updated'),
            'project_id' => $project->id,
            'user' => $user->name,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
        ]);

        $this->seeInDatabase('user_events', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
        ]);
    }

    /** @test */
    public function user_can_delete_their_event()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create(['user_id' => $user->id]);

        $this->deleteJson(route('api.events.destroy'), ['id' => $event->id], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);

        $this->seeJson([
            'message' => __('event.deleted'),
        ]);
    }

    /** @test */
    public function user_can_reschedule_their_event()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create(['user_id' => $user->id, 'start' => '2016-11-17 12:00:00']);

        $this->patchJson(route('api.events.reschedule'), [
            'id' => $event->id,
            'start' => '2016-11-07 13:00:00',
            'end' => '2016-11-07 15:00:00',
            'is_allday' => 'false',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('event.rescheduled')]);
        $this->seeInDatabase('user_events', [
            'id' => $event->id,
            'user_id' => $user->id,
            'start' => '2016-11-07 13:00:00',
            'end' => '2016-11-07 15:00:00',
            'is_allday' => 0,
        ]);
    }

    /** @test */
    public function event_can_be_set_as_all_day_event()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create([
            'user_id' => $user->id,
            'start' => '2016-11-17 12:00:00',
            'end' => '2016-11-17 14:00:00',
            'is_allday' => 0,
        ]);

        $this->patchJson(route('api.events.reschedule'), [
            'id' => $event->id,
            'start' => '2016-11-07 13:00:00',
            'end' => '2016-11-07 15:00:00',
            'is_allday' => 'true',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('event.rescheduled')]);
        $this->seeInDatabase('user_events', [
            'id' => $event->id,
            'user_id' => $user->id,
            'start' => '2016-11-07 13:00:00',
            'end' => null,
            'is_allday' => 1,
        ]);
    }
}
