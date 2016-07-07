@extends('layouts.app')

@section('content')
<h1 class="page-header">{{ trans('option.create') }}</h1>
<div class="row">
    <div class="col-md-4">
        {!! Form::open(['route'=>'options.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Option Data</h3></div>
            <div class="panel-body">
                <div class="form-group {!! $errors->has('key') ? 'has-error' : ''; !!}">
                    {!! Form::label('key', trans('option.key'), ['class'=>'control-label']) !!}
                    {!! Form::text('key', null, ['class'=>'form-control']) !!}
                    {!! $errors->first('key', '<span class="form-error">:message</span>') !!}
                </div>

                <div class="form-group {!! $errors->has('value') ? 'has-error' : ''; !!}">
                    {!! Form::label('value', trans('option.value'), ['class'=>'control-label']) !!}
                    {!! Form::textarea('value', null, ['class'=>'form-control','rows'=>5]) !!}
                    {!! $errors->first('value', '<span class="form-error">:message</span>') !!}
                </div>
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('app.submit'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('options.index', trans('app.cancel'), [], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection