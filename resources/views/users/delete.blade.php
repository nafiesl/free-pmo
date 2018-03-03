@extends('layouts.user')

@section('title', trans('user.delete'))

@section('content-user')
<div class="row">
    <div class="col-md-4 col-lg-offset-3">
        <div class="panel panel-danger">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('user.delete') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th>{{ trans('app.name') }}</th><td>{{ $user->name }}</td></tr>
                    <tr><th>{{ trans('user.email') }}</th><td>{{ $user->email }}</td></tr>
                    <tr><th>{{ trans('user.registered_at') }}</th><td>{{ $user->created_at }}</td></tr>
                </tbody>
            </table>
            <div class="panel-body">
                {{ trans('app.delete_confirm') }}
            </div>
            <div class="panel-footer">
                {!! link_to_route('users.show', trans('app.cancel'), [$user->id], ['class' => 'btn btn-default']) !!}
                <div class="pull-right">
                    {!! FormField::delete(['route'=>['users.destroy',$user->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['user_id'=>$user->id]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
