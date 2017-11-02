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
                $invoicesCount = 0;
                $sumTotal = 0;
                $sumCapital = 0;
                $sumProfit = 0;
                $cartData = [];
                ?>
                @forelse($reports as $key => $report)
                <tr>
                    <td class="text-center">{{ monthId($report->month) }}</td>
                    <td class="text-center">{{ $report->count }}</td>
                    <td class="text-right">{{ formatRp($report->cashin) }}</td>
                    <td class="text-right">{{ formatRp($report->cashout) }}</td>
                    <td class="text-right">{{ formatRp(($report->cashin - $report->cashout)) }}</td>
                    <td class="text-center">{!! link_to_route('reports.payments.monthly','Lihat Bulanan', ['month' => monthNumber($report->month), 'year' => $year], ['class'=>'btn btn-info btn-xs','title'=>'Lihat laporan bulanan ' . monthId($report->month)]) !!}</td>
                </tr>
                <?php
                $invoicesCount += $report->count;
                $sumTotal += $report->cashin;
                $sumCapital += $report->cashout;
                $sumProfit += ($report->cashin - $report->cashout);
                $cartData[] = ['month'=>monthId($report->month),'value'=>($report->cashin - $report->cashout)];
                ?>
                @empty
                <tr><td colspan="6">{{ trans('payment.not_found') }}</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">{{ $invoicesCount }}</th>
                    <th class="text-right">{{ formatRp($sumTotal) }}</th>
                    <th class="text-right">{{ formatRp($sumCapital) }}</th>
                    <th class="text-right">{{ formatRp($sumProfit) }}</th>
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
