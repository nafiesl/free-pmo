@if (Request::has('action') == false)
{!! Form::open(['route' => ['tasks.store', $feature->id]])!!}
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('task.create') }}</h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4">{!! FormField::text('name') !!}</div>
            <div class="col-sm-6">{!! FormField::text('description') !!}</div>
            <div class="col-sm-2">
                {!! FormField::text('progress', ['addon' => ['after' => '%'],'value' => 0]) !!}
            </div>
        </div>
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
            <div class="col-sm-4">{!! FormField::text('name') !!}</div>
            <div class="col-sm-6">{!! FormField::text('description') !!}</div>
            <div class="col-sm-2">
                {!! FormField::text('progress', ['addon' => ['after' => '%']]) !!}
            </div>
        </div>
        {!! Form::hidden('feature_id', $editableTask->feature_id) !!}
        {!! Form::submit(trans('task.update'), ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('features.show', trans('app.cancel'), [$feature->id], ['class' => 'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endif
@if (Request::get('action') == 'task_delete' && $editableTask)
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('task.delete') }}</h3></div>
    <div class="panel-body">
        {{ trans('app.delete_confirm') }}
        {!! link_to_route('features.show', trans('app.cancel'), [$feature->id], ['class' => 'btn btn-default']) !!}
        <div class="pull-right">
            {!! FormField::delete([
            'route'=>['tasks.destroy',$editableTask->id]],
            trans('app.delete_confirm_button'),
            ['class'=>'btn btn-danger'],
            [
                'task_id' => $editableTask->id,
                'feature_id' => $editableTask->feature_id,
            ]) !!}
        </div>
    </div>
</div>
@endif
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('feature.tasks') }}</h3></div>
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('task.name') }}</th>
            <th>{{ trans('app.description') }}</th>
            <th class="text-center">{{ trans('task.progress') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($feature->tasks as $key => $task)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td class="text-center">{{ $task->progress }} %</td>
                <td>
                    {{ link_to_route('features.show', trans('task.edit'), [
                        $feature->id,
                        'action' => 'task_edit',
                        'task_id' => $task->id
                    ],['class' => 'btn btn-warning btn-xs']) }}
                    {{ link_to_route('features.show', trans('task.delete'), [
                        $feature->id,
                        'action' => 'task_delete',
                        'task_id' => $task->id
                    ],['class' => 'btn btn-danger btn-xs']) }}
                </td>
            </tr>
            @empty
            <tr><td colspan="5">{{ trans('task.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="3">Total</th>
                <th class="text-center">{{ formatDecimal($feature->tasks->avg('progress')) }} %</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>