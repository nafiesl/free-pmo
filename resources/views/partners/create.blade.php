@extends('layouts.app')

@section('title', trans('partner.create'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('partners.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    </div>
    {{ trans('partner.create') }}
</h1>

{!! Form::open(['route' => 'partners.store']) !!}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <legend>@lang('partner.detail')</legend>
                        {!! FormField::text('name', ['required' => true]) !!}
                        {!! FormField::radios('type_id', $partnerTypes, ['required' => true]) !!}
                        {!! FormField::textarea('notes') !!}
                    </div>
                    <div class="col-md-6">
                        <legend>@lang('partner.contact')</legend>
                        {!! FormField::text('pic') !!}
                        <div class="row">
                            <div class="col-xs-7">{!! FormField::email('email') !!}</div>
                            <div class="col-xs-5">{!! FormField::text('phone') !!}</div>
                        </div>
                        {!! FormField::textarea('address') !!}
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('partner.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('partners.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
