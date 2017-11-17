@if (Request::has('action') == false)
{!! Form::open(['route' => ['tasks.store', $job->id]])!!}
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('task.create') }}</h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-5">{!! FormField::text('name') !!}</div>
            <div class="col-sm-2">{!! FormField::text('progress', ['addon' => ['after' => '%'],'value' => 0]) !!}</div>
        </div>
        {!! FormField::textarea('description') !!}
        {!! Form::submit(trans('task.create'), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endif
@if (Request::get('action') == 'task_edit' && $editableTask)
{!! Form::model($editableTask, ['route' => ['tasks.update', $editableTask->id],'method' =>'patch'])!!}
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('task.edit') }}</h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">{!! FormField::text('name') !!}</div>
        </div>
        {!! FormField::textarea('description') !!}
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('progress', 'Progress', ['class' => 'control-label']) !!}

                {!! Form::input('range', 'progress', null, [
                    'min' => '0',
                    'max' => '100',
                    'step' => '10',
                ]) !!}
            </div>
            <div class="col-md-2" style="font-size: 28px; margin-top: 15px;">
                <strong id="ap_weight">{{ $editableTask->progress }}</strong>%
            </div>
            <div class="col-md-6">
                {!! FormField::select('job_id', $job->project->jobs->pluck('name','id'), ['label' => 'Pindahkan ke Fitur lain']) !!}
            </div>
        </div>
        {!! Form::submit(trans('task.update'), ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('jobs.show', trans('app.cancel'), [$job->id], ['class' => 'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endif
@if (Request::get('action') == 'task_delete' && $editableTask)
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('task.delete') }}</h3></div>
    <div class="panel-body">
        <div>{{ $editableTask->name }}</div>
        <div class="small text-info">{!! nl2br($editableTask->description) !!}</div>
    </div>
    <div class="panel-footer">
        {{ trans('app.delete_confirm') }}
        {!! link_to_route('jobs.show', trans('app.cancel'), [$job->id], ['class' => 'btn btn-default']) !!}
        <div class="pull-right">
            {!! FormField::delete([
                'route'=>['tasks.destroy',$editableTask->id]],
                trans('app.delete_confirm_button'),
                ['class'=>'btn btn-danger'],
                [
                'task_id' => $editableTask->id,
                'job_id' => $editableTask->job_id,
                ]) !!}
            </div>
        </div>
</div>
@endif
