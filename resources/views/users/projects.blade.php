@extends('layouts.user')

@section('subtitle', trans('user.projects'))

@section('content-user')
<div class="well well-sm text-right">
    {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
    {!! FormField::select('status', ProjectStatus::toArray(), ['value' => request('status', 2), 'placeholder' => trans('project.all')]) !!}
    {!! Form::text('q', request('q'), ['class' => 'form-control index-search-field', 'placeholder' => trans('project.search'), 'style' => 'width:100%;max-width:350px']) !!}
    {!! Form::submit(trans('project.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {!! link_to_route('users.projects', trans('app.reset'), [$user], ['class' => 'btn btn-default btn-sm']) !!}
    {!! Form::close() !!}
</div>
<div class="table-responsive">
    <table class="table table-condensed table-hover">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('project.name') }}</th>
            <th class="text-center">{{ trans('project.start_date') }}</th>
            <th class="text-center">{{ trans('project.work_duration') }}</th>
            <th class="text-right">{{ trans('project.project_value') }}</th>
            <th class="text-center">{{ trans('app.status') }}</th>
            <th>{{ trans('project.customer') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($projects as $key => $project)
            <tr>
                <td>{{ $projects->firstItem() + $key }}</td>
                <td>{{ $project->nameLink() }}</td>
                <td class="text-center">{{ $project->start_date }}</td>
                <td class="text-right">{{ $project->work_duration }}</td>
                <td class="text-right">{{ format_money($project->project_value) }}</td>
                <td class="text-center">{{ $project->present()->status }}</td>
                <td>{{ $project->customer->name }}</td>
                <td>
                    {!! html_link_to_route('projects.show', '', [$project->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => trans('app.show')]) !!}
                    {!! html_link_to_route('projects.edit', '', [$project->id], ['icon' => 'edit', 'class' => 'btn btn-warning btn-xs', 'title' => trans('app.edit')]) !!}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">{{ trans('project.not_found') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $projects->appends(Request::except('page'))->render() }}
@endsection
