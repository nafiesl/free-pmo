@extends('layouts.app')

@section('title', trans('project.jobs'))

@section('content')
<h1 class="page-header">
    Daftar Fitur on Progress
</h1>

<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('project.name') }}</th>
            <th>{{ trans('job.name') }}</th>
            <th class="text-center">{{ trans('job.tasks_count') }}</th>
            <th class="text-center">{{ trans('job.progress') }}</th>
            <th class="text-right">{{ trans('job.price') }}</th>
            <th>{{ trans('job.worker') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($jobs as $key => $job)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $job->project->name }}</td>
                <td>
                    {{ $job->name }}
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
                <td class="text-center">{{ formatDecimal($job->progress = $job->tasks->avg('progress')) }} %</td>
                <td class="text-right">{{ formatRp($job->price) }}</td>
                <td>{{ $job->worker->name }}</td>
                <td>
                    {!! link_to_route('jobs.show', trans('app.show'),[$job->id],['class' => 'btn btn-info btn-xs']) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="3">Total</th>
                <th class="text-center">{{ $jobs->sum('tasks_count') }}</th>
                <th class="text-center">{{ formatDecimal($jobs->avg('progress')) }} %</th>
                <th class="text-right">{{ formatRp($jobs->sum('price')) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
