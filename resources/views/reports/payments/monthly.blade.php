@extends('layouts.app')

@section('title', __('report.monthly', ['year_month' => $months[$month].' '.$year]))

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('reports.payments.yearly', __('report.yearly', ['year' => $year]), ['year' => $year]) }}</li>
    <li class="active">{{ $months[$month] }}</li>
</ul>

{{ Form::open(['method' => 'get', 'class' => 'form-inline well well-sm']) }}
{{ Form::label('month', __('report.view_monthly_label'), ['class' => 'control-label']) }}
{{ Form::select('month', $months, $month, ['class' => 'form-control']) }}
{{ Form::select('year', $years, $year, ['class' => 'form-control']) }}
{{ Form::submit(__('report.view_report'), ['class' => 'btn btn-info btn-sm']) }}
{{ link_to_route('reports.payments.monthly', __('report.this_month'), [], ['class' => 'btn btn-default btn-sm']) }}
{{ link_to_route('reports.payments.yearly', __('report.view_yearly'), ['year' => $year], ['class' => 'btn btn-default btn-sm']) }}
{{ Form::close() }}

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">{{ __('report.sales_graph') }} {{ $months[$month] }} {{ $year }}</h3></div>
    <div class="panel-body">
        <strong>{{ Option::get('money_sign', 'Rp') }}</strong>
        <div id="monthly-chart" style="height: 250px;"></div>
        <div class="text-center"><strong>{{ __('time.date') }}</strong></div>
    </div>
</div>

<div class="panel panel-success table-responsive">
    <div class="panel-heading"><h3 class="panel-title">{{ __('report.detail') }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <thead>
                <th class="text-center">{{ __('time.date') }}</th>
                <th class="text-center">{{ __('payment.payment') }}</th>
                <th class="text-right">{{ __('payment.cash_in') }}</th>
                <th class="text-right">{{ __('payment.cash_out') }}</th>
                <th class="text-right">{{ __('report.profit') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </thead>
            <tbody>
                @php $chartData = []; @endphp
                @foreach(month_date_array($year, $month) as $dateNumber)
                @php
                    $any = isset($reports[$dateNumber]);
                    $count = $any ? $reports[$dateNumber]->count : 0;
                    $profit = $any ? $reports[$dateNumber]->profit : 0;
                @endphp
                @if ($any)
                    <tr>
                        <td class="text-center">{{ date_id($date = $year.'-'.$month.'-'.$dateNumber) }}</td>
                        <td class="text-center">{{ $count }}</td>
                        <td class="text-right">{{ format_money($any ? $reports[$dateNumber]->cashin : 0) }}</td>
                        <td class="text-right">{{ format_money($any ? $reports[$dateNumber]->cashout : 0) }}</td>
                        <td class="text-right">{{ format_money($profit) }}</td>
                        <td class="text-center">
                            {{ link_to_route(
                                'reports.payments.daily',
                                __('report.view_daily'),
                                ['date' => $date],
                                [
                                    'class' => 'btn btn-info btn-xs',
                                    'title' => __('report.daily', ['date' => date_id($date)]),
                                ]
                            ) }}
                        </td>
                    </tr>
                @endif
                @php
                    $chartData[] = ['date' => $dateNumber, 'value' => ($profit) ];
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right">{{ __('app.total') }}</th>
                    <th class="text-center">{{ $reports->sum('count') }}</th>
                    <th class="text-right">{{ format_money($reports->sum('cashin')) }}</th>
                    <th class="text-right">{{ format_money($reports->sum('cashout')) }}</th>
                    <th class="text-right">{{ format_money($reports->sum('profit')) }}</th>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('ext_css')
    {{ Html::style(url('assets/css/plugins/morris.css')) }}
@endsection

@section('ext_js')
    {{ Html::script(url('assets/js/plugins/morris/raphael.min.js')) }}
    {{ Html::script(url('assets/js/plugins/morris/morris.min.js')) }}
@endsection

@section('script')
<script>
(function() {
    new Morris.Line({
        element: 'monthly-chart',
        data: {!! collect($chartData)->toJson() !!},
        xkey: 'date',
        ykeys: ['value'],
        labels: ["{{ __('report.profit') }} {{ Option::get('money_sign', 'Rp') }}"],
        parseTime:false,
        xLabelAngle: 30,
        goals: [0],
        goalLineColors : ['red'],
        lineWidth: 2,
    });
})();
</script>
@endsection
