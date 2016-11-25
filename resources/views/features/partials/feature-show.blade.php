<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('feature.show') }}</h3></div>
    <table class="table table-condensed">
        <tbody>
            <tr><th class="col-md-3">{{ trans('feature.name') }}</th><td class="col-md-9">{{ $feature->name }}</td></tr>
            <tr><th>{{ trans('feature.type') }}</th><td>{{ $feature->type() }}</td></tr>
            <tr><th>{{ trans('feature.price') }}</th><td>{{ formatRp($feature->price) }}</td></tr>
            <tr><th>{{ trans('feature.tasks_count') }}</th><td>{{ $feature->tasks->count() }}</td></tr>
            <tr><th>{{ trans('feature.progress') }}</th><td>{{ formatDecimal($feature->tasks->avg('progress')) }}%</td></tr>
            <tr><th>{{ trans('feature.worker') }}</th><td>{{ $feature->worker->name }}</td></tr>
            <tr><th>{{ trans('feature.description') }}</th><td>{!! nl2br($feature->description) !!}</td></tr>
        </tbody>
    </table>
</div>