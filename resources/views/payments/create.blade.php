@extends('layouts.app')

@section('title', trans('payment.create'))

@section('content')

<div class="row">
    <div class="col-md-6">
        {!! Form::open(['route'=>'payments.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.create') }}</h3></div>
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
                        {!! FormField::text('date',['label'=> trans('payment.date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('amount', ['label'=> trans('payment.amount')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::select('project_id', $projects, ['label'=> trans('payment.project'),'value' => Request::get('project_id')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::select('customer_id', $customers, ['label'=> trans('payment.customer'),'value' => Request::get('customer_id')]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description',['label'=> trans('payment.description'),'rows' => 3]) !!}
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

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) !!}
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery.datetimepicker.js')) !!}
@endsection

@section('script')
<script>
(function() {
    $('#date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true
    });
})();
</script>
@endsection