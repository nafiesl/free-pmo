@extends('layouts.customer')

@section('content-customer')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <tbody>
                    <tr><td class="col-xs-3">{{ trans('customer.name') }}</td><td>{{ $customer->name }}</td></tr>
                    <tr><td>{{ trans('contact.email') }}</td><td>{{ $customer->email }}</td></tr>
                    <tr><td>{{ trans('contact.phone') }}</td><td>{{ $customer->phone }}</td></tr>
                    <tr><td>{{ trans('customer.pic') }}</td><td>{{ $customer->pic }}</td></tr>
                    <tr><td>{{ trans('address.address') }}</td><td>{{ $customer->address }}</td></tr>
                    <tr><td>{{ trans('app.status') }}</td><td>{!! $customer->status_label !!}</td></tr>
                    <tr><td>{{ trans('app.notes') }}</td><td>{!! nl2br($customer->notes) !!}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <a href="{{ route('customers.projects', $customer) }}" title="{{ __('customer.projects_count') }}">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3"><i class="fa fa-table fa-4x"></i></div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $customer->projects()->count() }}</div>
                                    <div class="lead">{{ __('customer.projects_count') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
