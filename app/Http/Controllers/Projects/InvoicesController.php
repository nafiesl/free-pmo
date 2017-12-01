<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;

/**
 * Project Invoices Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoicesController extends Controller
{
    public function index(Project $project)
    {
        return view('projects.invoices', compact('project'));
    }
}
