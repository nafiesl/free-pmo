<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Reports\ReportsRepository;

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
        $months = \getMonths();
        $years = \getYears();

        return view('reports.payments.monthly', compact('reports', 'months', 'years', 'month', 'year'));
    }

    public function yearly(Request $req)
    {
        $year = $req->get('year', date('Y'));

        $reports = $this->repo->getYearlyReports($year);
        $years = \getYears();

        return view('reports.payments.yearly', compact('reports', 'years', 'year'));
    }

    public function currentCredits()
    {
        $projects = $this->repo->getCurrentCredits();

        return view('reports.current-credits', compact('projects'));
    }
}
