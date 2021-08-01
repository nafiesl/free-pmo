<?php

namespace App\Http\Controllers;

use App\Entities\Reports\ReportsRepository;
use Illuminate\Http\Request;

/**
 * Reports Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ReportsController extends Controller
{
    private $repo;

    public function __construct(ReportsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $req)
    {
        $reports = $this->repo->getAll($req->get('q'));

        return view('reports.payments.index', compact('reports'));
    }

    public function daily(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($startDate && $endDate) {
            $payments = $this->repo->getDailyReportByDateRange($startDate, $endDate);
        } else {
            $payments = $this->repo->getDailyReports($date);
        }

        return view('reports.payments.daily', compact('payments', 'date'));
    }

    public function monthly(Request $req)
    {
        $year = date('Y');
        $month = date('m');
        if ($req->has('year') && $req->has('month')) {
            $year = $req->get('year');
            $month = $req->get('month');
        }
        $reports = $this->repo->getMonthlyReports($year, $month);
        $months = \get_months();
        $years = \get_years();

        return view('reports.payments.monthly', compact('reports', 'months', 'years', 'month', 'year'));
    }

    public function yearly(Request $request)
    {
        $years = \get_years();
        $year = $request->get('year', date('Y'));
        $reportFormat = $request->get('format', 'in_months');

        if ($reportFormat == 'in_weeks') {
            $reports = $this->repo->getYearlyInWeeksReports($year);
            $chartData = $this->repo->getYearlyInWeeksReportChartData($year, $reports);
        } else {
            $reports = $this->repo->getYearlyReports($year);
            $chartData = $this->repo->getYearlyReportChartData($reports);
        }

        return view('reports.payments.yearly', compact('reports', 'years', 'year', 'reportFormat', 'chartData'));
    }

    public function yearToYear(Request $request)
    {
        $reports = $this->repo->getYearToYearReports();

        return view('reports.payments.year_to_year', compact('reports'));
    }

    public function currentCredits()
    {
        $projects = $this->repo->getCurrentCredits();

        return view('reports.current-credits', compact('projects'));
    }
}
