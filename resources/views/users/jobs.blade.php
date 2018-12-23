@extends('layouts.user')

@section('subtitle', trans('user.jobs'))

@section('content-user')
<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('project.name') }}</th>
            <th>{{ trans('job.name') }}</th>
            <th class="text-center">{{ trans('job.tasks_count') }}</th>
            <th class="text-center">{{ trans('job.progress') }}</th>
            <th class="text-right">{{ trans('job.price') }}</th>
            <th class="text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($jobs as $key => $job)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $job->project->nameLink() }}</td>
                <td>
                    {{ $job->nameLink() }}
                    @if ($job->tasks->isEmpty() == false)
                    <ul>
                        @foreach($job->tasks as $task)
                        <li style="cursor:pointer" title="{{ $task->progress }} %">
                            <i class="fa fa-battery-{{ ceil(4 * $task->progress/100) }}"></i>
                            {{ $task->name }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td class="text-center">{{ $job->tasks_count = $job->tasks->count() }}</td>
                <td class="text-center">{{ format_decimal($job->progress = $job->progress) }} %</td>
                <td class="text-right">{{ format_money($job->price) }}</td>
                <td class="text-center">
                    {!! html_link_to_route('jobs.show', '', [$job], [
                        'icon' => 'search',
                        'class' => 'btn btn-info btn-xs',
                        'title' => trans('job.show')
                    ]) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('job.empty') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
