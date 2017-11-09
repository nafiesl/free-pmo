<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\ProjectsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\CreateRequest;
use App\Http\Requests\Projects\DeleteRequest;
use App\Http\Requests\Projects\UpdateRequest;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    private $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $status = null;
        $statusId = $request->get('status');
        if ($statusId) {
            $status = $this->repo->getStatusName($statusId);
        }

        $projects = $this->repo->getProjects($request->get('q'), $statusId);
        return view('projects.index', compact('projects', 'status'));
    }

    public function create()
    {
        $customers = $this->repo->getCustomersList();
        return view('projects.create', compact('customers'));
    }

    public function store(CreateRequest $request)
    {
        $project = $this->repo->create($request->except('_token'));
        flash()->success(trans('project.created'));
        return redirect()->route('projects.show', $project->id);
    }

    public function show($projectId)
    {
        $project = $this->repo->requireById($projectId);
        return view('projects.show', compact('project'));
    }

    public function edit($projectId)
    {
        $project = $this->repo->requireById($projectId);
        $statuses = getProjectStatusesList();
        $customers = $this->repo->getCustomersList();
        return view('projects.edit', compact('project', 'statuses', 'customers'));
    }

    public function update(UpdateRequest $request, $projectId)
    {
        $project = $this->repo->update($request->except(['_method', '_token']), $projectId);
        flash()->success(trans('project.updated'));
        return redirect()->route('projects.edit', $projectId);
    }

    public function delete($projectId)
    {
        $project = $this->repo->requireById($projectId);
        return view('projects.delete', compact('project'));
    }

    public function destroy(DeleteRequest $request, $projectId)
    {
        if ($projectId == $request->get('project_id')) {
            $this->repo->delete($projectId);
            flash()->success(trans('project.deleted'));
        } else {
            flash()->error(trans('project.undeleted'));
        }

        return redirect()->route('projects.index');
    }

    public function features($projectId)
    {
        $project = $this->repo->requireById($projectId);
        $features = $this->repo->getProjectFeatures($projectId);
        return view('projects.features', compact('project', 'features'));
    }

    public function subscriptions($projectId)
    {
        $project = $this->repo->requireById($projectId);
        return view('projects.subscriptions', compact('project'));
    }

    public function featuresExport(Request $request, $projectId, $exportType = 'excel')
    {
        $featureType = $request->get('feature_type', 1);
        $project = $this->repo->requireById($projectId);
        $features = $this->repo->getProjectFeatures($projectId, $featureType);

        if ($exportType == 'excel') {
            return view('projects.features-export-excel', compact('project', 'features'));
            \Excel::create(str_slug(trans('project.features').'-'.$project->name), function ($excel) use ($project, $features) {
                $excel->sheet('testng', function ($sheet) use ($project, $features) {
                    $sheet->loadView('projects.features-export-excel', compact('project', 'features'));
                });
            })->download('xls');
        } elseif ($exportType == 'excel-progress') {
            return view('projects.features-export-progress-excel', compact('project', 'features'));
            \Excel::create(str_slug(trans('project.features').'-'.$project->name), function ($excel) use ($project, $features) {
                $excel->sheet('export-progress', function ($sheet) use ($project, $features) {
                    $sheet->loadView('projects.features-export-progress-excel', compact('project', 'features'));
                });
            })->download('xls');
        } else {
            return view('projects.features-export-html-2', compact('project', 'features'));
        }
    }

    public function payments($projectId)
    {
        $project = $this->repo->requireById($projectId);
        $project->load('payments.partner');
        return view('projects.payments', compact('project'));
    }

    public function statusUpdate(Request $request, $projectId)
    {
        $project = $this->repo->updateStatus($request->get('status_id'), $projectId);
        flash()->success(trans('project.updated'));
        return redirect()->route('projects.show', $projectId);
    }

    public function featuresReorder(Request $request, $projectId)
    {
        if ($request->ajax()) {
            $data = $this->repo->featuresReorder($request->get('postData'));
            return 'oke';
        }

        return null;
    }
}
