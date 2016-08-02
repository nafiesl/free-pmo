@extends('layouts.app')

@section('title', trans('project.features'))

@section('content')
<h1 class="page-header">
    Daftar Fitur on Progress
</h1>

<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('project.name') }}</th>
            <th>{{ trans('feature.name') }}</th>
            <th class="text-center">{{ trans('feature.tasks_count') }}</th>
            <th class="text-center">{{ trans('feature.progress') }}</th>
            <th class="text-right">{{ trans('feature.price') }}</th>
            <th>{{ trans('feature.worker') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($features as $key => $feature)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $feature->project->name }}</td>
                <td>
                    {{ $feature->name }}
                    @if ($feature->tasks->isEmpty() == false)
                    <ul>
                        @foreach($feature->tasks as $task)
                        <li style="cursor:pointer" title="{{ $task->progress }} %">
                            <i class="fa fa-battery-{{ ceil(4 * $task->progress/100) }}"></i>
                            {{ $task->name }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td class="text-center">{{ $feature->tasks_count = $feature->tasks->count() }}</td>
                <td class="text-center">{{ formatDecimal($feature->progress = $feature->tasks->avg('progress')) }} %</td>
                <td class="text-right">{{ formatRp($feature->price) }}</td>
                <td>{{ $feature->worker->name }}</td>
                <td>
                    {!! link_to_route('features.show', trans('app.show'),[$feature->id],['class' => 'btn btn-info btn-xs']) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('feature.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="3">Total</th>
                <th class="text-center">{{ $features->sum('tasks_count') }}</th>
                <th class="text-center">{{ formatDecimal($features->avg('progress')) }} %</th>
                <th class="text-right">{{ formatRp($features->sum('price')) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection