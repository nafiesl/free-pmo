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
    <div>{{ __('job.name') }}: {{ $activity->data['name'] }}</div>
    <div>{{ __('job.description') }}: {{ $activity->data['description'] }}</div>
    <div>{{ __('job.price') }}: {{ format_money($activity->data['price']) }}</div>
@endslot
@endcomponent
