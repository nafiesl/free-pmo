@extends('layouts.app')

@section('title', trans('user.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::delete(['route'=>['users.destroy',$user->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['user_id'=>$user->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('users.show', trans('app.cancel'), [$user->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('user.user') }} Detail</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ trans('app.name') }}</th><td>{{ $user->name }}</td></tr>
                        <tr><th>{{ trans('auth.username') }}</th><td>{{ $user->username }}</td></tr>
                        <tr><th>{{ trans('user.email') }}</th><td>{{ $user->email }}</td></tr>
                        <tr>
                            <th>{{ trans('user.role') }}</th>
                            <td>{{ $user->present()->displayRoles }}</td>
                        </tr>
                        <tr><th>{{ trans('user.registered_at') }}</th><td>{{ $user->created_at }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection