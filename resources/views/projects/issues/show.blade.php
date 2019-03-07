@extends('layouts.project')

@section('subtitle', __('issue.detail'))

@section('content-project')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('issue.detail') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th class="col-md-4">{{ __('issue.title') }}</th><td class="col-md-8">{{ $issue->title }}</td></tr>
                    <tr><th>{{ __('issue.body') }}</th><td>{{ $issue->body }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {{ link_to_route('projects.issues.edit', __('issue.edit'), [$project, $issue], ['id' => 'edit-issue-'.$issue->id, 'class' => 'btn btn-warning']) }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        {{ Form::model($issue, ['route' => ['issues.pic.update', $issue], 'method' => 'patch']) }}
        {!! FormField::select('pic_id', $users, ['label' => __('issue.assign_pic')]) !!}
        {{ Form::submit(__('issue.assign_pic'), ['class' => 'btn btn-success']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
