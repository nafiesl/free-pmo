@extends('layouts.app')

@section('title')
@yield('subtitle', trans('user.profile')) | {{ $user->name }}
@endsection

@section('content')
@include('users.partials.breadcrumb')
<div class="pull-right" style="margin-top: -8px">
    {!! link_to_route('users.edit', trans('user.edit'), [$user], ['id' => 'edit-user-' . $user->id, 'class' => 'btn btn-warning']) !!}
    {!! link_to_route('users.index', trans('user.back_to_index'), [], ['class' => 'btn btn-default']) !!}
</div>
@include('users.partials.nav-tabs')
@yield('content-user')
@endsection
