@extends('layouts.app')

@section('title', trans('partner.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('partners.index', trans('partner.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
    </div>
    {{ trans('partner.list') }}
    <small>{{ trans('app.total') }} : {{ $partners->total() }} {{ trans('partner.partner') }}</small>
</h1>

@includeWhen(Request::has('action'), 'partners.forms')

<div class="panel panel-default table-responsive">
    <div class="panel-heading">
        {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
        {!! FormField::text('q', ['value' => request('q'), 'label' => trans('partner.search'), 'class' => 'input-sm']) !!}
        {{ Form::submit(trans('partner.search'), ['class' => 'btn btn-sm']) }}
        {{ link_to_route('partners.index', trans('app.reset')) }}
        {{ Form::close() }}
    </div>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class="text-center">{{ trans('app.table_no') }}</th>
                <th>{{ trans('partner.name') }}</th>
                <th>{{ trans('contact.email') }}</th>
                <th>{{ trans('contact.phone') }}</th>
                <th class="text-center">{{ trans('partner.projects_count') }}</th>
                <th class="text-center">{{ trans('app.status') }}</th>
                <th class="text-center">{{ trans('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partners as $key => $partner)
            <tr>
                <td class="text-center">{{ $partners->firstItem() + $key }}</td>
                <td>{{ $partner->name }}</td>
                <td>{{ $partner->email }}</td>
                <td>{{ $partner->phone }}</td>
                <td class="text-center">{{ $partner->projects_count }}</td>
                <td class="text-center">{{ $partner->is_active }}</td>
                <td class="text-center">
                    {!! link_to_route(
                        'partners.index',
                        trans('app.edit'),
                        ['action' => 'edit', 'id' => $partner->id] + Request::only('page', 'q'),
                        ['id' => 'edit-partner-' . $partner->id]
                        ) !!} |
                    {!! link_to_route(
                        'partners.index',
                        trans('app.delete'),
                        ['action' => 'delete', 'id' => $partner->id] + Request::only('page', 'q'),
                        ['id' => 'del-partner-' . $partner->id]
                        ) !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel-body">{{ $partners->appends(Request::except('page'))->render() }}</div>
    </div>
</div>
</div>
@endsection
