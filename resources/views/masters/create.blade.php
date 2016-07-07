@extends('layouts.app')

@section('title', trans('master.create'))

@section('content')
<div class="row"><br>
    <div class="col-md-4">
        {!! Form::open(['route'=>'masters.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('master.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name',['label'=> trans('app.name')]) !!}
                {!! FormField::textarea('description',['label'=> trans('app.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('master.create'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('masters.index', trans('app.cancel'), [], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection