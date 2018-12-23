<?php
    // $filename = str_slug(__('project.jobs') . '-' . $project->name) . '.xls';
    // header("Content-Disposition: attachment; filename=\"$filename\"");
    // header("Content-Type: application/vnd.ms-excel");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ __('project.jobs') }} {{ $project->name }}</title>
    {!! Html::style('assets/css/app.css') !!}
</head>
<body style="font-family:'Liberation Serif'; font-size: 16px;">
    <div class="container">
        <h1 class="page-header text-center">{{ __('project.jobs') }} {{ $project->name }}</h1>

        <h2 class="text-center">{{ __('project.progress') }}</h2>
        <table width="100%" class="table table-condensed table-bordered">
            <tbody>
                <tr>
                    <th class="text-center">{{ __('app.table_no') }}</th>
                    <th>{{ __('job.name') }}</th>
                    <th class="text-center">{{ __('job.price') }}</th>
                    <th class="text-center">{{ __('job.progress') }}</th>
                    <th class="text-center">{{ __('project.receiveable_earnings') }}</th>
                </tr>
                @foreach($jobs as $key => $job)
                <tr>
                    <td class="text-center">{{ 1 + $key }}</td>
                    <td>{{ $job->name }}</td>
                    <td class="text-right">{{ format_money($job->price) }}</td>
                    <td class="text-right">{{ format_decimal($job->progress) }} %</td>
                    <td class="text-right">{{ format_money($job->receiveable_earning) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="2">{{ __('app.total') }}</th>
                    <th class="text-right">{{ format_money($jobs->sum('price')) }}</th>
                    <th class="text-right">{{ format_decimal($project->getJobOveralProgress()) }} %</th>
                    <th class="text-right">{{ format_money($jobs->sum('receiveable_earning')) }}</th>
                </tr>
            </tfoot>
        </table>
        <div style="margin-bottom: 50px;">
            <p>{{ __('app.remark') }}:</p>
            <p>
                <strong>{{ __('project.earnings_calculation') }} : </strong><br>
                <strong>{{ __('project.receiveable_earnings') }}</strong> = <strong>{{ __('job.price') }}</strong> * <strong>{{ __('job.progress') }} (%)</strong>
            </p>
        </div>
    </div>
</body>
</html>
