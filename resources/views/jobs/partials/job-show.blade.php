<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('job.detail') }}</h3></div>
    <table class="table table-condensed">
        <tbody>
            <tr><th class="col-md-4">{{ __('job.name') }}</th><td class="col-md-8">{{ $job->name }}</td></tr>
            <tr><th>{{ __('job.type') }}</th><td>{{ $job->type() }}</td></tr>
            @can('see-pricings', $job)
            <tr><th>{{ __('job.price') }}</th><td>{{ format_money($job->price) }}</td></tr>
            @endcan
            <tr><th>{{ __('job.progress') }}</th><td>{{ format_decimal($job->progress) }}%</td></tr>
            <tr><th>{{ __('job.worker') }}</th><td>{{ $job->worker->name }}</td></tr>
            <tr><th>{{ __('time.updated_at') }}</th><td>{{ $job->updated_at }}</td></tr>
            <tr><th>{{ __('job.description') }}</th><td>{!! nl2br($job->description) !!}</td></tr>
        </tbody>
    </table>
</div>
