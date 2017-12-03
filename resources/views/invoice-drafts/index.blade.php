@extends('layouts.app')

@section('title', trans('invoice.create'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::formButton(['route' => 'invoice-drafts.create'], trans('invoice.create'), [
            'class' => 'btn btn-success',
            'name' => 'create-invoice-draft',
            'id' => 'invoice-draft-create-button'
        ] ) !!}
    </div>
    {{ trans('invoice.draft_list') }}
</h1>

<?php use Facades\App\Services\InvoiceDrafts\InvoiceDraftCollection;?>
@includeWhen(! InvoiceDraftCollection::isEmpty(), 'invoice-drafts.partials.invoice-draft-tabs')
@if ($draft)
    @if (Request::get('action') == 'confirm')
        @include('invoice-drafts.partials.draft-confirm')
    @else
        <div class="row" style="margin-top: 10px">
            <div class="col-md-9">@include('invoice-drafts.partials.draft-item-list')</div>
            <div class="col-md-3">@include('invoice-drafts.partials.form-draft-detail')</div>
        </div>
    @endif
@else
    {{ trans('invoice.draft_list_empty') }}
    {!! FormField::formButton(['route' => 'invoice-drafts.create'], trans('invoice.create'), [
        'id' => 'invoice-draft-create-button',
        'name' => 'create-invoice-draft',
        'class' => 'btn btn-link',
        'style' => 'padding:0px',
    ]) !!}
@endif
@endsection

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) !!}
    {!! Html::style(url('assets/css/plugins/select2.min.css')) !!}
    <style>
    .form-control.select2-hidden-accessible {
        width: 80%;
    }
    </style>
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery.datetimepicker.js')) !!}
    {!! Html::script(url('assets/js/plugins/select2.min.js')) !!}
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
    $('#project_id').select2({
        placeholder: '-- {{ trans('project.select') }} --'
    });
})();
</script>
@endsection
