<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;
use App\Entities\Partners\Customer;
use App\Entities\Users\User;
use DB;
use ProjectStatus;

/**
 * Projects Repository Class.
 */
class ProjectsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getProjects($q, $statusId, User $user)
    {
        $statusIds = array_keys(ProjectStatus::toArray());

        if ($user->hasRole('admin') == false) {
            return $user->projects()
                ->where(function ($query) use ($q, $statusId, $statusIds) {
                    $query->where('projects.name', 'like', '%'.$q.'%');

                    if ($statusId && in_array($statusId, $statusIds)) {
                        $query->where('status_id', $statusId);
                    }
                })
                ->latest()
                ->with(['customer', 'jobs'])
                ->paginate($this->_paginate);
        }

        return $this->model->latest()
            ->where(function ($query) use ($q, $statusId, $statusIds) {
                $query->where('name', 'like', '%'.$q.'%');

                if ($statusId && in_array($statusId, $statusIds)) {
                    $query->where('status_id', $statusId);
                }
            })
            ->with('customer')
            ->paginate($this->_paginate);
    }

    public function create($projectData)
    {
        $projectData['project_value'] = $projectData['proposal_value'] ?: 0;
        DB::beginTransaction();

        if (isset($projectData['customer_id']) == false || $projectData['customer_id'] == '') {
            $customer = $this->createNewCustomer($projectData['customer_name'], $projectData['customer_email']);
            $projectData['customer_id'] = $customer->id;
        }
        unset($projectData['customer_name']);
        unset($projectData['customer_email']);

        $project = $this->storeArray($projectData);
        DB::commit();

        return $project;
    }

    public function getStatusName($statusId)
    {
        return ProjectStatus::getNameById($statusId);
    }

    public function createNewCustomer($customerName, $customerEmail)
    {
        $newCustomer = new Customer();
        $newCustomer->name = $customerName;
        $newCustomer->email = $customerEmail;
        $newCustomer->save();

        return $newCustomer;
    }

    public function delete($projectId)
    {
        $project = $this->requireById($projectId);

        DB::beginTransaction();

        // Delete project payments
        $project->payments()->delete();

        // Delete jobs tasks
        $jobIds = $project->jobs->pluck('id')->all();
        DB::table('tasks')->whereIn('job_id', $jobIds)->delete();

        // Delete jobs
        $project->jobs()->delete();

        // Delete project
        $project->delete();

        DB::commit();

        return 'deleted';
    }

    public function updateStatus($statusId, $projectId)
    {
        $project = $this->requireById($projectId);
        $project->status_id = $statusId;
        $project->save();

        return $project;
    }

    public function jobsReorder($sortedData)
    {
        $jobOrder = explode(',', $sortedData);
        foreach ($jobOrder as $order => $jobId) {
            $job = $this->requireJobById($jobId);
            $job->position = $order + 1;
            $job->save();
        }

        return $jobOrder;
    }
}
