@extends('layouts.app')

@section('title', __('job.edit'))

@section('content')
<div class="row"><br>
    <div class="col-md-6">
        {!! Form::model($job, ['route' => ['jobs.update', $job], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $job->name }} <small>{{ __('job.edit') }}</small></h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => __('job.name')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', ['label' => __('job.price'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('worker_id', $workers, ['label' => __('job.worker')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::hidden('project_id', $job->project_id) !!}
                {!! Form::submit(__('job.update'), ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('jobs.show', __('app.show'), [$job], ['class' => 'btn btn-info']) }}
                {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id], ['class' => 'btn btn-default']) }}
                {{ link_to_route('jobs.delete', __('job.delete'), [$job], ['class' => 'btn btn-danger pull-right']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show', ['project' => $job->project])
    </div>
</div>
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/autoNumeric.min.js')) !!}
@endsection
