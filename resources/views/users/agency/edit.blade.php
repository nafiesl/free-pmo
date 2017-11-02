@extends('layouts.dashboard')

@section('title', trans('agency.edit'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-6 col-lg-offset-2">
        <?php $agency = auth()->user()->agency;?>
        {{ Form::model($agency, ['route' => 'users.agency.update', 'method' => 'patch']) }}
        {!! FormField::text('name') !!}
        {!! FormField::email('email') !!}
        {!! FormField::text('website') !!}
        {!! FormField::textarea('address') !!}
        {!! FormField::text('phone') !!}
        {{ Form::submit(trans('agency.update'), ['class' => 'btn btn-info']) }}
        {{ link_to_route('users.agency.show', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        {{ Form::close() }}
    </div>
</div>

@endsection
