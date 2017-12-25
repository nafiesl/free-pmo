@extends('layouts.dashboard')

@section('title', trans('bank_account.list'))

@section('content-dashboard')

<div class="row">
    <div class="col-md-8">
        @foreach ($bankAccounts as $key => $bankAccount)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h3 class="panel-title">{{ $bankAccount->name }}</h3></div>
                    <div class="panel-body">
                        <p>{{ trans('bank_account.number') }}:<br><strong class="lead">{{ $bankAccount->number }}</strong></p>
                        <p>{{ trans('bank_account.account_name') }}:<br><strong class="lead">{{ $bankAccount->account_name }}</strong></p>
                        @if ($bankAccount->description)
                        <p>{{ trans('app.description') }}:<br>{{ $bankAccount->description }}</p>
                        @endif
                    </div>
                    <div class="panel-footer">
                        {!! link_to_route(
                            'bank-accounts.index',
                            trans('app.edit'),
                            ['action' => 'edit', 'id' => $key],
                            ['id' => 'edit-bank_account-' . $key]
                        ) !!}
                        {!! link_to_route(
                            'bank-accounts.index',
                            trans('app.delete'),
                            ['action' => 'delete', 'id' => $key],
                            ['id' => 'del-bank_account-' . $key, 'class' => 'pull-right']
                        ) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-4">
        @if (Request::has('action') == false)
            {!! html_link_to_route('bank-accounts.index', trans('bank_account.create'), ['action' => 'create'], [
                'class'=>'btn btn-success',
                'icon' => 'plus'
            ]) !!}
        @endif
        @includeWhen(Request::has('action'), 'bank-accounts.forms')
    </div>
</div>
@endsection
