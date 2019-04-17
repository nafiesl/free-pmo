@extends('layouts.customer')

@section('title', trans('customer.subscriptions'))

@section('content-customer')

<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('subscription.name') }}</th>
            <th class="text-center">{{ trans('app.type') }}</th>
            <th>{{ trans('subscription.customer') }}</th>
            <th class="text-right">{{ trans('subscription.due_date') }}</th>
            <th class="text-right">{{ trans('subscription.extension_price') }}</th>
            <th>{{ trans('subscription.vendor') }}</th>
            <th class="text-center">{{ trans('app.status') }}</th>
        </thead>
        <tbody>
            @forelse($subscriptions as $key => $subscription)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $subscription->name_link }}</td>
                <td class="text-center">{!! $subscription->type_label !!}</td>
                <td>{{ $subscription->customer->name }}</td>
                <td class="text-right" title="{!! $subscription->dueDateDescription() !!}">
                    {{ date_id($subscription->due_date) }} {!! $subscription->nearOfDueDateSign() !!}
                </td>
                <td class="text-right">{{ format_money($subscription->price) }}</td>
                <td>{{ $subscription->vendor->name }}</td>
                <td class="text-center">{{ $subscription->status() }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">{{ trans('subscription.not_found') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
