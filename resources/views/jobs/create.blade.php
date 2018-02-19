@extends('layouts.app')

@section('title', trans('job.create'))

@section('content')
@include('projects.partials.breadcrumb', ['title' => trans('job.create')])

<div class="row">
    <div class="col-sm-6">
        {!! Form::open(['route' => ['projects.jobs.store', $project->id]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('job.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('job.name')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', ['label' => trans('job.price'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('worker_id', $workers, ['label' => trans('job.worker'), 'value' => 1]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => trans('job.main'), trans('job.additional')], ['value' => 1, 'label' => trans('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => trans('job.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('job.create'), ['class' => 'btn btn-primary']) !!}
                {!! link_to_route('projects.jobs.index', trans('app.cancel'), [$project->id], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection
