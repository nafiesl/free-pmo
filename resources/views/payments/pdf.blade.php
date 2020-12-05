<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('payment.print') }}</title>
    <style>
        html {
            margin: 10px 20px 0px 20px;
        }
        table.receipt-table {
            /*border: 1px solid #aaa;*/
            border-collapse: collapse;
            font-size:16px;
            max-width: 750px;
        }
        table.receipt-table td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <table class="receipt-table">
        <tbody>
            <tr>
                <td style="width:140px;">{{ app_logo_image(['style' => 'width: 100px;']) }}</td>
                <td style="width:330px">
                    <div style="width:280px">
                        <h4 style="margin:0px; border-bottom: 3px; font-size: 21.5px">{{ Option::get('agency_name') }}</h4>
                        <div style="font-size:13px">{{ Option::get('agency_tagline') }}</div>
                        @if (Option::get('agency_address'))
                        <hr style="margin: 2px 0">
                        <div style="font-size:11px">
                            {{ Option::get('agency_address') }}<br>
                            @if (Option::get('agency_phone'))
                            {{ __('contact.phone_abb') }} {{ Option::get('agency_phone') }}
                            @endif
                        </div>
                        @endif
                    </div>
                </td>
                <td style="width:250px; text-align: center;">
                    <h3 style="margin: 3px 0; font-size: 24px">{{ __('payment.receipt') }}</h3>
                    {{-- <p>No. Invoice: __________</p> --}}
                </td>
            </tr>
            <tr>
                <td>{{ __('payment.from') }} : </td>
                <td colspan="2" style="border-bottom: 1px solid #ccc;">{{ $payment->partner->name }}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>{{ __('payment.words_amount') }} : </td>
                <td colspan="2" style="border-bottom: 1px solid #ccc;height: 35px">
                    {{ ucwords(Terbilang::make($payment->amount)) }} Rupiah
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td>{{ __('payment.description') }} :</td>
                <td colspan="2" style="border-bottom: 1px solid #ccc;height: 35px">
                    {{ $payment->description }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: center;">
                    {{ Option::get('agency_city') ? Option::get('agency_city').', ' : '' }} {{ date_id($payment->date) }}
                </td>
            </tr>
            <tr>
                <td style="font-size: 20px; font-weight: bold; text-align: center;height: 100px;vertical-align: bottom;">{{ __('payment.cash_amount') }}</td>
                <td style="font-size: 20px; font-weight: bold; vertical-align: bottom;">
                {{ format_money($payment->amount) }},-
                </td>
                <td style="text-align: center;vertical-align: bottom;">
                    <strong>{{ auth()->user()->name }}</strong> <br>
                    {{ Option::get('agency_name') }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
