@extends('layouts.app')

@section('title', trans('user.roles'))

@section('content')
<h1 class="page-header">
    @if (Request::get('act') != 'add')
    {!! link_to_route('roles.index', trans('role.create'), ['act' => 'add'], ['class'=>'btn btn-success pull-right']) !!}
    @endif
    {{ trans('role.roles') }}
</h1>

<div class="row">
    <div class="col-md-4 col-md-push-8">
        @if (Request::get('act') == 'add')
        <div class="panel panel-success">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('role.create') }}</h3></div>
            <div class="panel-body">
                {!! Form::open(['route'=>'roles.store']) !!}
                {!! FormField::text('name') !!}
                {!! FormField::text('label') !!}
                {!! Form::submit(trans('role.create'), ['class' => 'btn btn-success']) !!}
                {!! link_to_route('roles.index', trans('app.cancel'), [], ['class'=>'btn btn-default pull-right']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        @elseif (Request::get('act') == 'edit' && !is_null($role))
        <div class="panel panel-warning">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('role.edit') }}</h3></div>
            <div class="panel-body">
                {!! Form::model($role, ['route'=>['roles.update', $role->id],'method'=>'patch']) !!}
                {!! FormField::text('name') !!}
                {!! FormField::text('label') !!}
                {!! Form::submit(trans('role.update'), ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('roles.index', trans('app.cancel'), [], ['class'=>'btn btn-default pull-right']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        @elseif (Request::get('act') == 'del' && !is_null($role))
        <div class="panel panel-danger">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('role.delete') }}</h3></div>
            <div class="panel-body">
                {{ trans('app.delete_confirm') }}
            </div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th>{{ trans('app.name') }}</th><td>{{ $role->name }}</td></tr>
                    <tr><th>{{ trans('app.label') }}</th><td>{{ $role->label }}</td></tr>
                    <tr><th>{{ trans('role.users_count') }}</th><td>{{ $role->users()->count() }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {!! link_to_route('roles.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
                @if ($role->users()->count() < 1)
                {!! FormField::delete(['route'=>['roles.destroy',$role->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger pull-right'], ['role_id'=>$role->id]) !!}
                @endif
            </div>
        </div>
        @elseif (Request::get('act') == 'show' && !is_null($role))
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('role.show') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th>{{ trans('app.name') }}</th><td>{{ $role->name }}</td></tr>
                    <tr><th>{{ trans('app.label') }}</th><td>{{ $role->label }}</td></tr>
                    <tr><th>{{ trans('role.users_count') }}</th><td>{{ $role->users()->count() }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {!! link_to_route('roles.index', trans('app.edit'), ['act'=>'edit','id'=>$role->id], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('roles.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::open(['route'=>['roles.update-permissions', $role->id]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('permission.permissions') }}</h3></div>
            <div class="panel-body">
                {!! FormField::checkboxes('permission', $permissions->pluck('label','id')->all(), ['value' => $role->permissions,'label'=>false,'list_style' => 'unstyled']) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('role.update'), ['class' => 'btn btn-warning']) !!}
            </div>
        </div>
        {!! Form::close() !!}
        @endif
    </div>
    <div class="col-md-8 col-md-pull-4">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <thead>
                    <th>{{ trans('app.table_no') }}</th>
                    <th>{{ trans('app.name') }}</th>
                    <th class="text-center">{{ trans('role.users_count') }}</th>
                    <th>{{ trans('app.action') }}</th>
                </thead>
                <tbody>
                    @forelse($roles as $key => $role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $role->label }}</td>
                        <td class="text-center">{{ $role->users()->count() }}</td>
                        <td>
                            {!! link_to_route('roles.index','detail',['act' => 'show', 'id' => $role->id],['class'=>'btn btn-info btn-xs']) !!}
                            {!! link_to_route('roles.index','edit',['act' => 'edit', 'id' => $role->id],['class'=>'btn btn-warning btn-xs']) !!}
                            {!! link_to_route('roles.index','x',['act' => 'del', 'id' => $role->id],['class'=>'btn btn-danger btn-xs']) !!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">{{ trans('role.not_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
