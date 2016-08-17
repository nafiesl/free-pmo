<?php
// $filename = str_slug(trans('project.features') . '-' . $project->name) . '.xls';
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
    {!! Html::style('assets/css/app.css') !!}
</head>
<body>
    <div class="container">
        <h1 class="page-header text-center">{{ trans('project.features') }} {{ $project->name }}</h1>

        @foreach($features as $key => $feature)
        <h2 class="feature-title">{{ $feature->name }}</h2>
        <table class="table table-condensed table-bordered">
            <tbody>
                <tr style="background-color: #FFCC00"><th colspan="2">{{ trans('app.description') }}</th></tr>
                <tr><td colspan="2">{!! nl2br($feature->description) !!}</td></tr>

                @if ($feature->tasks->count())
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr style="background-color: #FFCC00">
                    <th class="col-md-3">Sub Fitur</th>
                    <th class="col-md-6">{{ trans('app.description') }}</th>
                </tr>
                    @foreach($feature->tasks as $task)
                    <tr>
                        <td>{{ $task->name }}</td>
                        <td>{!! nl2br($task->description) !!}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @endforeach

        <h1 class="page-header text-center">Biaya Pembuatan</h1>
        <table class="table table-condensed table-bordered">
            <tbody>
                <tr>
                    <th class="text-center">{{ trans('app.table_no') }}</th>
                    <th>{{ trans('feature.name') }}</th>
                    <th class="text-center">{{ trans('feature.price') }}</th>
                </tr>
                @foreach($features as $key => $feature)
                <tr>
                    <td class="text-center">{{ 1 + $key }}</td>
                    <td>{{ $feature->name }}</td>
                    <td class="text-right">{{ formatRp($feature->price) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="2">Total</th>
                    <th class="text-right">{{ formatRp($features->sum('price')) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>