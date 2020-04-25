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
    /**
     * Invoice list of a project.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\View\View
     */
    public function index(Project $project)
    {
        $this->authorize('view-invoices', $project);

        $invoices = $project->invoices()->orderBy('date', 'desc')->get();

        return view('projects.invoices', compact('project', 'invoices'));
    }
}
