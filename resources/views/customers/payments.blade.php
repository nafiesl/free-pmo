@extends('layouts.customer')

@section('title', trans('customer.payments'))

@section('content-customer')
<div class="panel panel-default table-responsive">
    <table class="table table-condensed">
        <thead>
            <th class="table-no">{{ trans('app.table_no') }}</th>
            <th class="col-md-2">{{ trans('payment.project') }}</th>
            <th class="col-md-2 text-center">{{ trans('payment.type') }}</th>
            <th class="col-md-1 text-center">{{ trans('app.date') }}</th>
            <th class="col-md-2 text-right">{{ trans('payment.amount') }}</th>
            <th class="col-md-4">{{ trans('payment.description') }}</th>
            <th class="col-md-1 text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($payments as $key => $payment)
            <tr>
                <td class="text-center">{{ $payments->firstItem() + $key }}</td>
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
                    {!! html_link_to_route('payments.show', '', [$payment->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => trans('app.show')]) !!}
                    {!! html_link_to_route('payments.pdf', '', [$payment->id], ['icon' => 'print', 'class' => 'btn btn-warning btn-xs', 'title' => trans('app.print')]) !!}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">{{ trans('payment.not_found') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $payments->appends(Request::except('page'))->render() }}
@endsection

@section('ext_css')
<style>
th.table-no, td.table-no {
    min-width: 2%;
    text-align: center;
}
</style>
@endsection
