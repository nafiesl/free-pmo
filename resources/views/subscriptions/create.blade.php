@extends('layouts.app')

@section('title', trans('subscription.create'))

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('subscriptions.index',trans('subscription.subscriptions')) }}</li>
    <li class="active">{{ trans('subscription.create') }}</li>
</ul>

<div class="row">
    <div class="col-md-4">
        {!! Form::open(['route'=>'subscriptions.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('subscription.create') }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::text('domain_name',['label'=> trans('subscription.domain_name')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::price('domain_price',['label'=> trans('subscription.domain_price')]) !!}
                    </div>
                </div>
                {!! FormField::text('epp_code',['label'=> trans('subscription.epp_code')]) !!}
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::text('hosting_capacity',['label'=> trans('subscription.hosting_capacity')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::price('hosting_price',['label'=> trans('subscription.hosting_price')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::text('start_date',['label'=> trans('subscription.start_date')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::text('due_date',['label'=> trans('subscription.due_date')]) !!}
                    </div>
                </div>
                {!! FormField::select('customer_id', $customers,['label'=> trans('subscription.customer'),'value' => Request::get('customer_id')]) !!}
                {!! FormField::select('project_id', $projects,['label'=> trans('subscription.project'),'value' => Request::get('project_id')]) !!}
                {!! FormField::textarea('remark',['label'=> trans('subscription.remark')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('subscription.create'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('subscriptions.index', trans('app.cancel'), [], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection