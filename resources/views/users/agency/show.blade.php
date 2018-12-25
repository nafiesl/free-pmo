@extends('layouts.dashboard')

@section('title', trans('agency.agency'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-4 text-center">

        <p>{!! app_logo_image() !!}</p>

        <h3 class="text-primary">{{ Option::get('agency_name') }}</h3>
        <p>{{ Option::get('agency_tagline') }}</p>
        <br>
        @can('manage_agency')
            {{ link_to_route('users.agency.edit', trans('agency.edit'), [], ['class' => 'btn btn-info']) }}
        @endcan
    </div>
    <div class="col-md-8">
        <legend style="border-bottom: none;margin-bottom: 10px; margin-left: 6px;">
            {{ trans('agency.detail') }}
        </legend>
        <div class="panel panel-default">
            <table class="table">
                <tr><th>{{ trans('agency.name') }}</th><td>{{ Option::get('agency_name') }}</td></tr>
                <tr><th>{{ trans('agency.tagline') }}</th><td>{{ Option::get('agency_tagline') }}</td></tr>
                <tr><th>{{ trans('contact.email') }}</th><td>{{ Option::get('agency_email') }}</td></tr>
                <tr><th>{{ trans('contact.phone') }}</th><td>{{ Option::get('agency_phone') }}</td></tr>
                <tr><th>{{ trans('address.address') }}</th><td>{!! nl2br(Option::get('agency_address')) !!}</td></tr>
                <tr><th>{{ trans('address.city') }}</th><td>{{ Option::get('agency_city') }}</td></tr>
                <tr><th>{{ trans('contact.website') }}</th><td>{{ Option::get('agency_website') }}</td></tr>
                <tr><th>{{ trans('agency.tax_id') }}</th><td>{{ Option::get('agency_tax_id') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
