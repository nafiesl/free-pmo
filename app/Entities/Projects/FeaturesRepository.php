<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;
use App\Entities\Projects\Project;

/**
* Features Repository Class
*/
class FeaturesRepository extends BaseRepository
{
    protected $model;

    public function __construct(Feature $model)
    {
        parent::__construct($model);
    }

    public function requireProjectById($projectId)
    {
        return Project::findOrFail($projectId);
    }

    public function createFeature($featureData, $projectId)
    {
        $featureData['project_id'] = $projectId;
        return $this->storeArray($featureData);
    }

    public function getTasksByFeatureId($featureId)
    {
        return Task::whereFeatureId($featureId)->get();
    }

    public function requireTaskById($taskId)
    {
        return Task::findOrFail($taskId);
    }
}