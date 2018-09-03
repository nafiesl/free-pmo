@extends('layouts.app')

@section('title', $vendor->name.' - '.__('vendor.detail'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! link_to_route('vendors.index', __('vendor.back_to_index'), [], ['class' => 'btn btn-default']) !!}
    </div>
    {{ $vendor->name }} <small>{{ __('vendor.detail') }}</small>
</h1>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <tbody>
                    <tr><td class="col-xs-3">{{ __('vendor.name') }}</td><td>{{ $vendor->name }}</td></tr>
                    <tr><td>{{ __('vendor.website') }}</td><td>{{ $vendor->website }}</td></tr>
                    <tr><td>{{ __('app.status') }}</td><td>{{ $vendor->status }}</td></tr>
                    <tr><td>{{ __('app.notes') }}</td><td>{!! nl2br($vendor->notes) !!}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
