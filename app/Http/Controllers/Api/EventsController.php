<?php

namespace App\Http\Controllers\Api;

use App\Entities\Users\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $events = Event::where(function($query) use ($start, $end) {
            if ($start && $end)
                $query->whereBetween('start', [$start, $end]);
        })->with('user')->get();

        $response = fractal()
            ->collection($events)
            ->transformWith(function($event) {
                $isOwnEvent = $event->user_id == auth()->id();
                return [
                    'id' => $event->id,
                    'user' => $event->user->name,
                    'user_id' => $event->user_id,
                    'title' => $event->title,
                    'body' => $event->body,
                    'start' => $event->start,
                    'end' => $event->end,
                    'allDay' => $event->is_allday,
                    'editable' => true,
                    'color' => $isOwnEvent ? '' : '#B7B7B7',
                ];
            })
            ->toArray();

        return response()->json($response['data'], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:60',
            'body' => 'string|max:255',
            'start' => 'required|date|date_format:Y-m-d H:i:s',
            'end' => 'date|date_format:Y-m-d H:i:s',
            'is_allday' => '',
        ]);

        $event = new Event;
        $event->user_id = auth()->id();
        $event->title = $request->get('title');
        $event->body = $request->get('body');
        $event->start = $request->get('start');
        $event->end = $request->get('is_allday') == "true" ? null : $request->get('end');
        $event->is_allday = $request->get('is_allday') == "true" ? 1 : 0;

        $event->save();

        $response = [
                'message' => trans('event.created')
            ] + fractal()->item($event)
            ->transformWith(function($event) {
                return [
                    'id' => $event->id,
                    'user' => $event->user->name,
                    'title' => $event->title,
                    'body' => $event->body,
                    'start' => $event->start,
                    'end' => $event->end,
                    'allDay' => $event->is_allday,
                ];
            })
            ->toArray();

        return response()->json($response, 201);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:user_events,id',
            'title' => 'required|string|max:60',
            'body' => 'string|max:255',
            'is_allday' => '',
        ]);

        $event = Event::findOrFail($request->get('id'));
        $this->authorize('update', $event);

        $event->title = $request->get('title');
        $event->body = $request->get('body');
        $event->is_allday = !!$request->get('is_allday');

        $event->save();

        $response = [
                'message' => trans('event.updated')
            ] + fractal()->item($event)
            ->transformWith(function($event) {
                return [
                    'id' => $event->id,
                    'user' => $event->user->name,
                    'title' => $event->title,
                    'body' => $event->body,
                    'start' => $event->start,
                    'end' => $event->end,
                    'allDay' => $event->is_allday,
                ];
            })
            ->toArray();

        return response()->json($response, 200);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:user_events,id'
        ]);

        $event = Event::findOrFail($request->get('id'));
        $this->authorize('delete', $event);
        $event->delete();

        return response()->json(['message' => trans('event.deleted')], 200);
    }

    public function reschedule(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:user_events,id',
            'start' => 'required|date|date_format:Y-m-d H:i:s',
            'end' => 'date|date_format:Y-m-d H:i:s',
        ]);

        $event = Event::findOrFail($request->get('id'));
        $this->authorize('update', $event);
        $event->start = $request->get('start');

        if ($request->has('end')) {
            $event->end = $request->get('end');
            $event->is_allday = false;
        }

        $event->save();

        $response = [
                'message' => trans('event.rescheduled')
            ] + fractal()->item($event)
            ->transformWith(function($event) {
                return [
                    'id' => $event->id,
                    'user' => $event->user->name,
                    'title' => $event->title,
                    'body' => $event->body,
                    'start' => $event->start,
                    'end' => $event->end,
                    'allDay' => $event->is_allday,
                ];
            })
            ->toArray();

        return response()->json($response, 200);
    }
}
