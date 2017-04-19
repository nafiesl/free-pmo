@extends('layouts.app')

@section('content')
<h1 class="page-header">
    {{ trans('option.options') }}
</h1>

<div class="row">
    <div class="col-md-8">
        {!! Form::open(['route'=>'options.save', 'method'=>'patch']) !!}
        <table class="table table-condensed">
            <tbody>
                @forelse($options as $option)
                <tr>
                    <td>
                        {{ str_split_ucwords($option->key) }}
                        {!! link_to_route('options.index', 'x', ['id' => $option->id,'action' => 'del'], ['class'=>'btn btn-danger btn-xs pull-right']) !!}
                    </td>
                    <td>{!! Form::textarea($option->key, $option->value, ['class'=>'form-control','rows'=>3]) !!}</td>
                </tr>
                @empty
                <tr>
                    <td>No option found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="form-group">
            {!! Form::submit(trans('app.update'), ['class'=>'btn btn-warning']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="col-md-4">
        @if (Request::get('action') == 'del' && $editableOption)
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('option.delete') }}</h3></div>
            <div class="panel-body">
                <p>{{ trans('app.delete_confirm') }}</p>
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ str_split_ucwords($editableOption->key) }}</th><td>{{ $editableOption->value }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                {!! FormField::delete(['route'=>['options.destroy',$editableOption->id]], trans('app.delete'), ['class'=>'btn btn-danger'], ['option_id'=>$option->id]) !!}
                {!! link_to_route('options.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
        @endif
        {!! Form::open(['route'=>'options.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Option Data</h3></div>
            <div class="panel-body">
                {!! FormField::text('key') !!}
                {!! FormField::textarea('value') !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('app.add'), ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
