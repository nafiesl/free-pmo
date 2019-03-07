<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Entities\Projects\Issue;
use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;

class IssueController extends Controller
{
    public function index(Project $project)
    {
        $issues = $project->issues;

        return view('projects.issues', compact('project', 'issues'));
    }

    public function create(Project $project)
    {
        return view('projects.issues.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $issueData = $request->validate([
            'title' => 'required|max:60',
            'body'  => 'required|max:255',
        ]);
        Issue::create([
            'project_id' => $project->id,
            'creator_id' => auth()->id(),
            'title'      => $issueData['title'],
            'body'       => $issueData['body'],
        ]);
        flash(__('issue.created'), 'success');

        return redirect()->route('projects.issues.index', $project);
    }

    public function show(Project $project, Issue $issue)
    {
        return view('projects.issues.show', compact('project', 'issue'));
    }

    public function edit(Project $project, Issue $issue)
    {
        return view('projects.issues.edit', compact('project', 'issue'));
    }

    public function update(Request $request, Project $project, Issue $issue)
    {
        $issueData = $request->validate([
            'title' => 'required|max:60',
            'body'  => 'required|max:255',
        ]);
        $issue->title = $issueData['title'];
        $issue->body = $issueData['body'];
        $issue->save();

        flash(__('issue.updated'), 'success');

        return redirect()->route('projects.issues.show', [$project, $issue]);
    }
}
