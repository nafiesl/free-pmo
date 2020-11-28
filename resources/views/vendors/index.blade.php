@extends('layouts.app')

@section('title', __('vendor.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('vendors.index', __('vendor.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
    </div>
    {{ __('vendor.list') }}
    <small>{{ __('app.total') }} : {{ $vendors->total() }} {{ __('vendor.vendor') }}</small>
</h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
                {!! FormField::text('q', ['value' => request('q'), 'label' => __('vendor.search'), 'class' => 'input-sm']) !!}
                {{ Form::submit(__('vendor.search'), ['class' => 'btn btn-sm']) }}
                {{ link_to_route('vendors.index', __('app.reset')) }}
                {{ Form::close() }}
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('vendor.name') }}</th>
                        <th>{{ __('app.notes') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $key => $vendor)
                    <tr>
                        <td class="text-center">{{ $vendors->firstItem() + $key }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->notes }}</td>
                        <td class="text-center">
                            {{ link_to_route('vendors.show', __('app.show'), $vendor) }} |
                            {{ link_to_route(
                                'vendors.index',
                                __('app.edit'),
                                ['action' => 'edit', 'id' => $vendor->id] + request(['page', 'q']),
                                ['id' => 'edit-vendor-' . $vendor->id]
                            ) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-body">{{ $vendors->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        @includeWhen(Request::has('action'), 'vendors.forms')
    </div>
</div>
@endsection
