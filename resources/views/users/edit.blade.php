@inject('roles', 'App\Entities\Users\Role')
@extends('layouts.user')

@section('subtitle', trans('user.edit'))

@section('action-buttons')
{!! link_to_route('users.show', trans('user.back_to_show'), [$user->id], ['class' => 'btn btn-default']) !!}
@endsection

@section('content-user')
{!! Form::model($user, ['route'=>['users.update', $user->id], 'method' => 'patch', 'autocomplete' => 'off']) !!}
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">@yield('subtitle')</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('app.name')]) !!}
                {!! FormField::email('email', ['label' => trans('user.email')]) !!}
                {!! FormField::checkboxes('role', $roles::toArray(), [
                    'label' => trans('user.role'),
                    'value' => $user->roles->pluck('role_id')
                ]) !!}

                {!! FormField::password('password', [
                    'label' => trans('auth.password'),
                    'info' => [
                        'text' => 'Isi field ini jika ingin mengganti password user.',
                        'class' => 'info',
                    ],
                ]) !!}
                {!! FormField::radios('lang', $langList, ['label' => trans('lang.lang')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('user.update'), ['class'=>'btn btn-success']) !!}
                {!! link_to_route('users.show', trans('app.cancel'), [$user->id], ['class' => 'btn btn-default']) !!}
                @can('delete', $user)
                {!! link_to_route('users.delete', trans('app.delete'), [$user->id], ['class'=>'btn btn-danger pull-right']) !!}
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
