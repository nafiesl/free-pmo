<div class="panel panel-default">
    <table class="table table-condensed">
        <tbody>
            <tr><th class="col-xs-4">{{ __('payment.id') }}</th><td>#{{ $payment->id }}</td></tr>
            <tr><th>{{ __('payment.date') }}</th><td>{{ $payment->date }}</td></tr>
            <tr><th>{{ __('payment.in_out') }}</th><td>{{ $payment->in_out ? __('payment.cash_in') : __('payment.cash_out') }}</td></tr>
            <tr><th>{{ __('payment.customer') }}</th><td>{{ $payment->partner->name }}</td></tr>
            <tr><th>{{ __('payment.amount') }}</th><td class="lead">{{ $payment->present()->amount }}</td></tr>
            <tr><th>{{ __('payment.description') }}</th><td>{{ $payment->description }}</td></tr>
        </tbody>
    </table>
</div>
