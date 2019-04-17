@extends('layouts.project')

@section('subtitle', __('issue.update'))

@section('action-buttons')
@can('create', new App\Entities\Projects\Issue)
    {!! html_link_to_route('projects.issues.create', __('issue.create'), $project, ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')
<div class="row">
    <div class="col-sm-6 col-sm-offset-2">
        @if (request('action') == 'delete' && $issue)
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ __('issue.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label text-primary">{{ __('issue.title') }}</label>
                    <p>{{ $issue->title }}</p>
                    <label class="control-label text-primary">{{ __('issue.body') }}</label>
                    <p>{{ $issue->body }}</p>
                    {!! $errors->first('issue_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="panel-body text-danger">{{ __('issue.delete_confirm') }}</div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['projects.issues.destroy', $project, $issue]],
                        __('app.delete_confirm_button'),
                        ['id' => 'delete-issue-'.$issue->id, 'class' => 'btn btn-danger'],
                        ['issue_id' => $issue->id]
                    ) !!}
                    {{ link_to_route('projects.issues.edit', __('app.cancel'), [$project, $issue], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        @else
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
                    {{ link_to_route('projects.issues.edit', __('app.delete'), [$project, $issue, 'action' => 'delete'], ['id' => 'delete-issue-'.$issue->id, 'class' => 'btn btn-danger pull-right']) }}
                </div>
            </div>
            {{ Form::close() }}
        @endif
    </div>
</div>
@endsection
