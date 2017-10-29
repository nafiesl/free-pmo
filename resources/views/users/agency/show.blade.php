@extends('layouts.app')

@section('title', trans('agency.agency'))

@section('content')
<ul class="breadcrumb hidden-print">
    <li class="active">{{ trans('agency.agency') }}</li>
</ul>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <table class="table">
                <tr><th class="col-xs-4">{{ trans('agency.name') }}</th><td>{{ $agency->name }}</td></tr>
                <tr><th>{{ trans('agency.email') }}</th><td>{{ $agency->email }}</td></tr>
                <tr><th>{{ trans('agency.phone') }}</th><td>{{ $agency->phone }}</td></tr>
                <tr><th>{{ trans('agency.address') }}</th><td>{{ $agency->address }}</td></tr>
                <tr><th>{{ trans('agency.website') }}</th><td>{{ $agency->website }}</td></tr>
            </table>
            <div class="panel-footer">
                {{ link_to_route('users.agency.edit', trans('agency.edit'), [], ['class' => 'btn btn-info']) }}
            </div>
        </div>
    </div>
</div>
@endsection
