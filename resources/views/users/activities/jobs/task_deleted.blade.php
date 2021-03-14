@component('users.activities.activity_list_item')
@slot('time')
    {{ $activity->created_at }}
@endslot
@slot('body')
    <p>
        {!! __('activity.'.$activity->object_type.'.'.$activity->type, [
            'user' => $activity->user->name,
        ]) !!}
    </p>
    <div>{{ __('task.name') }}: {{ $activity->data['name'] }}</div>
    <div>{{ __('task.description') }}: {{ $activity->data['description'] }}</div>
    <div>{{ __('task.progress') }}: {{ $activity->data['progress'] }} %</div>
@endslot
@endcomponent
