@extends('layouts.app')

@section('title', trans('partner.edit').' '.$partner->name)

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('partners.show', trans('partner.back_to_show'), [$partner->id], ['class' => 'btn btn-default']) }}
    </div>
    {{ $partner->name }} <small>{{ trans('partner.edit') }}</small>
</h1>

@includeWhen(Request::has('action'), 'partners.forms')

{!! Form::model($partner, ['route' => ['partners.update', $partner->id],'method' => 'patch']) !!}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <legend>@lang('partner.detail')</legend>
                        {!! FormField::text('name', ['required' => true]) !!}
                        <div class="row">
                            <div class="col-xs-6">{!! FormField::radios('is_active', ['Non Aktif', 'Aktif']) !!}</div>
                        </div>
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
                {!! Form::submit(trans('partner.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('partners.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
                {!! link_to_route('partners.edit', trans('app.delete'), [$partner->id, 'action' => 'delete'], [
                    'id' => 'del-partner-'.$partner->id,
                    'class' => 'btn btn-link pull-right'
                ] ) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
