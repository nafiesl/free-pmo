<?php

namespace App\Http\Controllers;

use App\Entities\Pages\PagesRepository;
use App\Entities\Projects\Project;
use DB;

class PagesController extends Controller {
    private $repo;


	public function __construct(PagesRepository $repo)
	{
        $this->repo = $repo;
	}

    public function home()
    {
        $projectsCount = Project::select(DB::raw('status_id, count(id) as count'))
            ->groupBy('status_id')
            ->where('owner_id', auth()->id())
            ->lists('count','status_id')
            ->all();
        return view('pages.home', compact('projectsCount'));
    }

    public function about()
    {
        return view('pages.about');
	}

}
