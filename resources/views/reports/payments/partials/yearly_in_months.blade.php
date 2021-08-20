<table class="table table-condensed table-hover">
    <thead>
        <th class="text-center">{{ __('time.month') }}</th>
        <th class="text-center">{{ __('payment.payment') }}</th>
        <th class="text-right">{{ __('payment.cash_in') }}</th>
        <th class="text-right">{{ __('payment.cash_out') }}</th>
        <th class="text-right">{{ __('report.profit') }}</th>
        <th class="text-center">{{ __('app.action') }}</th>
    </thead>
    <tbody>
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
