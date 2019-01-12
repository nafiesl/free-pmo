@extends('layouts.app')

@section('title', __('report.year_to_year'))

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ __('report.year_to_year') }}</li>
</ul>

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">{{ __('report.sales_graph') }}</h3></div>
    <div class="panel-body">
        <strong>{{ Option::get('money_sign', 'Rp') }}</strong>
        <div id="year_to_year-chart" style="height: 350px;"></div>
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
                @foreach(get_years() as $year)
                @php
                    $any = isset($reports[$year]);
                @endphp
                <tr>
                    <td class="text-center">{{ $year }}</td>
                    <td class="text-center">{{ $any ? $reports[$year]->count : 0 }}</td>
                    <td class="text-right">{{ format_money($any ? $reports[$year]->cashin : 0) }}</td>
                    <td class="text-right">{{ format_money($any ? $reports[$year]->cashout : 0) }}</td>
                    <td class="text-right">{{ format_money($profit = $any ? $reports[$year]->profit : 0) }}</td>
                    <td class="text-center">
                        {{ link_to_route(
                            'reports.payments.yearly',
                            __('report.view_yearly'),
                            ['month' => $year, 'year' => $year],
                            [
                                'class' => 'btn btn-info btn-xs',
                                'title' => __('report.yearly', ['year' => $year]),
                            ]
                        ) }}
                    </td>
                </tr>
                @php
                    $chartData[] = ['year' => $year, 'value' => $profit];
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
    new Morris.Bar({
        element: 'year_to_year-chart',
        data: {!! collect($chartData)->toJson() !!},
        xkey: 'year',
        ykeys: ['value'],
        labels: ["{{ __('report.profit') }} {{ Option::get('money_sign', 'Rp') }}"],
        parseTime: false,
        barColors: ['#5CB85C']
    });
})();
</script>
@endsection
