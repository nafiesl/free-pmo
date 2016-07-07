@extends('layouts.app')

@section('content')
<h1 class="page-header">
    {!! link_to_route('options.create', trans('option.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    Options
</h1>

{!! Form::open(['route'=>'options.save', 'method'=>'patch']) !!}
<table class="table table-condensed">
    <tbody>
        @forelse($options as $option)
        <tr>
            <td>
                {{ str_split_ucwords($option->key) }}
                {!! link_to_route('options.delete', 'x', [$option->id], ['class'=>'btn btn-danger btn-xs pull-right']) !!}
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
@endsection
