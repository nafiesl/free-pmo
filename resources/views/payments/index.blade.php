@extends('layouts.app')

@section('title', __('payment.payments'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! link_to_route('payments.create', __('payment.create'), [], ['class' => 'btn btn-success']) !!}
    </div>
    {{ __('payment.payments') }} <small>{{ $payments->total() }} {{ __('payment.found') }}</small>
</h1>
<div class="well well-sm text-right">
    <div class="pull-left hidden-xs">{{ $payments->appends(Request::except('page'))->render() }}</div>
    {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
    {{ Form::text('q', request('q'), ['class' => 'form-control index-search-field', 'placeholder' => __('payment.search')]) }}
    {{ Form::select('partner_id', ['' => '-- '.__('payment.customer').' --'] + $partnersList, request('partner_id'), ['class' => 'form-control', 'id' => 'partner_id']) }}
    {{ Form::submit(__('app.search'), ['class' => 'btn btn-info btn-sm']) }}
    {{ link_to_route('payments.index', __('app.reset'), [], ['class' => 'btn btn-default btn-sm']) }}
    {{ Form::close() }}
</div>
<div class="panel panel-default">
<table class="table table-condensed table-hover">
    <thead>
        <th>{{ __('app.table_no') }}</th>
        <th class="col-md-3">{{ __('payment.project') }}</th>
        <th class="col-md-1 text-center">{{ __('app.date') }}</th>
        <th class="col-md-1">{{ __('payment.customer') }}</th>
        <th class="col-md-2 text-right">{{ __('payment.amount') }}</th>
        <th class="col-md-4">{{ __('payment.description') }}</th>
        <th class="col-md-1 text-center">{{ __('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($payments as $key => $payment)
        <tr>
            <td>{{ $payments->firstItem() + $key }}</td>
            <td>
                {{ link_to_route(
                    'projects.payments',
                    $payment->project->name,
                    [$payment->project_id],
                    ['title' => __('project.view_payments')]
                ) }}<br>
                <strong class="text-success">{{ $payment->type() }}</strong>
            </td>
            <td class="text-center">{{ $payment->date }}</td>
            <td>{{ $payment->partner->name }}</td>
            <td class="text-right">{{ $payment->present()->amount }}</td>
            <td>{{ $payment->description }}</td>
            <td class="text-center">
                {!! html_link_to_route('payments.show', '', [$payment->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => __('app.show'), 'id' => 'show_payment-'.$payment->id]) !!}
                {!! html_link_to_route('payments.pdf', '', [$payment->id], ['icon' => 'print', 'class' => 'btn btn-warning btn-xs', 'title' => __('app.print')]) !!}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">{{ __('payment.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $payments->appends(Request::except('page'))->render() }}
@endsection

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/select2.min.css')) !!}
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/select2.min.js')) !!}
@endsection

@section('script')
<script>
(function () {
    $('#partner_id').select2();
})();
</script>
@endsection
