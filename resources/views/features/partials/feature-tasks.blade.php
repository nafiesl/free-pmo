<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('feature.tasks') }}</h3></div>
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th class="col-md-7">{{ trans('task.name') }}</th>
            <th class="col-md-2">{{ trans('task.route_name') }}</th>
            <th class="text-center col-md-1">{{ trans('task.progress') }}</th>
            <th class="col-md-2 text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody id="sort-tasks">
            @forelse($feature->tasks as $key => $task)
            <tr id="{{ $task->id }}">
                <td>{{ 1 + $key }}</td>
                <td>
                    <div>{{ $task->name }}</div>
                    <div class="small text-info">{!! nl2br($task->description) !!}</div>
                </td>
                <td>{{ $task->route_name }}</td>
                <td class="text-center">{{ $task->progress }} %</td>
                <td class="text-center">
                    {!! html_link_to_route('features.show', '', [
                        $feature->id,
                        'action' => 'task_edit',
                        'task_id' => $task->id
                    ],[
                        'class' => 'btn btn-warning btn-xs',
                        'title' => trans('task.edit'),
                        'icon' => 'edit'
                    ]) !!}
                    {!! html_link_to_route('features.show', '', [
                        $feature->id,
                        'action' => 'task_delete',
                        'task_id' => $task->id
                    ],[
                        'class' => 'btn btn-danger btn-xs',
                        'title' => trans('task.delete'),
                        'icon' => 'close'
                    ]) !!}
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
            $.post("{{ route('features.tasks-reorder', $feature->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection