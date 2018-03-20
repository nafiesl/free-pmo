@extends('layouts.app')

@section('title', __('job.create'))

@section('content')
@include('projects.partials.breadcrumb', ['title' => __('job.create')])

<div class="row">
    <div class="col-sm-6">
        {!! Form::open(['route' => ['projects.jobs.store', $project->id]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('job.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => __('job.name')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', [
                            'label'    => __('job.price'),
                            'currency' => Option::get('money_sign', 'Rp'),
                            'value'    => 0,
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('worker_id', $workers, ['label' => __('job.worker'), 'value' => 1]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(__('job.create'), ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection
