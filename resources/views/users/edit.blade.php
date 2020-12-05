@inject('roles', 'App\Entities\Users\Role')
@extends('layouts.user')

@section('subtitle', __('user.edit'))

@section('action-buttons')
{!! link_to_route('users.show', __('user.back_to_show'), [$user->id], ['class' => 'btn btn-default']) !!}
@endsection

@section('content-user')
{!! Form::model($user, ['route'=>['users.update', $user->id], 'method' => 'patch', 'autocomplete' => 'off']) !!}
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">@yield('subtitle')</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => __('app.name')]) !!}
                {!! FormField::email('email', ['label' => __('user.email')]) !!}
                {!! FormField::checkboxes('role', $roles::toArray(), [
                    'label' => __('user.role'),
                    'value' => $user->roles->pluck('role_id')
                ]) !!}

                {!! FormField::password('password', [
                    'label' => __('auth.password'),
                    'info' => [
                        'text' => __('user.update_password_info'),
                        'class' => 'info',
                    ],
                ]) !!}
                {!! FormField::radios('lang', $langList, ['label' => __('lang.lang')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('user.update'), ['class'=>'btn btn-success']) !!}
                {!! link_to_route('users.show', __('app.cancel'), [$user->id], ['class' => 'btn btn-default']) !!}
                @can('delete', $user)
                {!! link_to_route('users.delete', __('app.delete'), [$user->id], ['class'=>'btn btn-danger pull-right']) !!}
                @endcan
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection

@section('script')
<script>
        $('#password').attr('autocomplete', 'new-password');
</script>
@endsection
