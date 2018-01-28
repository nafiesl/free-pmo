@extends('layouts.app')

@section('title', trans('customer.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('customers.create', trans('customer.create'), [], ['class' => 'btn btn-success']) }}
    </div>
    {{ trans('customer.list') }}
    <small>{{ trans('app.total') }} : {{ $customers->total() }} {{ trans('customer.customer') }}</small>
</h1>

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
                <th class="text-center">{{ trans('customer.projects_count') }}</th>
                <th class="text-center">{{ trans('app.status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $key => $customer)
            <tr>
                <td class="text-center">{{ $customers->firstItem() + $key }}</td>
                <td>{{ $customer->nameLink() }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td class="text-center">
                    @if ($customer->projects_count)
                    {{ link_to_route('customers.projects', $customer->projects_count, $customer) }}
                    @endif
                </td>
                <td class="text-center">{!! $customer->status_label !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel-body">{{ $customers->appends(Request::except('page'))->render() }}</div>
    </div>
</div>
</div>
@endsection
