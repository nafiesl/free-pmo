@component('users.activities.activity_list_item')
@slot('time')
    {{ $activity->created_at }}
@endslot
@slot('body')
    <p>
        {!! __('activity.'.$activity->object_type.'.'.$activity->type, [
            'user' => $activity->user->name,
            'name' => $activity->object->name,
        ]) !!}
    </p>
    @php
        $data = $activity->data;
    @endphp
    @foreach ($data['before'] as $key => $value)
        @php
            $afterValue = $data['after'][$key] ?? null;
        @endphp
        <div>
            @if ($key == 'status_id')
                {{ __('project.status') }}:
                {{ App\Entities\Projects\Status::getNameById($value) }}
                => {{ App\Entities\Projects\Status::getNameById($afterValue) }}
            @else
                {{ __('project.'.$key) }}: {{ $value }} => {{ $afterValue }}
            @endif
        </div>
    @endforeach
@endslot
@endcomponent
