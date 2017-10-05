@extends('layouts.app')

@section('title', 'Entry Invoice')

@section('content')
<div class="pull-right">
    <form action="{{ route('invoices.add') }}" method="POST">
        {{ csrf_field() }}
        <input type="submit" class="btn btn-default navbar-btn" name="create-invoice-draft" id="invoice-draft-create-button" value="{{ trans('invoice.create') }}">
    </form>
</div>
<h1 class="page-header">{{ trans('invoice.list') }}</h1>

<?php use Facades\App\Services\InvoiceDrafts\InvoiceDraftCollection; ?>
@includeWhen(! InvoiceDraftCollection::isEmpty(), 'invoices.partials.invoice-draft-tabs')
@if ($draft)
    @if (Request::get('action') == 'confirm')
        @include('invoices.partials.draft-confirm')
    @else
        <div class="row">
            <div class="col-md-9">@include('invoices.partials.draft-item-list')</div>
            <div class="col-md-3">@include('invoices.partials.form-draft-detail')</div>
        </div>
    @endif
@endif
@endsection