@extends('layouts.app')

@section('title', trans('bank_account.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('bank-accounts.index', trans('bank_account.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
    </div>
    {{ trans('bank_account.list') }}
    <small>{{ trans('app.total') }} : {{ count($bankAccounts) }} {{ trans('bank_account.bank_account') }}</small>
</h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('bank_account.name') }}</th>
                        <th>{{ trans('bank_account.number') }}</th>
                        <th>{{ trans('bank_account.account_name') }}</th>
                        <th>{{ trans('bank_account.description') }}</th>
                        <th class="text-center">{{ trans('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bankAccounts as $key => $bankAccount)
                    @php
                        $bankAccount = (object) $bankAccount;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $key }}</td>
                        <td>{{ $bankAccount->name }}</td>
                        <td>{{ $bankAccount->number }}</td>
                        <td>{{ $bankAccount->account_name }}</td>
                        <td>{{ $bankAccount->description }}</td>
                        <td class="text-center">
                            {!! link_to_route(
                                'bank-accounts.index',
                                trans('app.edit'),
                                ['action' => 'edit', 'id' => $key],
                                ['id' => 'edit-bank_account-' . $key]
                            ) !!} |
                            {!! link_to_route(
                                'bank-accounts.index',
                                trans('app.delete'),
                                ['action' => 'delete', 'id' => $key],
                                ['id' => 'del-bank_account-' . $key]
                            ) !!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">{{ trans('bank_account.empty') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        @includeWhen(Request::has('action'), 'bank-accounts.forms')
    </div>
</div>
@endsection
