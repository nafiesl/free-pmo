@extends('layouts.customer')

@section('title', trans('customer.projects'))

@section('content-customer')
<div class="panel panel-default table-responsive">
    <table class="table table-condensed table-hover">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('project.name') }}</th>
            <th class="text-center">{{ trans('project.start_date') }}</th>
            <th class="text-center">{{ trans('project.work_duration') }}</th>
            <th class="text-right">{{ trans('project.project_value') }}</th>
            <th class="text-center">{{ trans('app.status') }}</th>
            <th class="text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($projects as $key => $project)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $project->nameLink() }}</td>
                <td class="text-center">{{ $project->start_date }}</td>
                <td class="text-right">{{ $project->work_duration }}</td>
                <td class="text-right">{{ format_money($project->project_value) }}</td>
                <td class="text-center">{{ $project->present()->status }}</td>
                <td class="text-center">
                    {!! html_link_to_route('projects.show', '', [$project->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => trans('app.show')]) !!}
                    {!! html_link_to_route('projects.edit', '', [$project->id], ['icon' => 'edit', 'class' => 'btn btn-warning btn-xs', 'title' => trans('app.edit')]) !!}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">{{ trans('project.not_found') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
