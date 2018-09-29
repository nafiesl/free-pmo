@extends('layouts.app')

@section('title', __('payment.edit'))

@section('content')

@include('payments.partials.breadcrumb', ['title' => __('payment.edit')])

<div class="row">
    <div class="col-md-6">
        {!! Form::model($payment, ['route'=>['payments.update', $payment->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('payment.edit') }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::radios('in_out', [__('payment.out'), __('payment.in')], ['label'=> __('payment.in_out'), 'value' => 1]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::radios('type_id', PaymentType::toArray(), ['label' => __('payment.type'), 'value' => 1, 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('date', ['label'=> __('app.date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('amount', ['label'=> __('payment.amount'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::select('project_id', $projects, ['label'=> __('payment.project')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::select('partner_id', $partners, ['label'=> __('payment.customer')]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label'=> __('payment.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(__('payment.update'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('projects.payments', __('payment.back_to_index'), [$payment->project_id], ['class' => 'btn btn-default']) !!}
                {!! link_to_route('payments.delete', __('payment.delete'), [$payment->id], ['class'=>'btn btn-danger pull-right']) !!}
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
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection
