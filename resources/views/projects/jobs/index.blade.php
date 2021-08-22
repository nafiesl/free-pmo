@extends('layouts.project')

@section('subtitle', __('project.jobs'))

@section('action-buttons')
@can('create', new App\Entities\Projects\Job)
    {!! html_link_to_route('projects.jobs.create', __('job.create'), [$project], ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
    {!! html_link_to_route('projects.jobs.add-from-other-project', __('job.add_from_other_project'), [$project], ['class' => 'btn btn-default', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')

@if ($jobs->isEmpty())
<p>{{ __('project.no_jobs') }},
    {{ link_to_route('projects.jobs.create', __('job.create'), [$project]) }}.
</p>
@else

@foreach($jobs->groupBy('type_id') as $key => $groupedJobs)

<div id="project-jobs" class="panel panel-default table-responsive">
    <div class="panel-heading">
        <div class="pull-right">
            @can('update', $project)
                @if (request('action') == 'sort_jobs')
                    {{ link_to_route('projects.jobs.index', __('app.done'), [$project], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: -2px; margin-left: 6px; margin-right: -8px']) }}
                @else
                    {{ link_to_route('projects.jobs.index', __('project.sort_jobs'), [$project, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: -2px; margin-left: 6px; margin-right: -8px']) }}
                    @can('see-pricings', $project)
                    {!! link_to_route('projects.jobs-export', __('project.jobs_list_export_html'), [$project, 'html', 'job_type' => $key], ['class' => '', 'target' => '_blank']) !!} |
                    {!! link_to_route('projects.job-progress-export', __('project.jobs_progress_export_html'), [$project, 'html', 'job_type' => $key], ['class' => '', 'target' => '_blank']) !!}
                    @endcan
                @endif
            @endcan
        </div>
        <h3 class="panel-title">
            {{ $key == 1 ? __('project.jobs') : __('project.additional_jobs') }}
            @if (request('action') == 'sort_jobs')
            <em>: {{ __('project.sort_jobs') }}</em>
            @endif
        </h3>
    </div>
    @if (request('action') == 'sort_jobs')
        <ul class="sort-jobs list-group">
            @foreach($groupedJobs as $key => $job)
                <li id="{{ $job->id }}" class="list-group-item">
                    <i class="fa fa-arrows-v" style="margin-right: 15px"></i> {{ $key + 1 }}. {{ $job->name }}
                </li>
            @endforeach
        </ul>
    @else
    <table class="table table-condensed table-striped table-hover">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('job.name') }}</th>
            <th class="text-center">{{ __('job.tasks_count') }}</th>
            <th class="text-center">{{ __('job.progress') }}</th>
            @can('see-pricings', new App\Entities\Projects\Job)
            <th class="text-right">{{ __('job.price') }}</th>
            @endcan
            {{-- <th>{{ __('job.worker') }}</th> --}}
            <th class="text-center">{{ __('time.updated_at') }}</th>
            <th class="text-center">{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($groupedJobs as $key => $job)
            @php
            $no = 1 + $key;
            $job->progress = $job->tasks->avg('progress');
            @endphp
            <tr id="{{ $job->id }}" {!! $job->progress <= 50 ? 'style="background-color: #faebcc"' : '' !!}>
                <td>{{ $no }}</td>
                <td>
                    {{ $job->name }}
                    @if ($job->tasks->isEmpty() == false)
                    <ul>
                        @foreach($job->tasks as $task)
                        <li>{{ $task->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td class="text-center">{{ $job->tasks_count = $job->tasks->count() }}</td>
                <td class="text-center">{{ format_decimal($job->progress) }} %</td>
                @can('see-pricings', $job)
                <td class="text-right">{{ format_money($job->price) }}</td>
                @endcan
                <td class="text-center">
                    {{ $job->updated_at->diffForHumans() }} <br>
                    {{ __('job.worker') }} : {{ $job->worker->name }}
                </td>
                <td class="text-center">
                    @can('view', $job)
                    {!! html_link_to_route('jobs.show', '',[$job->id],['icon' => 'search', 'title' => __('job.show'), 'class' => 'btn btn-info btn-xs', 'id' => 'show-job-' . $job->id]) !!}
                    @endcan
                    @can('edit', $job)
                    {!! html_link_to_route('jobs.edit', '',[$job->id],['icon' => 'edit', 'title' => __('job.edit'), 'class' => 'btn btn-warning btn-xs']) !!}
                    @endcan
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ __('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-center">{{ $groupedJobs->sum('tasks_count') }}</th>
                <th class="text-center">
                    <span title="Total Progress">{{ format_decimal($groupedJobs->sum('progress') / $groupedJobs->count()) }} %</span>
                    <span title="Overal Progress" style="font-weight:300">({{ format_decimal($project->getJobOveralProgress()) }} %)</span>
                </th>
                @can('see-pricings', new App\Entities\Projects\Job)
                <th class="text-right">{{ format_money($groupedJobs->sum('price')) }}</th>
                @endcan
                <th colspan="2">
                    @can('update', $project)
                        @if (request('action') == 'sort_jobs')
                            {{ link_to_route('projects.jobs.index', __('app.done'), [$project->id], ['class' => 'btn btn-default btn-xs pull-right']) }}
                        @else
                            {{ link_to_route('projects.jobs.index', __('project.sort_jobs'), [$project->id, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn btn-default btn-xs pull-right']) }}
                        @endif
                    @endcan
                </th>
            </tr>
        </tfoot>
    </table>
    @endif
</div>
@endforeach

@endif
@endsection

@can('update', $project)
@if (request('action') == 'sort_jobs')

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery-ui.min.js')) !!}
@endsection

@section('script')

<script>
(function() {
    $('.sort-jobs').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('toArray').toString();
            $.post("{{ route('projects.jobs-reorder', $project->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection

@endif
@endcan
