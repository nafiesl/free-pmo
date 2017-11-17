<?php

namespace App\Http\Controllers;

use App\Entities\Projects\JobsRepository;

class JobsController extends Controller
{

    private $repo;

    public function __construct(JobsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $jobs = $this->repo->getUnfinishedJobs();
        return view('jobs.unfinished', compact('jobs'));
    }
}
