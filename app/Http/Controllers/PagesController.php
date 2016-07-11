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
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
	}

}
