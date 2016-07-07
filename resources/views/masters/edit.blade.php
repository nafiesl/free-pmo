@extends('layouts.app')

@section('title', trans('master.edit'))

@section('content')
<div class="row"><br>
    <div class="col-md-4">
        {!! Form::model($master, ['route'=>['masters.update', $master->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $master->name }} <small>{{ trans('master.edit') }}</small></h3></div>
            <div class="panel-body">
                {!! FormField::text('name',['label'=> trans('app.name')]) !!}
                {!! FormField::textarea('description',['label'=> trans('app.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('master.update'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('masters.show', trans('app.show'), [$master->id], ['class' => 'btn btn-info']) !!}
                {!! link_to_route('masters.index', trans('master.back_to_index'), [], ['class' => 'btn btn-default']) !!}
                {!! link_to_route('masters.delete', trans('app.delete'), [$master->id], ['class'=>'btn btn-danger pull-right']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection