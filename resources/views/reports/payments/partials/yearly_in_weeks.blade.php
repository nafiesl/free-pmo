
<table class="table table-condensed table-hover">
    <thead>
        <th class="text-center">{{ __('time.week') }}</th>
        <th class="text-center">{{ __('time.date') }}</th>
        <th class="text-center">{{ __('payment.payment') }}</th>
        <th class="text-right">{{ __('payment.cash_in') }}</th>
        <th class="text-right">{{ __('payment.cash_out') }}</th>
        <th class="text-right">{{ __('report.profit') }}</th>
        <th class="text-center">{{ __('app.action') }}</th>
    </thead>
    <tbody>
        @foreach(get_week_numbers($year) as $weekNumber)
        @php
            $any = isset($reports[$weekNumber]);
        @endphp
        <tr>
            <td class="text-center">{{ $weekNumber }}</td>
            <td class="text-center">
                @php
                    $date = now();
                    $date->setISODate($year, $weekNumber);
                @endphp
                {{ $startDate = $loop->first ? $year.'-01-01' : $date->startOfWeek()->format('Y-m-d') }} -
                {{ $endDate = $loop->last ? $year.'-12-31' : $date->endOfWeek()->format('Y-m-d') }}
            </td>
            <td class="text-center">{{ $any ? $reports[$weekNumber]->count : 0 }}</td>
            <td class="text-right">{{ format_money($any ? $reports[$weekNumber]->cashin : 0) }}</td>
            <td class="text-right">{{ format_money($any ? $reports[$weekNumber]->cashout : 0) }}</td>
            <td class="text-right">{{ format_money($profit = $any ? $reports[$weekNumber]->profit : 0) }}</td>
            <td class="text-center">
                {{ link_to_route(
                    'reports.payments.daily',
                    __('report.detail'),
                    ['start_date' => $startDate, 'end_date' => $endDate],
                    [
                        'class' => 'btn btn-info btn-xs',
                        'title' => __('report.detail'),
                    ]
                ) }}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-center" colspan="2">{{ __('app.total') }}</th>
            <th class="text-center">{{ $reports->sum('count') }}</th>
            <th class="text-right">{{ format_money($reports->sum('cashin')) }}</th>
            <th class="text-right">{{ format_money($reports->sum('cashout')) }}</th>
            <th class="text-right">{{ format_money($reports->sum('profit')) }}</th>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>
