<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('feature.tasks') }}</h3></div>
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('task.name') }}</th>
            <th>{{ trans('task.route_name') }}</th>
            <th class="text-center">{{ trans('task.progress') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($feature->tasks as $key => $task)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>
                    <div>{{ $task->name }}</div>
                    <div class="small text-info">{{ $task->description }}</div>
                </td>
                <td>{{ $task->route_name }}</td>
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