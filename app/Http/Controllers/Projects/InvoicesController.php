<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function index(Project $project)
    {
        return view('projects.invoices', compact('project'));
    }
}
