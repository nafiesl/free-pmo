<?php

namespace App\Http\Controllers;

use App\Entities\Pages\PagesRepository;

class PagesController extends Controller {
    private $repo;


	public function __construct(PagesRepository $repo)
	{
        $this->repo = $repo;
	}

    public function home()
    {
        $totalIncome = $this->repo->getTotalIncome();
        $totalExpenditure = $this->repo->getTotalExpenditure();

        return view('pages.home', compact('totalIncome','totalExpenditure'));
    }

    public function about()
    {
        return view('pages.about');
	}

}
