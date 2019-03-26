@inject('priorities', 'App\Entities\Projects\Priority')
@inject('issueStatuses', 'App\Entities\Projects\IssueStatus')
@extends('layouts.project')

@section('subtitle', __('project.issues'))

@section('action-buttons')
{{ Form::open(['method' => 'get', 'class' => 'form-inline', 'style' => 'display:inline']) }}
{!! FormField::select('priority_id', $priorities::toArray(), ['label' => false, 'placeholder' => __('issue.all_priority'), 'value' => request('priority_id')]) !!}
{!! FormField::select('status_id', $issueStatuses::toArray(), ['label' => false, 'placeholder' => __('issue.all_status'), 'value' => request('status_id')]) !!}
{{ Form::submit(__('app.filter'), ['class' => 'btn btn-info']) }}
@if (request(['priority_id', 'status_id']))
    {{ link_to_route('projects.issues.index', __('app.reset'), $project, ['class' => 'btn btn-default']) }}
@endif
{{ Form::close() }}
@can('create', new App\Entities\Projects\Issue)
    {!! html_link_to_route('projects.issues.create', __('issue.create'), $project, ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')
<div id="project-issues" class="panel panel-default table-responsive">
    <div class="panel-heading">
        <h3 class="panel-title">{{ __('project.issues') }}</h3>
    </div>
    <table class="table table-condensed table-striped">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('issue.title') }}</th>
            <th>{{ __('issue.priority') }}</th>
            <th>{{ __('app.status') }}</th>
            <th class="text-center">{{ __('comment.comment') }}</th>
            <th>{{ __('issue.pic') }}</th>
            <th>{{ __('issue.creator') }}</th>
            <th>{{ __('app.last_update') }}</th>
            <th class="text-center">{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($issues as $key => $issue)
            @php
            $no = 1 + $key;
            @endphp
            <tr id="{{ $issue->id }}">
                <td>{{ $no }}</td>
                <td>{{ $issue->title }}</td>
                <td>{!! $issue->priority_label !!}</td>
                <td>{!! $issue->status_label !!}</td>
                <td class="text-center">{{ $issue->comments_count }}</td>
                <td>{{ $issue->pic->name }}</td>
                <td>{{ $issue->creator->name }}</td>
                <td>{{ $issue->updated_at->diffForHumans() }}</td>
                <td class="text-center">
                    {{ link_to_route(
                        'projects.issues.show',
                        __('app.show'),
                        [$project, $issue],
                        ['title' => __('issue.show')]
                    ) }}
                </td>
            </tr>
            @empty
            <tr><td colspan="9">{{ __('issue.not_found') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
