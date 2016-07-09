@extends('layouts.app')

@section('title', trans('feature.create'))

@section('content')
@include('projects.partials.breadcrumb',['title' => trans('feature.create')])

<div class="row">
    <div class="col-sm-6">
        {!! Form::open(['route'=>['features.store', $project->id]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('feature.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name',['label'=> trans('feature.name')]) !!}
                {!! FormField::textarea('description',['label'=> trans('feature.description')]) !!}
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::price('price', ['label'=> trans('feature.price')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::select('worker_id', $workers, ['label'=> trans('feature.worker'),'value' => 1]) !!}
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('feature.create'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('projects.features', trans('app.cancel'), [$project->id], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection