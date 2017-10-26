@extends('layouts.app')

@section('title', trans('customer.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('customers.index', trans('customer.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
    </div>
    {{ trans('customer.list') }}
    <small>{{ trans('app.total') }} : {{ $customers->total() }} {{ trans('customer.customer') }}</small>
</h1>
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
                {!! FormField::text('q', ['value' => request('q'), 'label' => trans('customer.search'), 'class' => 'input-sm']) !!}
                {{ Form::submit(trans('customer.search'), ['class' => 'btn btn-sm']) }}
                {{ link_to_route('customers.index', trans('app.reset')) }}
                {{ Form::close() }}
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('customer.name') }}</th>
                        <th>{{ trans('contact.email') }}</th>
                        <th>{{ trans('contact.phone') }}</th>
                        <th class="text-center">{{ trans('app.status') }}</th>
                        <th class="text-center">{{ trans('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $key => $customer)
                    <tr>
                        <td class="text-center">{{ $customers->firstItem() + $key }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td class="text-center">{{ $customer->is_active }}</td>
                        <td class="text-center">
                            {!! link_to_route(
                                'customers.index',
                                trans('app.edit'),
                                ['action' => 'edit', 'id' => $customer->id] + Request::only('page', 'q'),
                                ['id' => 'edit-customer-' . $customer->id]
                            ) !!} |
                            {!! link_to_route(
                                'customers.index',
                                trans('app.delete'),
                                ['action' => 'delete', 'id' => $customer->id] + Request::only('page', 'q'),
                                ['id' => 'del-customer-' . $customer->id]
                            ) !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-body">{{ $customers->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        @includeWhen(Request::has('action'), 'customers.forms')
    </div>
</div>
@endsection
