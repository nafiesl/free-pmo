@extends('layouts.app')

@section('title', trans('payment.edit'))

@section('content')
@include('payments.partials.breadcrumb',['title' => trans('payment.edit')])

<div class="row">
    <div class="col-md-6">
        {!! Form::model($payment, ['route'=>['payments.update', $payment->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.edit') }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::radios('in_out',['Pengeluaran','Pemasukan'],['label'=> trans('payment.in_out'),'value' => 1]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::radios('type_id', paymentTypes(), ['label'=> trans('payment.type'),'value' => 1,'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('date',['label'=> trans('app.date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('amount',['label'=> trans('payment.amount')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::select('project_id', $projects, ['label'=> trans('payment.project')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::select('customer_id', $partners, ['label'=> trans('payment.customer')]) !!}
                    </div>
                </div>
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

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) !!}
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery.datetimepicker.js')) !!}
    {!! Html::script(url('assets/js/plugins/autoNumeric.min.js')) !!}
@endsection

@section('script')
<script>
(function() {
    $('#date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true
    });
    $('#amount').autoNumeric("init",{
        aSep: '.',
        aDec: ',',
        mDec: '0'
    });
})();
</script>
@endsection
