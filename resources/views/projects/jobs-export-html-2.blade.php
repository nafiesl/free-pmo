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
    <title>{{ trans('project.jobs') }} {{ $project->name }}</title>
    {!! Html::style('assets/css/app.s.css') !!}
</head>
<body style="font-family:'Liberation Serif';font-size: 16px;">
    <div class="container">
        <h1 class="page-header text-center">{{ trans('project.jobs') }} {{ $project->name }}</h1>

        @foreach($jobs as $key => $job)
        <h2 class="job-title">{{ ++$key }}. {{ $job->name }}</h2>
        <p style="padding-left: 30px">{!! nl2br($job->description) !!}</p>
        @if ($job->tasks->count())
            <div style="padding-left: 30px">
                <h3>Sub Fitur</h3>
                @foreach($job->tasks as $taskKey => $task)
                <h4>{{ ++$taskKey }}) {{ $task->name }}</h4>
                <p style="padding-left: 21px">{!! nl2br($task->description) !!}</p>
                @endforeach
            </div>
        @endif
        @endforeach

        <h1 class="page-header text-center">{{ trans('project.cost_proposal') }}</h1>
        <table width="100%" class="table table-condensed table-bordered">
            <tbody>
                <tr>
                    <th class="text-center">{{ trans('app.table_no') }}</th>
                    <th>{{ trans('job.name') }}</th>
                    <th class="text-center">{{ trans('job.price') }}</th>
                </tr>
                @foreach($jobs as $key => $job)
                <tr>
                    <td class="text-center">{{ 1 + $key }}</td>
                    <td>{{ $job->name }}</td>
                    <td class="text-right">{{ formatRp($job->price) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="2">Total</th>
                    <th class="text-right">{{ formatRp($jobs->sum('price')) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
