<?php

use App\Entities\Users\Event;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ApiEventsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_get_all_existing_events()
    {
        $user = factory(User::class)->create();
        $events = factory(Event::class, 5)->create(['user_id' => $user->id]);

        $this->json('get', route('api.events.index'), [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            '*' => [
                'user',
                'title',
                'body',
                'start',
            ]
        ]);
    }

    /** @test */
    public function user_can_create_new_event()
    {
        $user = factory(User::class)->create();

        $this->json('post', route('api.events.store'), [
            'title' => 'New Event Title',
            'body' => 'New Event Body',
            'start' => '2016-07-21 12:20:00',
        ], [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $this->seeStatusCode(201);

        $this->seeJson([
            'message' => trans('event.created'),
            'user' => $user->name,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
            'start' => '2016-07-21 12:20:00',
            'end' => null,
            'allDay' => false,
        ]);

        $this->seeInDatabase('user_events', [
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
        $event = factory(Event::class)->create(['user_id' => $user->id]);
        // dump($event->toArray());
        $this->json('patch', route('api.events.update'), [
            'id' => $event->id,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
        ], [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $this->dump();

        $this->seeStatusCode(200);

        $this->seeJson([
            'message' => trans('event.updated'),
            'user' => $user->name,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
        ]);

        $this->seeInDatabase('user_events', [
            'user_id' => $user->id,
            'title' => 'New Event Title',
            'body' => 'New Event Body',
        ]);
    }

    /** @test */
    public function user_can_delete_their_event()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create(['user_id' => $user->id]);

        $this->json('delete',route('api.events.destroy'), ['id' => $event->id], [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $this->seeStatusCode(200);

        $this->seeJson([
            'message' => trans('event.deleted'),
        ]);
    }

    /** @test */
    public function user_can_reschedule_their_event()
    {
        $user = factory(User::class)->create();
        $event = factory(Event::class)->create(['user_id' => $user->id, 'start' => '2016-11-17 12:00:00']);

        $this->json('patch', route('api.events.reschedule'), [
            'id' => $event->id,
            'start' => '2016-11-07 13:00:00',
            'start' => '2016-11-07 15:00:00',
        ], [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $this->dump();
        $this->seeStatusCode(200);

        $this->seeJson([
            'message' => trans('event.rescheduled'),
        ]);

        $this->seeInDatabase('user_events', [
            'id' => $event->id,
            'user_id' => $user->id,
            'start' => '2016-11-07 13:00:00',
            'start' => '2016-11-07 15:00:00',
        ]);
    }
}
