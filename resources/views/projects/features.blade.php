@extends('layouts.app')

@section('title', trans('project.features') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb',['title' => trans('project.features')])

<h1 class="page-header">
    <div class="pull-right">
        {!! html_link_to_route('features.create', trans('feature.create'), [$project->id], ['class' => 'btn btn-primary','icon' => 'plus']) !!}
        {!! html_link_to_route('features.add-from-other-project', trans('feature.add_from_other_project'), [$project->id], ['class' => 'btn btn-primary','icon' => 'plus']) !!}
    </div>
    {{ $project->name }} <small>{{ trans('project.features') }}</small>
</h1>

@include('projects.partials.nav-tabs')

<div class="panel panel-default">
    <table id="features-table" class="table table-condensed table-striped">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('feature.name') }}</th>
            <th class="text-center">{{ trans('feature.tasks_count') }}</th>
            <th class="text-center">{{ trans('feature.progress') }}</th>
            <th class="text-right">{{ trans('feature.price') }}</th>
            {{-- <th>{{ trans('feature.worker') }}</th> --}}
            <th class="text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody id="sort-features">
            @forelse($features as $key => $feature)
            @php($no = 1 + $key)
            <tr id="{{ $feature->id }}">
                <td>{{ $no }}</td>
                <td>
                    {{ $feature->name }}
                    @if ($feature->tasks->isEmpty() == false)
                    <ul>
                        @foreach($feature->tasks as $task)
                        <li>{{ $task->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td class="text-center">{{ $feature->tasks_count = $feature->tasks->count() }}</td>
                <td class="text-center">{{ formatDecimal($feature->progress = $feature->tasks->avg('progress')) }} %</td>
                <td class="text-right">{{ formatRp($feature->price) }}</td>
                {{-- <td>{{ $feature->worker->name }}</td> --}}
                <td class="text-center">
                    {!! link_to_route('features.show', trans('task.create'),[$feature->id],['class' => 'btn btn-default btn-xs']) !!}
                    {!! link_to_route('features.show', trans('app.show'),[$feature->id],['class' => 'btn btn-info btn-xs','id' => 'show-feature-' . $feature->id]) !!}
                    {!! link_to_route('features.edit', trans('app.edit'),[$feature->id],['class' => 'btn btn-warning btn-xs']) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('feature.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-center">{{ $features->sum('tasks_count') }}</th>
                <th class="text-center">{{ formatDecimal($features->avg('progress')) }} %</th>
                <th class="text-right">{{ formatRp($features->sum('price')) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
{{--
@section('ext_css')
    {!! Html::style(url('assets/css/plugins/dataTables.bootstrap.css')) !!}
@endsection
 --}}
@section('ext_js')
{{--     {!! Html::script(url('assets/js/plugins/dataTables/jquery.dataTables.js')) !!}
    {!! Html::script(url('assets/js/plugins/dataTables/dataTables.bootstrap.js')) !!}
 --}}    {!! Html::script(url('assets/js/plugins/jquery-ui.min.js')) !!}
@endsection

@section('script')

<script>
(function() {
    // $('#features-table').dataTable({
    //     "paging": false,
    //     "info": false
    // });
    $('#sort-features').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('toArray').toString();
            $.post("{{ route('projects.features-reorder', $project->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection