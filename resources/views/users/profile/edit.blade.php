@extends('layouts.app')

@section('content')
<h3 class="page-header">@lang('auth.profile_edit')</h3>
<div class="row">
    <div class="col-md-6">
        {{ Form::model(auth()->user(), ['route' => 'users.profile.update', 'method' => 'patch']) }}
        {!! FormField::text('name') !!}
        {!! FormField::email('email') !!}
        {{ Form::submit(trans('auth.update_profile'), ['class' => 'btn btn-info']) }}
        {{ Form::close() }}
    </div>
    <div class="col-md-6">
        <?php $agency = auth()->user()->agency;?>
        {{ Form::model($agency, ['route' => 'users.agency.update', 'method' => 'patch']) }}
        {!! FormField::text('name') !!}
        {!! FormField::email('email') !!}
        {!! FormField::text('website') !!}
        {!! FormField::textarea('address') !!}
        {!! FormField::text('phone') !!}
        {{ Form::submit(trans('agency.update'), ['class' => 'btn btn-info']) }}
        {{ Form::close() }}
    </div>
</div>

@endsection
