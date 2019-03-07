@extends('layouts.project')

@section('subtitle', __('issue.update'))

@section('content-project')
<div class="row">
    <div class="col-sm-6 col-sm-offset-2">
        {{ Form::model($issue, ['route' => ['projects.issues.update', $project, $issue], 'method' => 'patch']) }}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('issue.update') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('title', ['label' => __('issue.title')]) !!}
                {!! FormField::textarea('body', ['label' => __('issue.body')]) !!}
            </div>
            <div class="panel-footer">
                {{ Form::submit(__('issue.update'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('projects.issues.show', __('app.cancel'), [$project, $issue], ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection
