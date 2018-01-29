@extends('layouts.dashboard')

@section('title', trans('option.list'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-4">
        {{ Form::open(['route' => 'site-options.save-1', 'method' => 'patch']) }}
        <table class="table-condensed">
            <tbody>
                <tr>
                    <td class="col-xs-5" style="vertical-align: top">{{ trans('option.money_sign') }}</td>
                    <td class="col-xs-7">
                        {{ Form::text(
                            'money_sign',
                            Option::get('money_sign', 'Rp.'),
                            ['class' => 'form-control', 'maxlength' => 3]
                        ) }}
                        <span class="text-info small">
                            Money sign like : <strong>{{ formatRp('9900') }}</strong><br>(Max 3 characters)
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ Form::submit(trans('app.update'), ['class' => 'btn btn-warning']) }}
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        {{ Form::close() }}
    </div>
</div>
@endsection
