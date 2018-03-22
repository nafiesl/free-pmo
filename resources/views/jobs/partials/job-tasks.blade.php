<div id="job-tasks" class="panel panel-default">
    <div class="panel-heading">
        @if (request('action') == 'sort_tasks')
            {{ link_to_route('jobs.show', __('app.done'), [$job], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin: -2px -8px']) }}
        @else
            {{ link_to_route('jobs.show', __('job.sort_tasks'), [$job, 'action' => 'sort_tasks', '#job-tasks'], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin: -2px -8px']) }}
        @endif
        <h3 class="panel-title">{{ request('action') == 'sort_tasks' ? __('job.sort_tasks') : __('job.tasks') }}</h3>
    </div>
    @if (request('action') == 'sort_tasks')
        <ul id="sort-tasks" class="list-group">
            @foreach($job->tasks as $key => $task)
                <li id="{{ $task->id }}" class="list-group-item">
                    <i class="fa fa-arrows-v" style="margin-right: 15px"></i> {{ $key + 1 }}. {{ $task->name }}
                </li>
            @endforeach
        </ul>
    @else
    <table class="table table-condensed">
        <thead>
            <th class="col-md-1 text-center">{{ __('app.table_no') }}</th>
            <th class="col-md-6">{{ __('task.name') }}</th>
            <th class="text-center col-md-1">{{ __('task.progress') }}</th>
            <th class="col-md-2 text-center">{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($job->tasks as $key => $task)
            <tr id="{{ $task->id }}">
                <td class="text-center">{{ 1 + $key }}</td>
                <td>
                    <div>{{ $task->name }}</div>
                    <div class="small text-info">{!! nl2br($task->description) !!}</div>
                </td>
                <td class="text-center">{{ $task->progress }} %</td>
                <td class="text-center">
                @can('update', $task)
                    {!! html_link_to_route('jobs.show', '', [
                        $job,
                        'action' => 'task_edit',
                        'task_id' => $task->id
                    ],[
                        'class' => 'btn btn-warning btn-xs',
                        'title' => __('task.edit'),
                        'id' => $task->id . '-tasks-edit',
                        'icon' => 'edit'
                    ]) !!}
                @endcan
                @can('delete', $task)
                    {!! html_link_to_route('jobs.show', '', [
                        $job,
                        'action' => 'task_delete',
                        'task_id' => $task->id
                    ],[
                        'class' => 'btn btn-danger btn-xs',
                        'title' => __('task.delete'),
                        'id' => $task->id . '-tasks-delete',
                        'icon' => 'close'
                    ]) !!}
                @endcan
                </td>
            </tr>
            @empty
            <tr><td colspan="4">{{ __('task.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">{{ __('app.total') }}</th>
                <th class="text-center">{{ formatDecimal($job->tasks->avg('progress')) }} %</th>
                <th>
                    @if (request('action') == 'sort_tasks')
                        {{ link_to_route('jobs.show', __('app.done'), [$job], ['class' => 'btn btn-default btn-xs pull-right']) }}
                    @else
                        {{ link_to_route('jobs.show', __('job.sort_tasks'), [$job, 'action' => 'sort_tasks', '#job-tasks'], ['class' => 'btn btn-default btn-xs pull-right']) }}
                    @endif
                </th>
            </tr>
        </tfoot>
    </table>
    @endif
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
