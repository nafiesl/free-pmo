@extends('layouts.app')

@section('title', 'Laporan Tahunan : ' . $year)

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('reports.payments.yearly', 'Laporan Tahun ' . $year, ['year' => $year]) }}</li>
    <li class="active">Laporan Tahunan</li>
</ul>

<h1 class="page-header">Laporan Tahunan : {{ $year }}</h1>

{!! Form::open(['method'=>'get','class'=>'form-inline well well-sm']) !!}
{!! Form::select('year', $years, $year, ['class'=>'form-control']) !!}
{!! Form::submit('Lihat Laporan', ['class'=>'btn btn-info']) !!}
{!! link_to_route('reports.payments.yearly','Tahun ini',[],['class'=>'btn btn-default']) !!}
{!! Form::close() !!}

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">Grafik Profit {{ $year }}</h3></div>
    <div class="panel-body">
        <strong>Rp.</strong>
        <div id="yearly-chart" style="height: 250px;"></div>
        <div class="text-center"><strong>Bulan</strong></div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading"><h3 class="panel-title">Detail Laporan</h3></div>
    <div class="panel-body table-responsive">
        <table class="table table-condensed">
            <thead>
                <th class="text-center">Bulan</th>
                <th class="text-center">Jumlah Transfer</th>
                <th class="text-right">Uang Masuk</th>
                <th class="text-right">Uang Keluar</th>
                <th class="text-right">Profit</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php
                    $cartData = [];
                ?>
                @foreach(getMonths() as $monthNumber => $monthName)
                <?php
                    $any = isset($reports[$monthNumber]);
                    $count = $any ? $reports[$monthNumber]->count : 0;
                    $cashin = $any ? $reports[$monthNumber]->cashin : 0;
                    $cashout = $any ? $reports[$monthNumber]->cashout : 0;
                    $profit = $any ? $reports[$monthNumber]->profit : 0;
                ?>
                <tr>
                    <td class="text-center">{{ monthId($monthNumber) }}</td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-right">{{ formatRp($cashin) }}</td>
                    <td class="text-right">{{ formatRp($cashout) }}</td>
                    <td class="text-right">{{ formatRp($profit) }}</td>
                    <td class="text-center">
                        {!! link_to_route(
                            'reports.payments.monthly',
                            'Lihat Bulanan',
                            ['month' => $monthNumber, 'year' => $year],
                            [
                                'class'=>'btn btn-info btn-xs',
                                'title'=>'Lihat laporan bulanan ' . monthId($monthNumber)
                            ]
                        ) !!}
                    </td>
                </tr>
                <?php
                    $cartData[] = ['month' => monthId($monthNumber), 'value' => $profit];
                ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">{{ $reports->sum('count') }}</th>
                    <th class="text-right">{{ formatRp($reports->sum('cashin')) }}</th>
                    <th class="text-right">{{ formatRp($reports->sum('cashout')) }}</th>
                    <th class="text-right">{{ formatRp($reports->sum('profit')) }}</th>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/morris.css')) !!}
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/morris/raphael.min.js')) !!}
    {!! Html::script(url('assets/js/plugins/morris/morris.min.js')) !!}
@endsection

@section('script')
<script>
(function() {
    new Morris.Line({
        element: 'yearly-chart',
        data: {!! json_encode($cartData) !!},
        xkey: 'month',
        ykeys: ['value'],
        labels: ['Profit'],
        parseTime:false,
        goals: [0],
        goalLineColors : ['red'],
    });
})();
</script>
@endsection
