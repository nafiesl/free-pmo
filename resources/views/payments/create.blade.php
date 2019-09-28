@extends('layouts.app')

@section('title', __('payment.create'))

@section('content')

<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('payments.index', __('payment.payments')) }}</li>
    <li class="active">{{ __('payment.create') }}</li>
</ul>

<div class="row">
    <div class="col-md-6">
        {!! Form::open(['route'=>'payments.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('payment.create') }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::radios('in_out', [__('payment.out'), __('payment.in')], ['label' => __('payment.in_out'), 'value' => 1]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::radios('type_id', PaymentType::toArray(), ['label'=> __('payment.type'), 'value' => 1, 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('date', ['label'=> __('payment.date'), 'value' => now()->format('Y-m-d')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('amount', ['label'=> __('payment.amount'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::select('project_id', $projects, ['label'=> __('payment.project'), 'value' => Request::get('project_id')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::select('partner_id', $partners, ['label'=> __('payment.customer'), 'value' => Request::get('customer_id')]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label'=> __('payment.description'), 'rows' => 3]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(__('payment.create'), ['class'=>'btn btn-primary']) !!}
                {{ link_to_route('payments.index', __('app.cancel'), [], ['class'=>'btn btn-default']) }}
                @if ($project)
                {{ link_to_route('projects.payments', __('project.back_to_show'), $project, ['class'=>'btn btn-default pull-right']) }}
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @if ($project)
        <div class="col-md-6">
             @include('projects.partials.project-show')
        </div>
    @endif
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
