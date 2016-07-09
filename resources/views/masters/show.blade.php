@extends('layouts.app')

@section('title', trans('master.show'))

@section('content')
<h1 class="page-header">{{ $master->name }} <small>{{ trans('master.show') }}</small></h1>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('master.show') }}</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ trans('master.name') }}</th><td>{{ $master->name }}</td></tr>
                        <tr><th>{{ trans('app.description') }}</th><td>{{ $master->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                {!! link_to_route('masters.edit', trans('app.edit'), [$master->id], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('masters.index', trans('master.back_to_index'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
</div>
@endsection