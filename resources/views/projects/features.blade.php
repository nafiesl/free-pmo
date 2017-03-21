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

@foreach($features->groupBy('type_id') as $key => $groupedFeatures)

<div class="panel panel-default table-responsive">
    <div class="panel-heading">
        <div class="pull-right">
            {!! link_to_route('projects.features-export', trans('project.features_export_html'), [$project->id, 'html', 'feature_type' => $key], ['class' => '','target' => '_blank']) !!} |
            {!! link_to_route('projects.features-export', trans('project.features_export_excel'), [$project->id, 'excel', 'feature_type' => $key], ['class' => '']) !!} |
            {!! link_to_route('projects.features-export', trans('project.features_export_progress_excel'), [$project->id, 'excel-progress', 'feature_type' => $key], ['class' => '']) !!}
        </div>
        <h3 class="panel-title">
            {{ $key == 1 ? 'Daftar Fitur' : 'Fitur Tambahan' }}
        </h3>
    </div>
    <table class="table table-condensed table-striped">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('feature.name') }}</th>
            <th class="text-center">{{ trans('feature.tasks_count') }}</th>
            <th class="text-center">{{ trans('feature.progress') }}</th>
            {{-- <th class="text-right">{{ trans('feature.price') }}</th> --}}
            {{-- <th>{{ trans('feature.worker') }}</th> --}}
            <th class="text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody class="sort-features">
            @forelse($groupedFeatures as $key => $feature)
            @php
            $no = 1 + $key;
            $feature->progress = $feature->tasks->avg('progress');
            @endphp
            <tr id="{{ $feature->id }}" {!! $feature->progress <= 50 ? 'style="background-color: #faebcc"' : '' !!}>
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
                <td class="text-center">{{ formatDecimal($feature->progress) }} %</td>
                {{-- <td class="text-right">{{ formatRp($feature->price) }}</td> --}}
                {{-- <td>{{ $feature->worker->name }}</td> --}}
                <td class="text-center">
                    {!! html_link_to_route('features.show', '',[$feature->id],['icon' => 'search', 'title' => 'Lihat ' . trans('feature.show'), 'class' => 'btn btn-info btn-xs','id' => 'show-feature-' . $feature->id]) !!}
                    {!! html_link_to_route('features.edit', '',[$feature->id],['icon' => 'edit', 'title' => trans('feature.edit'), 'class' => 'btn btn-warning btn-xs']) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('feature.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-center">{{ $groupedFeatures->sum('tasks_count') }}</th>
                <th class="text-center">
                    <span title="Total Progress">{{ formatDecimal($groupedFeatures->sum('progress') / $groupedFeatures->count()) }} %</span>
                    <span title="Overal Progress" style="font-weight:300">({{ formatDecimal($project->getFeatureOveralProgress()) }} %)</span>
                </th>
                {{-- <th class="text-right">{{ formatRp($groupedFeatures->sum('price')) }}</th> --}}
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
@endforeach

@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery-ui.min.js')) !!}
@endsection

@section('script')

<script>
(function() {
    $('.sort-features').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('toArray').toString();
            $.post("{{ route('projects.features-reorder', $project->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection