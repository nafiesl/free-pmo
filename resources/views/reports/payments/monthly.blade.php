@extends('layouts.app')

@section('title', 'Laporan Bulanan : ' . $months[$month] . ' ' . $year)

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('reports.payments.yearly', 'Laporan Tahun ' . $year, ['year' => $year]) }}</li>
    <li class="active">{{ $months[$month] }}</li>
</ul>

{{ Form::open(['method' => 'get', 'class' => 'form-inline well well-sm']) }}
{{ Form::label('month', 'Laporan Bulanan per', ['class' => 'control-label']) }}
{{ Form::select('month', $months, $month, ['class' => 'form-control']) }}
{{ Form::select('year', $years, $year, ['class' => 'form-control']) }}
{{ Form::submit('Lihat Laporan', ['class' => 'btn btn-info btn-sm']) }}
{{ link_to_route('reports.payments.monthly', 'Bulan ini', [], ['class' => 'btn btn-default btn-sm']) }}
{{ link_to_route('reports.payments.yearly', 'Lihat Tahunan', ['year' => $year], ['class' => 'btn btn-default btn-sm']) }}
{{ Form::close() }}

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">Grafik Profit {{ $months[$month] }} {{ $year }}</h3></div>
    <div class="panel-body">
        <strong>Rp.</strong>
        <div id="monthly-chart" style="height: 250px;"></div>
        <div class="text-center"><strong>{{ trans('app.date') }}</strong></div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading"><h3 class="panel-title">Detail Laporan</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <thead>
                <th class="text-center">{{ trans('app.date') }}</th>
                <th class="text-center">Jumlah Transfer</th>
                <th class="text-right">Uang Masuk</th>
                <th class="text-right">Uang Keluar</th>
                <th class="text-right">Profit</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $cartData = [];?>
                @foreach(monthDateArray($year, $month) as $dateNumber)
                <?php
                    $any = isset($reports[$dateNumber]);
                    $profit = $any ? $reports[$dateNumber]->profit : 0;
                    if ($any):
                ?>
                <tr>
                    <td class="text-center">{{ dateId($date = $year . '-' . $month . '-' . $dateNumber) }}</td>
                    <td class="text-center">{{ $any ? $reports[$dateNumber]->count : 0 }}</td>
                    <td class="text-right">{{ formatRp($any ? $reports[$dateNumber]->cashin : 0) }}</td>
                    <td class="text-right">{{ formatRp($any ? $reports[$dateNumber]->cashout : 0) }}</td>
                    <td class="text-right">{{ formatRp($profit) }}</td>
                    <td class="text-center">
                        {{ link_to_route(
                            'reports.payments.daily',
                            'Lihat Harian',
                            ['date' => $date],
                            [
                                'class' => 'btn btn-info btn-xs',
                                'title' => 'Lihat laporan harian ' . $date
                            ]
                        ) }}
                    </td>
                </tr>
                <?php
                    endif;
                    $cartData[] = ['date' => $dateNumber, 'value' => ($profit)];
                ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right">Jumlah</th>
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
    {{ Html::style(url('assets/css/plugins/morris.css')) }}
@endsection

@section('ext_js')
    {{ Html::script(url('assets/js/plugins/morris/raphael.min.js')) }}
    {{ Html::script(url('assets/js/plugins/morris/morris.min.js')) }}
@endsection

@section('script')
<script>
(function() {
    new Morris.Line({
        element: 'monthly-chart',
        data: {!! collect($cartData)->toJson() !!},
        xkey: 'date',
        ykeys: ['value'],
        labels: ['Profit Rp'],
        parseTime:false,
        xLabelAngle: 30,
        goals: [0],
        goalLineColors : ['red'],
        smooth: false,
    });
})();
</script>
@endsection
