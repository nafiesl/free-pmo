<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;
use App\Entities\Partners\Customer;
use DB;

/**
 * Projects Repository Class
 */
class ProjectsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getProjects($q, $statusId)
    {
        $statusIds = array_keys(getProjectStatusesList());

        return $this->model->latest()
            ->where(function ($query) use ($q, $statusId, $statusIds) {
                $query->where('name', 'like', '%'.$q.'%');
                if ($statusId && in_array($statusId, $statusIds)) {
                    $query->where('status_id', $statusId);
                }

            })
            ->withCount('payments')
            ->with('customer')
            ->paginate($this->_paginate);
    }

    public function create($projectData)
    {
        $projectData['project_value'] = $projectData['proposal_value'] ?: 0;
        $projectData['owner_id']      = auth()->id();
        DB::beginTransaction();

        if (isset($projectData['customer_id']) == false || $projectData['customer_id'] == '') {
            $customer                   = $this->createNewCustomer($projectData['customer_name'], $projectData['customer_email']);
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
        return getProjectStatusesList($statusId);
    }

    public function createNewCustomer($customerName, $customerEmail)
    {
        $newCustomer           = new Customer;
        $newCustomer->name     = $customerName;
        $newCustomer->email    = $customerEmail;
        $newCustomer->owner_id = auth()->user()->agency->id;
        $newCustomer->save();

        return $newCustomer;
    }

    public function delete($projectId)
    {
        $project = $this->requireById($projectId);

        DB::beginTransaction();

        // Delete project payments
        $project->payments()->delete();

        // Delete features tasks
        $featureIds = $project->features->pluck('id')->all();
        DB::table('tasks')->whereIn('feature_id', $featureIds)->delete();

        // Delete features
        $project->features()->delete();

        // Delete project
        $project->delete();

        DB::commit();
        return 'deleted';
    }

    public function getProjectFeatures($projectId, $type = null)
    {
        return Feature::where(function ($query) use ($projectId, $type) {
            $query->whereProjectId($projectId);
            if ($type) {
                $query->whereTypeId($type);
            }

        })->orderBy('position')->with('worker', 'tasks')->get();
    }

    public function updateStatus($statusId, $projectId)
    {
        $project            = $this->requireById($projectId);
        $project->status_id = $statusId;
        $project->save();

        return $project;
    }

    public function featuresReorder($sortedData)
    {
        $featureOrder = explode(',', $sortedData);
        foreach ($featureOrder as $order => $featureId) {
            $feature           = $this->requireFeatureById($featureId);
            $feature->position = $order + 1;
            $feature->save();
        }

        return $featureOrder;
    }
}
