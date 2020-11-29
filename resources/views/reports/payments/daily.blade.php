@extends('layouts.app')

@section('title', __('report.daily', ['date' => date_id($date)]))

@section('content')

@php $dt = Carbon\Carbon::parse($date); @endphp

<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('reports.payments.yearly', __('report.yearly', ['year' => $dt->year]), ['year' => $dt->year]) }}</li>
    <li>{{ link_to_route('reports.payments.monthly', get_months()[month_number($dt->month)], ['year' => $dt->year, 'month' => month_number($dt->month)]) }}</li>
    <li class="active">{{ $dt->format('d') }}</li>
</ul>

{{ Form::open(['method' => 'get', 'class' => 'form-inline well well-sm']) }}
{{ Form::label('date', __('report.view_daily_label'), ['class' => 'control-label']) }}
{{ Form::text('date', $date, ['required', 'class' => 'form-control', 'style' => 'width:100px']) }}
{{ Form::submit(__('report.view_report'), ['class' => 'btn btn-info btn-sm']) }}
{{ link_to_route('reports.payments.daily', __('report.today'), [], ['class' => 'btn btn-default btn-sm']) }}
{{ link_to_route(
    'reports.payments.monthly',
    __('report.view_monthly'),
    ['month' => month_number($dt->month), 'year' => $dt->year],
    ['class' => 'btn btn-default btn-sm']
) }}
{{ Form::close() }}

<div class="panel panel-default table-responsive">
    <table class="table table-condensed table-hover">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th class="col-md-2">{{ __('payment.project') }}</th>
            <th class="col-md-1 text-center">{{ __('app.date') }}</th>
            <th class="col-md-2 text-right">{{ __('payment.amount') }}</th>
            <th class="col-md-2 text-center">{{ __('payment.customer') }}</th>
            <th class="col-md-5">{{ __('payment.description') }}</th>
            <th class="col-md-1 text-center">{{ __('app.action') }}</th>
        </thead>
        <tbody>
            <?php $total = 0;?>
            @forelse($payments as $key => $payment)
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td>{{ $payment->project->present()->projectLink() }}</td>
                <td class="text-center">{{ $payment->date }}</td>
                <td class="text-right">{{ $payment->present()->amount }}</td>
                <td class="text-center">{{ $payment->partner->name }}</td>
                <td>{{ $payment->description }} [{{ $payment->type() }}]</td>
                <td class="text-center">
                    {{ link_to_route(
                        'payments.show',
                        __('app.show'),
                        [$payment],
                        [
                            'title' => __('app.show_detail_title', ['name' => $payment->number, 'type' => __('payment.payment')]),
                            'target' => '_blank',
                            'class' => 'btn btn-info btn-xs'
                        ]
                    ) }}
                </td>
            </tr>
            <?php $total = $payment->in_out == 0 ? $total - $payment->amount : $total + $payment->amount;?>
            @empty
            <tr><td colspan="7">{{ __('payment.not_found') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                <th class="text-right">{{ format_money($total) }}</th>
                <th colspan="3">&nbsp;</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

@section('ext_css')
    {{ Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) }}
@endsection

@section('ext_js')
    {{ Html::script(url('assets/js/plugins/jquery.datetimepicker.js')) }}
@endsection

@section('script')
<script>
(function() {
    $('#date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection
