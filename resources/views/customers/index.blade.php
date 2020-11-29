@extends('layouts.app')

@section('title', __('customer.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('customers.create', __('customer.create'), [], ['class' => 'btn btn-success']) }}
    </div>
    {{ __('customer.list') }}
    <small>{{ __('app.total') }} : {{ $customers->total() }} {{ __('customer.customer') }}</small>
</h1>

<div class="panel panel-default table-responsive">
    <div class="panel-heading">
        {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
        {!! FormField::text('q', ['value' => request('q'), 'label' => __('customer.search'), 'class' => 'input-sm']) !!}
        {{ Form::submit(__('customer.search'), ['class' => 'btn btn-sm']) }}
        {{ link_to_route('customers.index', __('app.reset')) }}
        {{ Form::close() }}
    </div>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class="text-center">{{ __('app.table_no') }}</th>
                <th>{{ __('customer.name') }}</th>
                <th>{{ __('contact.email') }}</th>
                <th>{{ __('contact.phone') }}</th>
                <th class="text-center">{{ __('customer.projects_count') }}</th>
                <th class="text-center">{{ __('app.status') }}</th>
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
