@component('users.activities.activity_list_item')
@slot('time')
    {{ $activity->created_at }}
@endslot
@slot('body')
    {!! __('activity.'.$activity->object_type.'.'.$activity->type, [
        'user' => $activity->user->name,
        'name' => $activity->object->name,
    ]) !!}
@endslot
@endcomponent
