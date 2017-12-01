<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('invoice.print') }} - {{ $invoice->number }}</title>
    <style>
        html {
            margin: 10px 20px 0px 20px;
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
                    <div style="width:280px">
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
                    <div>{{ trans('invoice.number') }} : INV-{{ $invoice->number }}</div>
                    <div>{{ trans('app.date') }} : {{ dateId($invoice->created_at->format('Y-m-d')) }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <h4 style="margin: 3px 0;">{{ trans('app.to') }} :</h4>
                    <p><strong>{{ $invoice->project->customer->name }}</strong></p>
                </td>
            </tr>
            <tr><td colspan="3">{{ trans('project.jobs') }} :</td></tr>
            <tr>
                <td colspan="3">
                <table border="1" class="receipt-table" style="width: 100%">
                    <thead style="background-color: #FFC800">
                        <tr>
                            <th>{{ trans('app.table_no') }}</th>
                            <th class="text-left">{{ trans('invoice.item_description') }}</th>
                            <th>{{ trans('invoice.item_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $key => $item)
                            <tr>
                                <td class="text-center text-top">{{ 1 + $key }}</td>
                                <td>{!! nl2br($item['description']) !!}</td>
                                <td class="text-right text-top">{{ formatRp($item['amount']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right">{{ trans('app.total') }}</th>
                            <th colspan="2" class="text-right">{{ formatRp($invoice->amount) }}</th>
                        </tr>
                    </tfoot>
                </table>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td>{{ trans('payment.words_amount') }} : </td>
                <td colspan="2" style="font-weight: bold;">
                    {{ ucwords(Terbilang::make($invoice->amount)) }} Rupiah
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td colspan="3">
                    <p>Pembayaran dapat dilakukan melalui transfer ke rekening berikut:</p>
                    No. Rek : <strong>BCA // 782-0088-543</strong><br>
                    An. <strong>NAFIES LUTHFI</strong>
                    <p>Terima kasih atas kerjasamanya.</p>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">
                    {{ Option::get('agency_city') ? Option::get('agency_city').', ' : '' }}
                    {{ dateId($invoice->created_at->format('Y-m-d')) }} <br><br><br><br>
                    <div style="font-weight: bold;">{{ Option::get('agency_name') }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
