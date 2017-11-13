<?php

namespace App\Entities\Projects;

use App\Entities\Projects\JobPresenter;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Job extends Model
{

    use PresentableTrait;

    protected $presenter = JobPresenter::class;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('progress')->orderBy('position');
    }

    public function type()
    {
        return $this->type_id == 1 ? 'Project' : 'Additional';
    }

}
