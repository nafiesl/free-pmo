<div class="panel panel-default">
    <table class="table table-condensed">
        <tbody>
            <tr><th class="col-xs-4">{{ trans('payment.id') }}</th><td>#{{ $payment->id }}</td></tr>
            <tr><th>{{ trans('payment.date') }}</th><td>{{ $payment->date }}</td></tr>
            <tr><th>{{ trans('payment.in_out') }}</th><td>{{ $payment->in_out ? trans('payment.cash_in') : trans('payment.cash_out') }}</td></tr>
            <tr><th>{{ trans('payment.customer') }}</th><td>{{ $payment->partner->name }}</td></tr>
            <tr><th>{{ trans('payment.amount') }}</th><td class="lead">{{ $payment->present()->amount }}</td></tr>
            <tr><th>{{ trans('payment.description') }}</th><td>{{ $payment->description }}</td></tr>
        </tbody>
    </table>
</div>
