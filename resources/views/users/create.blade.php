@inject('roles', 'App\Entities\Users\Role')
@extends('layouts.dashboard')

@section('title', __('user.create'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        {!! Form::open(['route'=>'users.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('user.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => __('app.name')]) !!}
                {!! FormField::email('email', ['label' => __('user.email')]) !!}
                {!! FormField::checkboxes('role', $roles::toArray(), ['label' => __('user.role')]) !!}

                {!! FormField::password('password', [
                    'label' => __('auth.password'),
                    'info' => [
                        'text' => __('user.create_password_info'),
                        'class' => 'info',
                    ],
                ]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('user.create'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('users.index', __('app.cancel'), [], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('script')
<script>
    $('#password').attr('autocomplete', 'new-password');
</script>
@endsection
