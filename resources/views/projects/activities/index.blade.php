@extends('layouts.project')

@section('subtitle', __('project.activities'))

@section('content-project')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {{ $activities->links() }}
        <ul class="list-group">
            @foreach($activities as $activity)
            @includeWhen(
                view()->exists('users.activities.'.$activity->object_type.'.'.$activity->type),
                'users.activities.'.$activity->object_type.'.'.$activity->type
            )
            @endforeach
        </ul>
        {{ $activities->links() }}
    </div>
</div>

@endsection
