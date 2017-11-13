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
<body style="font-family:'Liberation Serif'">
    <div class="container">
        <h1 class="page-header text-center">{{ trans('project.jobs') }} {{ $project->name }}</h1>

        @foreach($jobs as $key => $job)
        <h2 class="job-title">{{ $job->name }}</h2>
        <table width="100%" class="table table-condensed table-bordered">
            <tbody>
                <tr style="background-color: #ffd298"><th colspan="2">{{ trans('app.description') }}</th></tr>
                <tr><td colspan="2">{!! nl2br($job->description) !!}</td></tr>

                @if ($job->tasks->count())
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr style="background-color: #ffd298">
                    <th class="col-md-3">Sub Fitur</th>
                    <th class="col-md-6">{{ trans('app.description') }}</th>
                </tr>
                    @foreach($job->tasks as $task)
                    <tr>
                        <td>{{ $task->name }}</td>
                        <td>{!! nl2br($task->description) !!}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
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
