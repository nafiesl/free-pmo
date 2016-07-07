@extends('layouts.app')

@section('title', trans('user.permissions'))

@section('content')
<h1 class="page-header">
    @if (Request::get('act') != 'add')
    {!! link_to_route('permissions.index', trans('permission.create'), ['act' => 'add'], ['class'=>'btn btn-success pull-right']) !!}
    @endif
    {{ trans('permission.permissions') }}
</h1>

<div class="row">
    <div class="col-md-4 col-md-push-8">
        @if (Request::get('act') == 'add')
        <div class="panel panel-success">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('permission.create') }}</h3></div>
            <div class="panel-body">
                {!! Form::open(['route'=>'permissions.store']) !!}
                {!! FormField::text('name') !!}
                {!! FormField::text('label') !!}
                {!! Form::submit(trans('permission.create'), ['class' => 'btn btn-success']) !!}
                {!! link_to_route('permissions.index', trans('app.cancel'), [], ['class'=>'btn btn-default pull-right']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        @elseif (Request::get('act') == 'edit' && !is_null($permission))
        <div class="panel panel-warning">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('permission.edit') }}</h3></div>
            <div class="panel-body">
                {!! Form::model($permission, ['route'=>['permissions.update', $permission->id],'method'=>'patch']) !!}
                {!! FormField::text('name') !!}
                {!! FormField::text('label') !!}
                {!! Form::submit(trans('permission.update'), ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('permissions.index', trans('app.cancel'), [], ['class'=>'btn btn-default pull-right']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        @elseif (Request::get('act') == 'del' && !is_null($permission))
        <div class="panel panel-danger">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('permission.delete') }}</h3></div>
            <div class="panel-body">
                {{ trans('app.delete_confirm') }}
            </div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th>{{ trans('app.name') }}</th><td>{{ $permission->name }}</td></tr>
                    <tr><th>{{ trans('app.label') }}</th><td>{{ $permission->label }}</td></tr>
                    <tr><th>{{ trans('permission.roles_count') }}</th><td>{{ $permission->roles()->count() }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {!! link_to_route('permissions.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
                @if ($permission->roles()->count() < 1)
                {!! FormField::delete(['route'=>['permissions.destroy',$permission->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger pull-right'], ['permission_id'=>$permission->id]) !!}
                @endif
            </div>
        </div>
        @elseif (Request::get('act') == 'show' && !is_null($permission))
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('permission.show') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th>{{ trans('app.name') }}</th><td>{{ $permission->name }}</td></tr>
                    <tr><th>{{ trans('app.label') }}</th><td>{{ $permission->label }}</td></tr>
                    <tr><th>{{ trans('permission.roles_count') }}</th><td>{{ $permission->roles()->count() }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {!! link_to_route('permissions.index', trans('app.edit'), ['act'=>'edit','id'=>$permission->id], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('permissions.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('role.roles') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    @foreach($permission->roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->label }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <div class="col-md-8 col-md-pull-4">
        <div class="panel panel-default">
        <table class="table table-condensed">
            <thead>
                <th>{{ trans('app.table_no') }}</th>
                <th>{{ trans('app.name') }}</th>
                <th>{{ trans('app.label') }}</th>
                <th class="text-center">{{ trans('permission.roles_count') }}</th>
                <th>{{ trans('app.action') }}</th>
            </thead>
            <tbody>
                @forelse($permissions as $key => $permission)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->label }}</td>
                    <td class="text-center">{{ $permission->roles_count }}</td>
                    <td>
                        {!! link_to_route('permissions.index','detail',['act' => 'show', 'id' => $permission->id],['class'=>'btn btn-info btn-xs']) !!}
                        {!! link_to_route('permissions.index','edit',['act' => 'edit', 'id' => $permission->id],['class'=>'btn btn-warning btn-xs']) !!}
                        {!! link_to_route('permissions.index','x',['act' => 'del', 'id' => $permission->id],['class'=>'btn btn-danger btn-xs']) !!}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">{{ trans('permission.not_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
