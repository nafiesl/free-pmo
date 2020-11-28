@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
@include('subscriptions.partials.breadcrumb', ['title' => $pageTitle])

@includeWhen(request('action') == 'delete', 'subscriptions.partials.delete')

@if (request('action') == null)
<div class="row">
    <div class="col-md-6">
        {!! Form::model($subscription, ['route' => ['subscriptions.update', $subscription->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $pageTitle }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">{!! FormField::radios('type_id', SubscriptionType::toArray(), ['label' => __('subscription.type'), 'value' => Request::get('type_id')]) !!}</div>
                    <div class="col-md-6">{!! FormField::radios('status_id', [__('app.in_active'), __('app.active')], ['label' => __('app.status')]) !!}</div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::text('name', ['label' => __('subscription.name')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::price('price', ['label' => __('subscription.price'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::text('start_date', ['label' => __('subscription.start_date')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::text('due_date', ['label' => __('subscription.due_date')]) !!}
                    </div>
                </div>
                {!! FormField::select('project_id', $projects, ['label' => __('subscription.project')]) !!}
                {!! FormField::select('vendor_id', $vendors, ['label' => __('subscription.vendor')]) !!}
                {!! FormField::textarea('notes', ['label' => __('subscription.notes')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(__('subscription.update'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-3 text-center">
        <legend>{{ __('app.action') }}</legend>
        <p>{!! link_to_route('subscriptions.show', __('subscription.back_to_show'), [$subscription->id], ['class' => 'btn btn-info']) !!}</p>
        <p>{!! link_to_route('subscriptions.index', __('subscription.back_to_index'), [], ['class' => 'btn btn-default']) !!}</p>
        <p>{!! link_to_route('subscriptions.edit', __('subscription.delete'), [$subscription->id, 'action' => 'delete'], ['class' => 'btn btn-danger']) !!}</p>
    </div>
</div>
@endif
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
    $('#start_date,#due_date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection
