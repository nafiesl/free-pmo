@extends('layouts.dashboard')

@section('title', trans('agency.agency'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <table class="table">
                <tr><th class="col-xs-4">{{ trans('agency.name') }}</th><td>{{ Option::get('agency_name') }}</td></tr>
                <tr><th>{{ trans('agency.email') }}</th><td>{{ Option::get('agency_email') }}</td></tr>
                <tr><th>{{ trans('agency.phone') }}</th><td>{{ Option::get('agency_phone') }}</td></tr>
                <tr><th>{{ trans('agency.address') }}</th><td>{!! nl2br(Option::get('agency_address')) !!}</td></tr>
                <tr><th>{{ trans('agency.website') }}</th><td>{{ Option::get('agency_website') }}</td></tr>
            </table>
            <div class="panel-footer">
                {{ link_to_route('users.agency.edit', trans('agency.edit'), [], ['class' => 'btn btn-info']) }}
            </div>
        </div>
    </div>
</div>
@endsection
