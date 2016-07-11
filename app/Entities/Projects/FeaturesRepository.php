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
        $featureData['price'] = str_replace('.', '', $featureData['price']);
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

    public function update($featureData = [], $featureId)
    {
        foreach ($featureData as $key => $value) {
            if (!$featureData[$key]) $featureData[$key] = null;
        }

        $featureData['price'] = str_replace('.', '', $featureData['price']);
        $feature = $this->requireById($featureId);
        $feature->update($featureData);
        return $feature;
    }
}