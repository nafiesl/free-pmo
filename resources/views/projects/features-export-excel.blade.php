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
    <style>
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
                    <h1>{{ trans('project.features') }} {{ $project->name }}</h1>
                </td>
            </tr>
            <tr>
                <th>{{ trans('app.table_no') }}</th>
                <th>{{ trans('feature.name') }}</th>
                {{-- <th class="text-center">{{ trans('feature.progress') }}</th> --}}
                <th class="text-right">{{ trans('feature.price') }}</th>
                <th>{{ trans('app.description') }}</th>
            </tr>
        </thead>
        <tbody id="sort-features">
            @forelse($features as $key => $feature)
            <tr>
                <td rowspan="{{ $feature->tasks->count() + 1 }}">{{ 1 + $key }}</td>
                <td>
                    {{ $feature->name }}
                </td>
                {{-- <td class="text-center">{{ formatDecimal($feature->progress = $feature->tasks->avg('progress')) }} %</td> --}}
                <td rowspan="{{ $feature->tasks->count() + 1 }}" class="text-right">{{ $feature->price }}</td>
                <td style="wrap-text: true;">{!! nl2br($feature->description) !!}</td>
            </tr>

            @if ($feature->tasks->count())
            @foreach($feature->tasks as $task)
            <tr>
                <td></td>
                <td>{{ $task->name }}</td>
                <td></td>
                <td style="wrap-text: true;">{!! nl2br($task->description) !!}</td>
            </tr>
            @endforeach
            @endif
            @empty
            <tr><td colspan="7">{{ trans('feature.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                {{-- <th class="text-center">{{ formatDecimal($features->avg('progress')) }} %</th> --}}
                <th class="text-right">{{ $features->sum('price') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>