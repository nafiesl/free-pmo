@extends('layouts.app')

@section('title', $invoice->number . ' - ' . __('invoice.detail'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::formButton(['route' => ['invoices.duplication.store', $invoice]], __('invoice.duplicate'), ['class' => 'btn btn-default']) !!}
        {{ link_to_route('invoices.edit', __('invoice.edit'), [$invoice], ['class' => 'btn btn-warning']) }}
        {{ link_to_route('invoices.pdf', __('invoice.print'), [$invoice], ['class' => 'btn btn-default']) }}
        {{ link_to_route('projects.invoices', __('invoice.back_to_project'), [$invoice->project_id], ['class' => 'btn btn-default']) }}
    </div>
    {{ $invoice->number }} <small>{{ __('invoice.detail') }}</small>
</h1>
<div class="row">
    <div class="col-sm-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('invoice.detail') }}</h3></div>
            @include('invoices.partials.detail')
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('invoice.items') }}</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th width="5%">{{ __('app.table_no') }}</th>
                            <th width="70%">{{ __('invoice.item_description') }}</th>
                            <th width="25%" class="text-right">{{ __('invoice.item_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach($invoice->items as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{!! nl2br($item['description']) !!}</td>
                            <td class="text-right">{{ format_money($item['amount']) }}</td>
                        </tr>
                        @php
                            $subtotal += $item['amount'];
                        @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if ($invoice->discount)
                        <tr>
                            <th colspan="2" class="text-right">{{ __('invoice.subtotal') }} :</th>
                            <th class="text-right">{{ format_money($subtotal) }}</th>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <strong>{{ __('invoice.discount') }}</strong>
                                {{ $invoice->discount_notes ? '('.$invoice->discount_notes.')': '' }} :
                            </td>
                            <th class="text-right">- {{ format_money($invoice->discount) }}</th>
                        </tr>
                        @endif
                        <tr>
                            <th colspan="2" class="text-right">{{ __('app.total') }} :</th>
                            <th class="text-right">{{ format_money($invoice->amount) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
