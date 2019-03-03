@extends('layouts.project')

@section('subtitle', __('project.issues'))

@section('content-project')
<div id="project-issues" class="panel panel-default table-responsive">
    <div class="panel-heading">
        <h3 class="panel-title">{{ __('project.issues') }}</h3>
    </div>
    <table class="table table-condensed table-striped">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('issue.name') }}</th>
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
                <td class="text-center">&nbsp;</td>
            </tr>
            @empty
            <tr><td colspan="3">{{ __('issue.empty') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
