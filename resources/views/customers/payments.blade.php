@extends('layouts.customer')

@section('title', __('customer.payments'))

@section('content-customer')
<div class="panel panel-default table-responsive">
    <table class="table table-condensed">
        <thead>
            <th class="table-no">{{ __('app.table_no') }}</th>
            <th class="col-md-3">{{ __('payment.project') }}</th>
            <th class="col-md-1 text-center">{{ __('app.type') }}</th>
            <th class="col-md-1 text-center">{{ __('app.date') }}</th>
            <th class="col-md-2 text-right">{{ __('payment.amount') }}</th>
            <th class="col-md-4">{{ __('payment.description') }}</th>
            <th class="col-md-1 text-center">{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($payments as $key => $payment)
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td>
                    {{ link_to_route(
                        'projects.payments',
                        $payment->project->name,
                        [$payment->project_id],
                        ['title' => __('project.view_payments')]
                    ) }}
                </td>
                <td class="text-center"><strong class="text-success">{{ $payment->type() }}</strong></td>
                <td class="text-center">{{ $payment->date }}</td>
                <td class="text-right">{{ $payment->present()->amount }}</td>
                <td>{{ $payment->description }}</td>
                <td class="text-center">
                    {!! html_link_to_route('payments.show', '', [$payment->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => __('app.show')]) !!}
                    {!! html_link_to_route('payments.pdf', '', [$payment->id], ['icon' => 'print', 'class' => 'btn btn-warning btn-xs', 'title' => __('app.print')]) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ __('payment.not_found') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">{{ __('app.total') }}</th>
                <th class="text-right">{{ format_money($payments->sum('amount')) }}</th>
                <th colspan="2">&nbsp;</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

@section('ext_css')
<style>
th.table-no, td.table-no {
    min-width: 2%;
    text-align: center;
}
</style>
@endsection
