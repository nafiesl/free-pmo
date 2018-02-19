@extends('layouts.project')

@section('subtitle', trans('project.jobs'))

@section('action-buttons')
{!! html_link_to_route('projects.jobs.create', trans('job.create'), [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
{!! html_link_to_route('projects.jobs.add-from-other-project', trans('job.add_from_other_project'), [$project->id], ['class' => 'btn btn-default','icon' => 'plus']) !!}
@endsection

@section('content-project')

@if ($jobs->isEmpty())
<p>{{ trans('project.no_jobs') }},
    {{ link_to_route('projects.jobs.create', trans('job.create'), [$project->id]) }}.
</p>
@else

@foreach($jobs->groupBy('type_id') as $key => $groupedJobs)

<div id="project-jobs" class="panel panel-default table-responsive">
    <div class="panel-heading">
        <div class="pull-right">
            @if (request('action') == 'sort_jobs')
                {{ link_to_route('projects.jobs.index', trans('app.done'), [$project->id], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: -2px; margin-left: 6px; margin-right: -8px']) }}
            @else
                {{ link_to_route('projects.jobs.index', trans('project.sort_jobs'), [$project->id, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: -2px; margin-left: 6px; margin-right: -8px']) }}
                {!! link_to_route('projects.jobs-export', trans('project.jobs_list_export_html'), [$project->id, 'html', 'job_type' => $key], ['class' => '','target' => '_blank']) !!} |
                {!! link_to_route('projects.job-progress-export', trans('project.jobs_progress_export_html'), [$project->id, 'html', 'job_type' => $key], ['class' => '','target' => '_blank']) !!}
            @endif
        </div>
        <h3 class="panel-title">
            {{ $key == 1 ? trans('project.jobs') : trans('project.additional_jobs') }}
        </h3>
    </div>
    <table class="table table-condensed table-striped">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('job.name') }}</th>
            <th class="text-center">{{ trans('job.tasks_count') }}</th>
            <th class="text-center">{{ trans('job.progress') }}</th>
            <th class="text-right">{{ trans('job.price') }}</th>
            {{-- <th>{{ trans('job.worker') }}</th> --}}
            <th class="text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody class="sort-jobs">
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
                <td class="text-center">{{ formatDecimal($job->progress) }} %</td>
                <td class="text-right">{{ formatRp($job->price) }}</td>
                {{-- <td>{{ $job->worker->name }}</td> --}}
                <td class="text-center">
                    {!! html_link_to_route('jobs.show', '',[$job->id],['icon' => 'search', 'title' => 'Lihat ' . trans('job.show'), 'class' => 'btn btn-info btn-xs','id' => 'show-job-' . $job->id]) !!}
                    {!! html_link_to_route('jobs.edit', '',[$job->id],['icon' => 'edit', 'title' => trans('job.edit'), 'class' => 'btn btn-warning btn-xs']) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-center">{{ $groupedJobs->sum('tasks_count') }}</th>
                <th class="text-center">
                    <span title="Total Progress">{{ formatDecimal($groupedJobs->sum('progress') / $groupedJobs->count()) }} %</span>
                    <span title="Overal Progress" style="font-weight:300">({{ formatDecimal($project->getJobOveralProgress()) }} %)</span>
                </th>
                <th class="text-right">{{ formatRp($groupedJobs->sum('price')) }}</th>
                <th colspan="2">
                    @if (request('action') == 'sort_jobs')
                        {{ link_to_route('projects.jobs.index', trans('app.done'), [$project->id], ['class' => 'btn btn-default btn-xs pull-right']) }}
                    @else
                        {{ link_to_route('projects.jobs.index', trans('project.sort_jobs'), [$project->id, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn btn-default btn-xs pull-right']) }}
                    @endif
                </th>
            </tr>
        </tfoot>
    </table>
</div>
@endforeach

@endif
@endsection

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
