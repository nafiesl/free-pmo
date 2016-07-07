@extends('layouts.app')

@section('title', trans('payment.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::delete(['route'=>['payments.destroy',$payment->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['payment_id'=>$payment->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('payments.show', trans('app.cancel'), [$payment->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.payments') }} Detail</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ trans('payment.date') }}</th><td>{{ $payment->date }}</td></tr>
                        <tr><th>{{ trans('payment.amount') }}</th><td class="text-right">{{ formatRp($payment->amount) }}</td></tr>
                        <tr><th>{{ trans('payment.description') }}</th><td>{{ $payment->description }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection