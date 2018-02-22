<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('job.detail') }}</h3></div>
    <table class="table table-condensed">
        <tbody>
            <tr><th class="col-md-4">{{ trans('job.name') }}</th><td class="col-md-8">{{ $job->name }}</td></tr>
            <tr><th>{{ trans('job.type') }}</th><td>{{ $job->type() }}</td></tr>
            @can('see-pricings', $job->project)
            <tr><th>{{ trans('job.price') }}</th><td>{{ formatRp($job->price) }}</td></tr>
            @endcan
            <tr><th>{{ trans('job.progress') }}</th><td>{{ formatDecimal($job->tasks->avg('progress')) }}%</td></tr>
            <tr><th>{{ trans('job.worker') }}</th><td>{{ $job->worker->name }}</td></tr>
            <tr><th>{{ trans('job.description') }}</th><td>{!! nl2br($job->description) !!}</td></tr>
        </tbody>
    </table>
</div>
