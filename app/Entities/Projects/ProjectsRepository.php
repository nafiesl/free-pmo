<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;
use App\Entities\Users\User;
use DB;
use Option;

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
            ->where(function($query) use ($q, $statusId, $statusIds) {
                $query->where('name','like','%'.$q.'%');
                if ($statusId && in_array($statusId, $statusIds))
                    $query->where('status_id', $statusId);
            })
            ->withCount('payments')
            ->paginate($this->_paginate);
    }

    public function create($projectData)
    {
        $projectData['project_value'] = $projectData['proposal_value'] ?: 0;
        $projectData['owner_id'] = auth()->id();
        DB::beginTransaction();

        if ($projectData['customer_id'] == '') {
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
        return getProjectStatusesList($statusId);
    }

    public function createNewCustomer($customerName, $customerEmail)
    {
        $newCustomer = new User;
        $newCustomer->name = $customerName;
        $newCustomer->email = $customerEmail;
        $newCustomer->username = str_replace(' ', '_', strtolower($customerName));
        $newCustomer->password = Option::get('default_password', 'member');
        $newCustomer->remember_token = str_random(10);
        $newCustomer->save();
        $newCustomer->assignRole('customer');
        return $newCustomer;
    }

    public function delete($projectId)
    {
        $project = $this->requireById($projectId);
        $project->payments()->delete();
        $project->features()->delete();

        return $project->delete();
    }
}