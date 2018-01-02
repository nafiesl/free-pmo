@extends('layouts.dashboard')

@section('title', trans('auth.profile_edit'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-6 col-lg-offset-2">
        {{ Form::model(auth()->user(), ['route' => 'users.profile.update', 'method' => 'patch']) }}
        {!! FormField::text('name') !!}
        {!! FormField::email('email') !!}
        {!! FormField::radios('lang', $langList, ['label' => trans('lang.lang')]) !!}
        {{ Form::submit(trans('auth.update_profile'), ['class' => 'btn btn-info']) }}
        {{ link_to_route('users.profile.show', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        {{ Form::close() }}
    </div>
</div>

@endsection
