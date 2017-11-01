@extends('layouts.app')

@section('title', trans('vendor.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('vendors.index', trans('vendor.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
    </div>
    {{ trans('vendor.list') }}
    <small>{{ trans('app.total') }} : {{ $vendors->total() }} {{ trans('vendor.vendor') }}</small>
</h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
                {!! FormField::text('q', ['value' => request('q'), 'label' => trans('vendor.search'), 'class' => 'input-sm']) !!}
                {{ Form::submit(trans('vendor.search'), ['class' => 'btn btn-sm']) }}
                {{ link_to_route('vendors.index', trans('app.reset')) }}
                {{ Form::close() }}
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('vendor.name') }}</th>
                        <th>{{ trans('vendor.description') }}</th>
                        <th class="text-center">{{ trans('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $key => $vendor)
                    <tr>
                        <td class="text-center">{{ $vendors->firstItem() + $key }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->description }}</td>
                        <td class="text-center">
                            {!! link_to_route(
                                'vendors.index',
                                trans('app.edit'),
                                ['action' => 'edit', 'id' => $vendor->id] + Request::only('page', 'q'),
                                ['id' => 'edit-vendor-' . $vendor->id]
                            ) !!} |
                            {!! link_to_route(
                                'vendors.index',
                                trans('app.delete'),
                                ['action' => 'delete', 'id' => $vendor->id] + Request::only('page', 'q'),
                                ['id' => 'del-vendor-' . $vendor->id]
                            ) !!}
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
