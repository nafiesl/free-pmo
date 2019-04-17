@extends('layouts.app')

@section('title', __('report.yearly', ['year' => $year]))

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ __('report.yearly', ['year' => $year]) }}</li>
</ul>

{{ Form::open(['method' => 'get', 'class' => 'form-inline well well-sm']) }}
{{ Form::label('year', __('report.view_yearly_label'), ['class' => 'control-label']) }}
{{ Form::select('year', $years, $year, ['class' => 'form-control']) }}
{{ Form::submit(__('report.view_report'), ['class' => 'btn btn-info btn-sm']) }}
{{ link_to_route('reports.payments.yearly', __('report.this_year'), [], ['class' => 'btn btn-default btn-sm']) }}
{{ link_to_route('reports.payments.year_to_year', __('report.view_year_to_year'), [], ['class' => 'btn btn-success btn-sm']) }}
{{ Form::close() }}

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">{{ __('report.sales_graph') }} {{ $year }}</h3></div>
    <div class="panel-body">
        <strong>{{ Option::get('money_sign', 'Rp') }}</strong>
        <div id="yearly-chart" style="height: 250px;"></div>
        <div class="text-center"><strong>{{ __('time.month') }}</strong></div>
    </div>
</div>

<div class="panel panel-success table-responsive">
    <div class="panel-heading"><h3 class="panel-title">{{ __('report.detail') }}</h3></div>
    <div class="panel-body table-responsive">
        <table class="table table-condensed">
            <thead>
                <th class="text-center">{{ __('time.month') }}</th>
                <th class="text-center">{{ __('payment.payment') }}</th>
                <th class="text-right">{{ __('payment.cash_in') }}</th>
                <th class="text-right">{{ __('payment.cash_out') }}</th>
                <th class="text-right">{{ __('report.profit') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </thead>
            <tbody>
                @php $chartData = []; @endphp
                @foreach(get_months() as $monthNumber => $monthName)
                @php
                    $any = isset($reports[$monthNumber]);
                @endphp
                <tr>
                    <td class="text-center">{{ month_id($monthNumber) }}</td>
                    <td class="text-center">{{ $any ? $reports[$monthNumber]->count : 0 }}</td>
                    <td class="text-right">{{ format_money($any ? $reports[$monthNumber]->cashin : 0) }}</td>
                    <td class="text-right">{{ format_money($any ? $reports[$monthNumber]->cashout : 0) }}</td>
                    <td class="text-right">{{ format_money($profit = $any ? $reports[$monthNumber]->profit : 0) }}</td>
                    <td class="text-center">
                        {{ link_to_route(
                            'reports.payments.monthly',
                            __('report.view_monthly'),
                            ['month' => $monthNumber, 'year' => $year],
                            [
                                'class' => 'btn btn-info btn-xs',
                                'title' => __('report.monthly', ['year_month' => month_id($monthNumber)]),
                                'title' => __('report.monthly', ['year_month' => month_id($monthNumber).' '.$year]),
                            ]
                        ) }}
                    </td>
                </tr>
                @php
                    $chartData[] = ['month' => month_id($monthNumber), 'value' => $profit];
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">{{ trans('app.total') }}</th>
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
        element: 'yearly-chart',
        data: {!! collect($chartData)->toJson() !!},
        xkey: 'month',
        ykeys: ['value'],
        labels: ["{{ __('report.profit') }} {{ Option::get('money_sign', 'Rp') }}"],
        parseTime:false,
        goals: [0],
        goalLineColors : ['red'],
        smooth: true,
        lineWidth: 2,
    });
})();
</script>
@endsection
