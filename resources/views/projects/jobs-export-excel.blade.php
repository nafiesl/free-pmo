<?php
    // $filename = str_slug(trans('project.jobs') . '-' . $project->name) . '.xls';
    // header("Content-Disposition: attachment; filename=\"$filename\"");
    // header("Content-Type: application/vnd.ms-excel");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $project->name }}</title>
    <style>
        table {
            border-collapse:collapse;
        }
        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <table border="1" class="table table-condensed table-striped">
        <thead>
            <tr>
                <td colspan="4" style="text-align:center">
                    <strong>{{ trans('project.jobs') }} {{ $project->name }}</strong>
                </td>
            </tr>
            <tr>
                <th>{{ trans('app.table_no') }}</th>
                <th>{{ trans('job.name') }}</th>
                <th class="text-right">{{ trans('job.price') }}</th>
                <th>{{ trans('app.description') }}</th>
            </tr>
        </thead>
        <tbody id="sort-jobs">
            @forelse($jobs as $key => $job)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>
                    {{ $job->name }}
                </td>
                <td class="text-right">{{ $job->price }}</td>
                <td style="wrap-text: true;">{!! nl2br($job->description) !!}</td>
            </tr>

            @if ($job->tasks->count())
            @foreach($job->tasks as $task)
            <tr>
                <td></td>
                <td>{{ $task->name }}</td>
                <td></td>
                <td style="wrap-text: true;">{!! nl2br($task->description) !!}</td>
            </tr>
            @endforeach
            @endif
            @empty
            <tr><td colspan="7">{{ trans('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-right">{{ $jobs->sum('price') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
