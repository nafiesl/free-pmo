@extends('layouts.app')

@section('title', trans('payment.create_fee'))

@section('content')

<ul class="breadcrumb hidden-print">
    <li>
        {{ link_to_route(
            'projects.index',
            trans('project.projects'),
            ['status' => request('status', $project->status_id)]
        ) }}</li>
    <li>{{ $project->nameLink() }}</li>
    <li>{{ link_to_route('projects.payments', trans('payment.list'), [$project->id]) }}</li>
    <li class="active">{{ trans('payment.create_fee') }}</li>
</ul>

<div class="row">
    <div class="col-md-6">
        {!! Form::open(['route' => ['projects.fees.store', $project->id]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.create_fee') }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        {!! FormField::select(
                            'partner_id',
                            $partners,
                            [
                                'placeholder' => 'Pilih Pekerja',
                                'label' => trans('payment.customer'),
                                'value' => Request::get('customer_id'),
                            ]
                        ) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::text('date',['label'=> trans('payment.date')]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::price('amount', ['label'=> trans('payment.amount')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! FormField::radios(
                            'type_id',
                            PaymentType::toArray(),
                            ['label' => trans('payment.type'), 'value' => 1, 'list_style' => 'unstyled']
                        ) !!}
                    </div>
                    <div class="col-md-8">
                        {!! FormField::textarea('description', ['label' => trans('payment.description'), 'rows' => 3]) !!}
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('payment.create'), ['class'=>'btn btn-primary']) !!}
                {{ link_to_route('projects.payments', trans('app.cancel'), [$project->id], ['class'=>'btn btn-default']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
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
        closeOnDateSelect: true
    });
})();
</script>
@endsection
