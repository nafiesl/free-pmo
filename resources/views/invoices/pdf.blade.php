<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INV-{{ $invoice->number }}</title>
    <style>
        html {
            /*margin: 10px 20px 0px 20px;*/
            font-family: 'Trebuchet MS';
        }
        p {
            margin: 10px 0px;
        }
        table.receipt-table {
            /*border: 1px solid #aaa;*/
            border-collapse: collapse;
            /*font-size:14px;*/
            max-width: 750px;
        }
        table.receipt-table th, table.receipt-table td {
            padding: 5px;
        }
        .text-left {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-top {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <table class="receipt-table">
        <tbody>
            <tr>
                <td style="width:100px;">
                    {!! appLogoImage(['style' => 'width:100%']) !!}
                </td>
                <td style="width:380px">
                    <div style="width:300px">
                        <h4 style="margin:0px; border-bottom: 3px; font-size: 21.5px">
                            {{ Option::get('agency_name') }}
                        </h4>
                        <div style="font-size:13px">{{ Option::get('agency_tagline') }}</div>
                        @if (Option::get('agency_address'))
                        <hr style="margin: 2px 0">
                        <div style="font-size:11px">
                            {{ Option::get('agency_address') }}<br>
                            @if (Option::get('agency_phone'))
                            @lang('contact.phone_abb') {{ Option::get('agency_phone') }}
                            @endif
                        </div>
                        @endif
                    </div>
                </td>
                <td style="width:270px; text-align: center;">
                    <h3 style="margin: 3px 0; font-size: 24px">{{ trans('invoice.invoice') }}</h3>
                    <div style="margin: 5px">{{ trans('invoice.number') }} : INV-{{ $invoice->number }}</div>
                    <div>{{ trans('app.date') }} : {{ dateId($invoice->date) }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4 style="margin: 3px 0;">{{ trans('app.to') }} :</h4>
                    @php
                        $customer = $invoice->project->customer;
                    @endphp
                    <p><strong>{{ $customer->name }}</strong></p>
                    @if ($customer->address)
                    <p style="max-width: 250px;font-size: 14px">{!! nl2br($customer->address) !!}</p>
                    @endif
                    @if ($customer->phone)
                    <p>{{ trans('contact.phone') }} : {{ $customer->phone }}</p>
                    @endif
                    @if ($customer->website)
                    <p>{{ $customer->website }}</p>
                    @endif
                    @if ($customer->pic)
                    <p><strong>UP. {{ $customer->pic }}</strong></p>
                    @endif
                </td>
                <td class="text-center text-top">
                    @if ($invoice->due_date)
                    <h4 style="margin: 30px 3px 0;">{{ trans('invoice.due_date') }}</h4>
                    <p>{{ dateId($invoice->due_date) }}</p>
                    @endif
                </td>
            </tr>
            <tr><td colspan="3">{{ trans('invoice.items') }} :</td></tr>
            <tr>
                <td colspan="3">
                <table border="1" class="receipt-table" style="width: 100%;font-size: 14px">
                    <thead style="background-color: #FFC800">
                        <tr>
                            <th width="5%">{{ trans('app.table_no') }}</th>
                            <th width="70%" class="text-left">{{ trans('invoice.item_description') }}</th>
                            <th width="25%">{{ trans('invoice.item_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach ($invoice->items as $key => $item)
                            <tr>
                                <td class="text-center text-top">{{ 1 + $key }}</td>
                                <td>{!! nl2br($item['description']) !!}</td>
                                <td class="text-right text-top">{{ formatRp($item['amount']) }}</td>
                            </tr>
                            @php
                                $subtotal += $item['amount'];
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if ($invoice->discount)
                        <tr>
                            <th colspan="2" class="text-right">{{ __('invoice.subtotal') }} :</th>
                            <th class="text-right">{{ formatRp($subtotal) }}</th>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <strong>{{ __('invoice.discount') }}</strong>
                                {{ $invoice->discount_notes ? '('.$invoice->discount_notes.')': '' }} :
                            </td>
                            <th class="text-right">- {{ formatRp($invoice->discount) }}</th>
                        </tr>
                        @endif
                        <tr>
                            <th colspan="2" class="text-right">{{ trans('app.total') }}</th>
                            <th colspan="2" class="text-right">{{ formatRp($invoice->amount) }}</th>
                        </tr>
                    </tfoot>
                </table>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td style="padding-top: 20px;">{{ trans('payment.words_amount') }} : </td>
                <td colspan="2" style="font-weight: bold; padding-top: 20px">
                    {{ ucwords(Terbilang::make($invoice->amount)) }} {{ Option::get('money_sign_in_word', 'Rupiah') }}
                </td>
            </tr>
            @if ($invoice->notes)
            <tr style="vertical-align: top;">
                <td colspan="3">
                    <p style="font-style: italic;"><strong>{{ __('app.notes') }}</strong> : {!! nl2br($invoice->notes) !!}</p>
                </td>
            </tr>
            @endif
            <tr style="vertical-align: top;">
                <td colspan="3">
                    @empty ($bankAccounts)
                    @else
                        <p>{{ __('invoice.payment_instruction') }}</p>
                        @foreach ($bankAccounts as $key => $bankAccount)
                            @php $bankAccount = (object) $bankAccount; @endphp
                            <table style="border: 1px solid #ccc;width: 330px">
                                <tr><td style="width: 100px">{{ trans('bank_account.name') }}</td><td>: <strong>{{ $bankAccount->name }}</strong></td></tr>
                                <tr><td>{{ trans('bank_account.number') }}</td><td>: <strong>{{ $bankAccount->number }}</strong></td></tr>
                                <tr><td>{{ trans('bank_account.account_name') }}</td><td>: <strong>{{ $bankAccount->account_name }}</strong></td></tr>
                            </table>
                            @if ($key == count($bankAccounts)) <br> @endif
                        @endforeach
                    @endempty

                    <p>{{ __('invoice.thanks_text') }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">
                    {{ Option::get('agency_city') ? Option::get('agency_city').', ' : '' }}
                    {{ dateId($invoice->date) }} <br><br><br><br>
                    <div style="font-weight: bold;">{{ Option::get('agency_name') }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
