<?php

namespace App\Entities\Reports;

use App\Entities\BaseRepository;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use DB;

/**
 * Reports Repository Class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ReportsRepository extends BaseRepository
{
    /**
     * Payment model.
     *
     * @var \App\Entities\Payments\Payment
     */
    protected $model;

    /**
     * Create ReportsRepository class instance.
     *
     * @param  \App\Entities\Payments\Payment  $model
     */
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get payment daily report.
     *
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDailyReports($date)
    {
        return Payment::orderBy('date', 'desc')
            ->where('date', $date)
            ->with('partner', 'project')
            ->get();
    }

    public function getDailyReportByDateRange($startDate, $endDate)
    {
        return Payment::orderBy('date', 'desc')
            ->whereBetween('date', [$startDate, $endDate])
            ->with('partner', 'project')
            ->get();
    }

    /**
     * Get payment montly report by year and month.
     *
     * @param  string  $year
     * @param  string  $month
     * @return \Illuminate\Support\Collection
     */
    public function getMonthlyReports($year, $month)
    {
        $rawQuery = 'date, count(`id`) as count';
        $rawQuery .= ', sum(if(in_out = 1, amount, 0)) AS cashin';
        $rawQuery .= ', sum(if(in_out = 0, amount, 0)) AS cashout';

        $reportsData = DB::table('payments')->select(DB::raw($rawQuery))
            ->where(DB::raw('YEAR(date)'), $year)
            ->where(DB::raw('MONTH(date)'), $month)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $reports = [];
        foreach ($reportsData as $report) {
            $key = substr($report->date, -2);
            $reports[$key] = $report;
            $reports[$key]->profit = $report->cashin - $report->cashout;
        }

        return collect($reports);
    }

    /**
     * Get payment yearly report.
     *
     * @param  string  $year
     * @return \Illuminate\Support\Collection
     */
    public function getYearlyReports($year)
    {
        $rawQuery = 'MONTH(date) as month';
        $rawQuery .= ', count(`id`) as count';
        $rawQuery .= ', sum(if(in_out = 1, amount, 0)) AS cashin';
        $rawQuery .= ', sum(if(in_out = 0, amount, 0)) AS cashout';

        $reportsData = DB::table('payments')->select(DB::raw($rawQuery))
            ->where(DB::raw('YEAR(date)'), $year)
            ->groupBy(DB::raw('YEAR(date)'))
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy('date', 'asc')
            ->get();

        $reports = [];
        foreach ($reportsData as $report) {
            $key = str_pad($report->month, 2, '0', STR_PAD_LEFT);
            $reports[$key] = $report;
            $reports[$key]->profit = $report->cashin - $report->cashout;
        }

        return collect($reports);
    }

    public function getYearlyInWeeksReports(string $year)
    {
        $rawQuery = 'WEEK(date, 1) as week';
        $rawQuery .= ', count(`id`) as count';
        $rawQuery .= ', sum(if(in_out = 1, amount, 0)) AS cashin';
        $rawQuery .= ', sum(if(in_out = 0, amount, 0)) AS cashout';

        $reportsData = DB::table('payments')->select(DB::raw($rawQuery))
            ->where(DB::raw('YEAR(date)'), $year)
            ->groupBy(DB::raw('WEEK(date, 1)'))
            ->orderBy('date', 'asc')
            ->get();

        foreach ($reportsData as $report) {
            $key = $report->week;
            $reports[$key] = $report;
            $reports[$key]->profit = $report->cashin - $report->cashout;
        }

        return collect($reports);
    }

    public function getYearlyReportChartData($reportData)
    {
        $defaultMonthValues = collect(get_months())->map(function ($item, $key) {
            return [
                'month' => month_id($key),
                'value' => 0,
            ];
        });
        $chartData = $reportData->map(function ($item) {
            return [
                'month' => month_id($item->month),
                'value' => $item->profit,
            ];
        });

        return $defaultMonthValues->replace($chartData)->values();
    }

    public function getYearlyInWeeksReportChartData($year, $reportData)
    {
        $defaultWeekValues = collect(get_week_numbers($year))->map(function ($item, $key) {
            return [
                'week' => $key,
                'value' => 0,
            ];
        });
        $chartData = $reportData->map(function ($item) {
            return [
                'week' => $item->week,
                'value' => $item->profit,
            ];
        });

        return $defaultWeekValues->replace($chartData)->values();
    }

    public function getYearToYearReports()
    {
        $rawQuery = 'YEAR(date) as year';
        $rawQuery .= ', count(`id`) as count';
        $rawQuery .= ', sum(if(in_out = 1, amount, 0)) AS cashin';
        $rawQuery .= ', sum(if(in_out = 0, amount, 0)) AS cashout';

        $reportsData = DB::table('payments')->select(DB::raw($rawQuery))
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('date', 'asc')
            ->get();

        $reports = [];
        foreach ($reportsData as $report) {
            $key = str_pad($report->year, 2, '0', STR_PAD_LEFT);
            $reports[$key] = $report;
            $reports[$key]->profit = $report->cashin - $report->cashout;
        }

        return collect($reports);
    }

    /**
     * Get current credit/receiveble earnings report.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCurrentCredits()
    {
        // On Progress, Done, On Hold
        $projects = Project::whereIn('status_id', [2, 3, 6])->with('payments', 'customer')->get();

        return $projects->filter(function ($project) {
            return $project->cashInTotal() < $project->project_value;
        })->values();
    }
}
