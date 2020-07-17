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
     * @param \App\Entities\Payments\Payment  $model
     */
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get payment daily report.
     *
     * @param  string  $date
     * @param  string  $q
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDailyReports($date, $q)
    {
        return Payment::orderBy('date', 'desc')
            ->where('date', $date)
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
