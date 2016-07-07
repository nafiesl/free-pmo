@extends('layouts.app')

@section('title', trans('payment.create'))

@section('content')
<div class="row"><br>
    <div class="col-md-4">
        {!! Form::open(['route'=>'payments.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('date',['label'=> trans('payment.date')]) !!}
                {!! FormField::radios('type',['Pengeluaran','Pemasukan'],['label'=> trans('payment.type'),'value' => 1]) !!}
                {!! FormField::price('amount', ['label'=> trans('payment.amount')]) !!}
                {!! FormField::textarea('description',['label'=> trans('payment.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('payment.create'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('payments.index', trans('app.cancel'), [], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection