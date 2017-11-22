<div id="job-tasks" class="panel panel-default">
    <div class="panel-heading">
        @if (request('action') == 'sort_tasks')
            {{ link_to_route('jobs.show', trans('app.done'), [$job->id], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin: -2px -8px']) }}
        @else
            {{ link_to_route('jobs.show', trans('job.sort_tasks'), [$job->id, 'action' => 'sort_tasks', '#job-tasks'], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin: -2px -8px']) }}
        @endif
        <h3 class="panel-title">{{ trans('job.tasks') }}</h3>
    </div>
    <table class="table table-condensed">
        <thead>
            <th class="col-md-1 text-center">{{ trans('app.table_no') }}</th>
            <th class="col-md-6">{{ trans('task.name') }}</th>
            <th class="text-center col-md-1">{{ trans('task.progress') }}</th>
            <th class="col-md-2 text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody id="sort-tasks">
            @forelse($job->tasks as $key => $task)
            <tr id="{{ $task->id }}">
                <td class="text-center">{{ 1 + $key }}</td>
                <td>
                    <div>{{ $task->name }}</div>
                    <div class="small text-info">{!! nl2br($task->description) !!}</div>
                </td>
                <td class="text-center">{{ $task->progress }} %</td>
                <td class="text-center">
                    {!! html_link_to_route('jobs.show', '', [
                        $job->id,
                        'action' => 'task_edit',
                        'task_id' => $task->id
                    ],[
                        'class' => 'btn btn-warning btn-xs',
                        'title' => trans('task.edit'),
                        'id' => $task->id . '-tasks-edit',
                        'icon' => 'edit'
                    ]) !!}
                    {!! html_link_to_route('jobs.show', '', [
                        $job->id,
                        'action' => 'task_delete',
                        'task_id' => $task->id
                    ],[
                        'class' => 'btn btn-danger btn-xs',
                        'title' => trans('task.delete'),
                        'id' => $task->id . '-tasks-delete',
                        'icon' => 'close'
                    ]) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="4">{{ trans('task.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-center">{{ formatDecimal($job->tasks->avg('progress')) }} %</th>
                <th>
                    @if (request('action') == 'sort_tasks')
                        {{ link_to_route('jobs.show', trans('app.done'), [$job->id], ['class' => 'btn btn-default btn-xs pull-right']) }}
                    @else
                        {{ link_to_route('jobs.show', trans('job.sort_tasks'), [$job->id, 'action' => 'sort_tasks', '#job-tasks'], ['class' => 'btn btn-default btn-xs pull-right']) }}
                    @endif
                </th>
            </tr>
        </tfoot>
    </table>
</div>

@if (request('action') == 'sort_tasks')

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery-ui.min.js')) !!}
@endsection

@section('script')

<script>
(function() {
    $('#sort-tasks').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('toArray').toString();
            // console.log(data);
            $.post("{{ route('jobs.tasks-reorder', $job->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection

@endif
