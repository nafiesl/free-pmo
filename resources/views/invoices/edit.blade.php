@extends('layouts.app')

@section('title', $invoice->number . ' - ' . trans('invoice.edit'))

@section('content')

@if (request('action') == 'delete')

<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('invoices.edit', trans('app.back'), $invoice, ['class' => 'btn btn-default']) }}
    </div>
    {{ $invoice->number }} <small>{{ trans('invoice.delete') }}</small>
</h1>
<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.delete') }}</h3></div>
            @include('invoices.partials.detail')
            <div class="panel-body">
                {{ trans('invoice.delete_confirm') }}
            </div>
            <div class="panel-footer">
                {{ link_to_route('invoices.edit', trans('app.back'), $invoice, ['class' => 'btn btn-default']) }}
                {!! FormField::delete(
                    ['route' => ['invoices.destroy',$invoice->number], 'onsubmit' => trans('invoice.delete_confirm')],
                    trans('invoice.delete'),
                    ['class'=>'btn btn-danger'],
                    [
                        'invoice_id' => $invoice->id,
                    ]
                ) !!}
            </div>
        </div>
    </div>
</div>

@else

<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('invoices.show', trans('invoice.back_to_show'), $invoice, ['class' => 'btn btn-default']) }}
    </div>
    {{ $invoice->number }} <small>{{ trans('invoice.edit') }}</small>
</h1>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.detail') }}</h3></div>
            {{ Form::model($invoice, ['route' => ['invoices.update', $invoice], 'method' => 'patch']) }}
            <div class="panel-body">
                {!! FormField::select('project_id', $projects, ['label' => trans('project.project')]) !!}
                <div class="row">
                    <div class="col-md-6">{!! FormField::text('date', ['label' => trans('invoice.date')]) !!}</div>
                    <div class="col-md-6">{!! FormField::text('due_date', ['label' => trans('invoice.due_date')]) !!}</div>
                </div>
                {!! FormField::textarea('notes', ['label' => trans('invoice.notes')]) !!}
                {!! FormField::price('discount', ['label' => __('invoice.discount'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                {!! FormField::text('discount_notes', ['label' => __('invoice.discount_notes')]) !!}
            </div>
            <div class="panel-footer">
                {{ Form::submit(trans('invoice.update'), ['class' => 'btn btn-info']) }}
                {{ link_to_route('invoices.show', trans('invoice.back_to_show'), $invoice, ['class' => 'btn btn-default']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="col-md-8">
        @include('invoices.partials.item-list')
    </div>
</div>

{{ link_to_route('invoices.edit', trans('invoice.delete'), [$invoice, 'action' => 'delete'], ['class'=>'btn btn-danger']) }}
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
    $('#date,#due_date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection
