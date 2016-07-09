<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('feature.show') }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <tbody>
                <tr><th>{{ trans('feature.name') }}</th><td>{{ $feature->name }}</td></tr>
                <tr><th>{{ trans('feature.price') }}</th><td>{{ formatRp($feature->price) }}</td></tr>
                <tr><th>{{ trans('feature.tasks_count') }}</th><td>{{ $feature->tasks->count() }}</td></tr>
                <tr><th>{{ trans('feature.progress') }}</th><td>{{ formatDecimal($feature->tasks->avg('progress')) }}%</td></tr>
                <tr><th>{{ trans('feature.worker') }}</th><td>{{ $feature->worker->name }}</td></tr>
                <tr><th>{{ trans('feature.description') }}</th><td>{!! nl2br($feature->description) !!}</td></tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        {!! link_to_route('features.edit', trans('feature.edit'), [$feature->id], ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('projects.features', trans('feature.back_to_index'), [$feature->project_id], ['class' => 'btn btn-default']) !!}
    </div>
</div>