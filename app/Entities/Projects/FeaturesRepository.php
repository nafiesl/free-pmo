<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;
use App\Entities\Projects\Project;
use DB;

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

    public function getUnfinishedFeatures()
    {
        return $this->model->whereHas('tasks', function($query) {
            return $query->where('progress','<',100);
        })
        ->with(['tasks','project','worker'])
        ->get();
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

    public function createFeatures($featuresData, $projectId)
    {
        $selectedFeatures = $this->model->whereIn('id', $featuresData['feature_ids'])->get();

        DB::beginTransaction();
        foreach ($selectedFeatures as $feature) {
            $newFeature = $feature->replicate();
            $newFeature->project_id = $projectId;
            $newFeature->save();

            $selectedTasks = $feature->tasks()->whereIn('id', $featuresData[$feature->id . '_task_ids'])->get();

            foreach ($selectedTasks as $task) {
                $newTask = $task->replicate();
                $newTask->progress = 0;
                $newTask->feature_id = $newFeature->id;
                $newTask->save();
            }
        }
        DB::commit();

        return 'ok';
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