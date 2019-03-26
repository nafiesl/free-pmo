@extends('layouts.project')

@section('subtitle', __('issue.create'))

@section('action-buttons')
@can('create', new App\Entities\Projects\Issue)
    {!! html_link_to_route('projects.issues.create', __('issue.create'), $project, ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')

<div class="row">
    <div class="col-sm-6 col-sm-offset-2">
        {{ Form::open(['route' => ['projects.issues.store', $project]]) }}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('issue.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('title', ['label' => __('issue.title')]) !!}
                {!! FormField::textarea('body', ['label' => __('issue.body')]) !!}
                {!! FormField::radios('priority_id', $priorities, ['label' => __('issue.priority'), 'placeholder' => false]) !!}
                {!! FormField::select('pic_id', $users, ['label' => __('issue.pic')]) !!}
            </div>
            <div class="panel-footer">
                {{ Form::submit(__('issue.create'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('projects.issues.index', __('app.cancel'), $project, ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection
