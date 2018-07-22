@extends('layouts.project')

@section('action-buttons')
@can('update', $project)
    {!! link_to_route('projects.edit', __('project.edit'), $project, ['class' => 'btn btn-warning']) !!}
@endcan
{!! link_to_route('projects.index', __('project.back_to_index'), ['status_id' => $project->status_id], ['class' => 'btn btn-default']) !!}
@endsection

@section('content-project')

<div class="row">
    <div class="col-md-6">
        @include('projects.partials.project-show')
    </div>
    <div class="col-md-6">
        @can('update', $project)
        {!! Form::model($project, ['route' => ['projects.status-update', $project], 'method' => 'patch', 'class' => 'well well-sm form-inline']) !!}
        {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => __('project.status')]) !!}
        {!! Form::submit(__('project.update_status'), ['class' => 'btn btn-info btn-sm']) !!}
        {!! Form::close() !!}
        @endcan
        @include('projects.partials.project-stats')
    </div>
</div>

@endsection
