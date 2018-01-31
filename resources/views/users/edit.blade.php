@inject('roles', 'App\Entities\Users\Role')
@extends('layouts.user')

@section('subtitle', trans('user.edit'))

@section('content-user')
{!! Form::model($user, ['route'=>['users.update', $user->id], 'method' => 'patch', 'autocomplete' => 'off']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
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
                {!! Form::submit(trans('user.update'), ['class'=>'btn btn-warning']) !!}
                {!! link_to_route('users.show', trans('user.back_to_show'), [$user->id], ['class' => 'btn btn-info']) !!}
                {!! link_to_route('users.index', trans('user.back_to_index'), [], ['class' => 'btn btn-default']) !!}
                {!! link_to_route('users.delete', trans('app.delete'), [$user->id], ['class'=>'btn btn-danger pull-right']) !!}
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
