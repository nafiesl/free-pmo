@extends('layouts.app')

@section('title', trans('payment.payments'))

@section('content')
<h1 class="page-header">
    {!! link_to_route('payments.create', trans('payment.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    {{ trans('payment.payments') }} <small>{{ $payments->total() }} {{ trans('payment.found') }}</small>
</h1>
<div class="well well-sm text-right">
    <div class="pull-left hidden-xs">{!! str_replace('/?', '?', $payments->appends(Request::except('page'))->render()) !!}</div>
    {{ Form::open(['method'=>'get','class'=>'form-inline']) }}
    {{ Form::text('q', Request::get('q'), ['class'=>'form-control index-search-field','placeholder' => trans('payment.search')]) }}
    {{ Form::select('partner_id', ['' => '-- '.trans('payment.customer').' --'] + $usersList, request('partner_id'), ['class' => 'form-control', 'id' => 'partner_id']) }}
    {{ Form::submit(trans('app.search'), ['class' => 'btn btn-info btn-sm']) }}
    {{ link_to_route('payments.index','Reset',[],['class' => 'btn btn-default btn-sm']) }}
    {{ Form::close() }}
</div>
<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th class="col-md-3">{{ trans('payment.project') }}</th>
        <th class="col-md-1 text-center">{{ trans('app.date') }}</th>
        <th class="col-md-2 text-right">{{ trans('payment.amount') }}</th>
        <th class="col-md-3">{{ trans('payment.description') }}</th>
        <th class="col-md-1">{{ trans('payment.customer') }}</th>
        <th class="col-md-2">{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($payments as $key => $payment)
        <tr>
            <td>{{ $payments->firstItem() + $key }}</td>
            <td>{!! link_to_route('projects.payments', $payment->project->name, [$payment->project_id], ['title' => 'Lihat seluruh Pembayaran Project ini']) !!} [{{ $payment->type() }}]</td>
            <td class="text-center">{{ $payment->date }}</td>
            <td class="text-right">{{ $payment->present()->amount }}</td>
            <td>{{ $payment->description }}</td>
            <td>{{ $payment->partner->name }}</td>
            <td>
                {!! link_to_route('payments.show', trans('app.show'), [$payment->id], ['class'=>'btn btn-info btn-xs']) !!}
                {!! link_to_route('payments.edit', trans('app.edit'), [$payment->id], ['class'=>'btn btn-warning btn-xs']) !!}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">{{ trans('payment.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $payments->appends(Request::except('page'))->render()) !!}
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
