@extends('layouts.app')

@section('title')
@yield('subtitle', trans('user.profile')) | {{ $user->name }}
@endsection

@section('content')
@include('users.partials.breadcrumb')
<div class="pull-right" style="margin-top: -8px">
    @yield('action-buttons')
</div>
@include('users.partials.nav-tabs')
@yield('content-user')
@endsection
