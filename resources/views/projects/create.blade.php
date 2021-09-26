@extends('layouts.app')

@section('title', trans('project.create'))

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('projects.index',trans('project.projects')) }}</li>
    <li class="active">{{ trans('project.create') }}</li>
</ul>

<div class="row">
    <div class="col-md-4 col-md-offset-3">
        {!! Form::open(['route' => 'projects.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('project.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('project.name')]) !!}
                {!! FormField::select('customer_id', $customers, ['placeholder' => __('customer.create')]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('customer_name') !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::text('customer_email') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('proposal_date', ['label' => trans('project.proposal_date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('proposal_value', ['label' => trans('project.proposal_value'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => trans('project.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('project.create'), ['class' => 'btn btn-primary']) !!}
                {!! link_to_route('projects.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
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
    $('#proposal_date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection
