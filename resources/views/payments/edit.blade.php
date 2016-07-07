@extends('layouts.app')

@section('title', trans('payment.edit'))

@section('content')
<div class="row"><br>
    <div class="col-md-4">
        {!! Form::model($payment, ['route'=>['payments.update', $payment->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.edit') }}</h3></div>
        <div class="panel-body">
                {!! FormField::radios('type', ['Pengeluaran','Pemasukan'], ['label'=> trans('payment.type')]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('date',['label'=> trans('app.date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::text('amount',['label'=> trans('payment.amount'),'addon' => ['before'=>'Rp'],'type' => 'number','class' => 'text-right']) !!}
                    </div>
                </div>
                {!! FormField::select('project_id', $projects, ['label'=> trans('payment.project')]) !!}
                {!! FormField::select('customer_id', $customers, ['label'=> trans('payment.customer')]) !!}
                {!! FormField::textarea('description',['label'=> trans('payment.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('payment.update'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('projects.payments', trans('payment.back_to_index'), [$payment->project_id], ['class' => 'btn btn-default']) !!}
                {!! link_to_route('payments.delete', trans('payment.delete'), [$payment->id], ['class'=>'btn btn-danger pull-right']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection