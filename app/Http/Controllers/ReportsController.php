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

    public function daily(Request $req)
    {
        $q = $req->get('q');
        $date = $req->get('date', date('Y-m-d'));

        $payments = $this->repo->getDailyReports($date, $q);

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

    public function yearly(Request $req)
    {
        $year = $req->get('year', date('Y'));

        $reports = $this->repo->getYearlyReports($year);
        $years = \get_years();

        return view('reports.payments.yearly', compact('reports', 'years', 'year'));
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
