<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.show') }}</h3></div>
    <table class="table table-condensed">
        <tbody>
            <tr><th>{{ trans('payment.date') }}</th><td>{{ $payment->date }}</td></tr>
            <tr><th>{{ trans('payment.in_out') }}</th><td>{{ $payment->in_out ? trans('payment.cash_in') : trans('payment.cash_out') }}</td></tr>
            <tr><th>{{ trans('payment.type') }}</th><td>{{ $payment->present()->type_id }}</td></tr>
            <tr><th>{{ trans('payment.amount') }}</th><td class="text-right">{{ $payment->present()->amount }}</td></tr>
            <tr><th>{{ trans('payment.description') }}</th><td>{{ $payment->description }}</td></tr>
            <tr><th>{{ trans('payment.customer') }}</th><td>{{ $payment->customer->name }}</td></tr>
        </tbody>
    </table>
    <div class="panel-footer">
        {!! link_to_route('payments.edit', trans('payment.edit'), [$payment->id], ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('projects.payments', 'Kembali ke Daftar Pembayaran Project', [$payment->project_id], ['class' => 'btn btn-default']) !!}
    </div>
</div>
