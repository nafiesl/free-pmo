@extends('layouts.app')

@section('title', trans('partner.show'))

@section('content')
<h1 class="page-header">{{ $partner->name }} <small>{{ trans('partner.show') }}</small></h1>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('partner.show') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><td class="col-xs-3">{{ trans('partner.name') }}</td><td>{{ $partner->name }}</td></tr>
                    <tr><td>{{ trans('contact.email') }}</td><td>{{ $partner->email }}</td></tr>
                    <tr><td>{{ trans('contact.phone') }}</td><td>{{ $partner->phone }}</td></tr>
                    <tr><td>{{ trans('partner.pic') }}</td><td>{{ $partner->pic }}</td></tr>
                    <tr><td>{{ trans('address.address') }}</td><td>{{ $partner->address }}</td></tr>
                    <tr><td>{{ trans('app.status') }}</td><td>{{ $partner->is_active }}</td></tr>
                    <tr><td>{{ trans('app.notes') }}</td><td>{!! nl2br($partner->notes) !!}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {{-- {!! link_to_route('partners.edit', trans('partner.edit'), [$partner->id], ['class' => 'btn btn-warning']) !!} --}}
                {!! link_to_route('partners.index', trans('partner.back_to_index'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <a href="#" title="@lang('partner.projects_count')">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3"><i class="fa fa-table fa-4x"></i></div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $partner->projects()->count() }}</div>
                                    <div class="lead">@lang('partner.projects_count')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
