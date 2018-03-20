@if (Request::has('action') == false)
@can('create', new App\Entities\Projects\Task)
{!! Form::open(['route' => ['tasks.store', $job->id]])!!}
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('task.create') }}</h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">{!! FormField::text('name', ['label' => __('task.name')]) !!}</div>
            <div class="col-md-4">
                {!! Form::label('progress', __('task.progress'), ['class' => 'control-label']) !!}
                {!! Form::input('range', 'progress', 0, [
                    'min' => '0', 'max' => '100', 'step' => '10',
                ]) !!}
            </div>
            <div class="col-md-2" style="font-size: 28px; margin-top: 15px;">
                <strong id="ap_weight">0</strong>%
            </div>
        </div>
        {!! FormField::textarea('description', ['label' => __('task.description')]) !!}
        {!! Form::submit(__('task.create'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endcan
@endif

@if (Request::get('action') == 'task_edit' && $editableTask)
@can('update', $editableTask)
{!! Form::model($editableTask, ['route' => ['tasks.update', $editableTask], 'method' => 'patch'])!!}
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('task.edit') }}</h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">{!! FormField::text('name') !!}</div>
            <div class="col-md-4">
                {!! Form::label('progress', __('task.progress'), ['class' => 'control-label']) !!}

                {!! Form::input('range', 'progress', null, [
                    'min' => '0',
                    'max' => '100',
                    'step' => '10',
                ]) !!}
            </div>
            <div class="col-md-2" style="font-size: 28px; margin-top: 15px;">
                <strong id="ap_weight">{{ $editableTask->progress }}</strong>%
            </div>
        </div>
        {!! FormField::textarea('description') !!}
        <div class="row">
            <div class="col-md-6">
                {!! FormField::select('job_id', $job->project->jobs->pluck('name', 'id'), ['label' => __('task.move_to_other_job')]) !!}
            </div>
        </div>
        {!! Form::submit(__('task.update'), ['class' => 'btn btn-warning']) !!}
        {{ link_to_route('jobs.show', __('app.cancel'), [$job], ['class' => 'btn btn-default']) }}
        {!! Form::close() !!}
    </div>
</div>
@endcan
@endif

@if (Request::get('action') == 'task_delete' && $editableTask)
@can('delete', $editableTask)
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('task.delete') }}</h3></div>
    <div class="panel-body">
        <div>{{ $editableTask->name }}</div>
        <div class="small text-info">{!! nl2br($editableTask->description) !!}</div>
    </div>
    <div class="panel-footer">
        {{ __('app.delete_confirm') }}
        {{ link_to_route('jobs.show', __('app.cancel'), [$job], ['class' => 'btn btn-default']) }}
        <div class="pull-right">
            {!! FormField::delete(['route' => ['tasks.destroy', $editableTask]],
                __('app.delete_confirm_button'),
                ['class' => 'btn btn-danger'],
                [
                    'task_id' => $editableTask->id,
                    'job_id' => $editableTask->job_id,
                ]
            ) !!}
        </div>
    </div>
</div>
@endcan
@endif
