@extends('layouts.app')

@section('title', trans('project.files') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb',['title' => trans('project.files')])

<h1 class="page-header">
    {{ $project->name }} <small>{{ trans('project.files') }}</small>
</h1>

@include('projects.partials.nav-tabs')
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans('project.files') }}</h3>
            </div>
            <table class="table table-condensed table-striped">
                <thead>
                    <th>{{ trans('app.table_no') }}</th>
                    <th>{{ trans('file.title') }}</th>
                    <th class="text-center">{{ trans('file.description') }}</th>
                    <th class="text-center">{{ trans('app.action') }}</th>
                </thead>
                <tbody class="sort-files">
                    @forelse($files as $key => $file)
                    <tr id="{{ $file->id }}">
                        <td>{{ 1 + $key }}</td>
                        <td>{{ $file->title }}</td>
                        <td>{{ $file->description }}</td>
                        <td class="text-center"></td>
                    </tr>
                    @empty
                    <tr><td colspan="4">{{ trans('file.empty') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Upload new File</h3></div>
            <div class="panel-body">
                {!! Form::open(['route' => ['files.upload', $project->id], 'id' => 'upload-files', 'files' => true]) !!}
            {{ Form::hidden('fileable_type', get_class($project)) }}
            {!! FormField::file('files', ['label' => 'Upload File', 'placeholder' => 'Pilih File']) !!}
            {!! FormField::text('title') !!}
            {!! FormField::textarea('description') !!}
            {!! Form::submit(trans('app.upload_files'), ['class' => 'btn btn-info']) !!}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


@endsection