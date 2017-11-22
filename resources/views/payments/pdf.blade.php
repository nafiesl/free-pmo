<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('payment.print') }}</title>
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
                <td style="width:140px;">
                    {{ Html::image(url('assets/imgs/logo.png'), '', ['style' => 'width: 100px;']) }}
                </td>
                <td style="width:330px">
                    <div style="width:280px">
                        <h4 style="margin:0px; border-bottom: 3px; font-size: 21.5px">JasaWebsiteBanjarmasin.com</h4>
                        <div style="font-size:13px">Jasa Pembuatan Website dan Aplikasi Berbasis Web</div>
                        <hr style="margin: 2px 0">
                        <div style="font-size:11px">
                            Jln. Pramuka, Gg. Mawar, Rt. 09, No. 60, Kel. Pemurus Luar<br>
                            Kec. Banjarmasin Timur, Kota Banjarmasin,
                            Kalsel - 70249,<br>
                            @lang('contact.phone_abb') 0817 532 654 / 0823 5035 5470
                        </div>
                    </div>
                </td>
                <td style="width:250px; text-align: center;">
                    <h3 style="margin: 3px 0; font-size: 24px">@lang('payment.receipt')</h3>
                    {{-- <p>No. Invoice: __________</p> --}}
                </td>
            </tr>
            <tr>
                <td>@lang('payment.from') : </td>
                <td colspan="2" style="border-bottom: 1px solid #ccc;">{{ $payment->partner->name }}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>@lang('payment.words_amount') : </td>
                <td colspan="2" style="border-bottom: 1px solid #ccc;height: 35px">
                    {{ ucwords(Terbilang::make($payment->amount)) }} Rupiah 
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <td>@lang('payment.description') :</td>
                <td colspan="2" style="border-bottom: 1px solid #ccc;height: 35px">
                    {{ $payment->description }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: center;">
                    Banjarmasin, {{ dateId($payment->date) }}
                </td>
            </tr>
            <tr>
                <td style="font-size: 20px; font-weight: bold; text-align: center;height: 100px;vertical-align: bottom;">@lang('payment.cash_amount')</td>
                <td style="font-size: 20px; font-weight: bold; vertical-align: bottom;">
                {{ formatRp($payment->amount) }},-
                </td>
                <td style="text-align: center;vertical-align: bottom;">
                    <strong>{{ auth()->user()->name }}, S. Kom.</strong> <br>
                    JasaWebsiteBanjarmasin.com
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
