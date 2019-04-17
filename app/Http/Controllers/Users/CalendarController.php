<?php

namespace App\Http\Controllers\Users;

use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin') == false) {
            $projects = $user->projects()->orderBy('projects.name')->pluck('projects.name', 'projects.id');
        } else {
            $projects = Project::orderBy('name')->pluck('name', 'id');
        }

        return view('users.calendar', compact('projects'));
    }
}
