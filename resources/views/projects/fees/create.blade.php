@extends('layouts.app')

@section('title', __('payment.create_fee'))

@section('content')

<ul class="breadcrumb hidden-print">
    <li>
        {{ link_to_route(
            'projects.index',
            __('project.projects'),
            ['status_id' => request('status_id', $project->status_id)]
        ) }}</li>
    <li>{{ $project->nameLink() }}</li>
    <li>{{ link_to_route('projects.payments', __('payment.list'), $project) }}</li>
    <li class="active">{{ __('payment.create_fee') }}</li>
</ul>

<div class="row">
    <div class="col-md-6 col-md-offset-2">
        {!! Form::open(['route' => ['projects.fees.store', $project]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('payment.create_fee') }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        {!! FormField::select(
                            'partner_id',
                            $partners,
                            [
                                'placeholder' => __('job.select_worker'),
                                'label' => __('payment.customer'),
                                'value' => request('customer_id'),
                            ]
                        ) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::text('date', ['label' => __('payment.date'), 'value' => now()->format('Y-m-d')]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::price('amount', ['label' => __('payment.amount'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! FormField::radios(
                            'type_id',
                            PaymentType::toArray(),
                            ['label' => __('payment.type'), 'value' => 1, 'list_style' => 'unstyled']
                        ) !!}
                    </div>
                    <div class="col-md-8">
                        {!! FormField::textarea('description', ['label' => __('payment.description'), 'rows' => 3]) !!}
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                {!! Form::submit(__('payment.create'), ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('projects.payments', __('app.cancel'), $project, ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) !!}
@endsection

@section('script')
{!! Html::script(url('assets/js/plugins/jquery.datetimepicker.js')) !!}
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
