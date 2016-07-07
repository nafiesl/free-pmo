<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;

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

    public function create($featureData)
    {
        dd($featureData);
        $featureData['feature_value'] = $featureData['proposal_value'];
        return $this->storeArray($featureData);
    }
}