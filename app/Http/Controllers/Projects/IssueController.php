<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;

class IssueController extends Controller
{
    public function index(Project $project)
    {
        $issues = $project->issues;

        return view('projects.issues', compact('project', 'issues'));
    }
}
