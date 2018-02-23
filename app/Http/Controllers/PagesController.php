<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function home()
    {
        $user = auth()->user();
        $queriedYear = request('year', date('Y'));

        $userCurrentJobs = $user->jobs()
            ->whereHas('project', function ($query) {
                $query->whereIn('status_id', [2, 3]);
            })->with('tasks')->get();

        return view('pages.home', compact('queriedYear', 'user', 'userCurrentJobs'));
    }

    public function about()
    {
        return view('pages.about');
    }
}
