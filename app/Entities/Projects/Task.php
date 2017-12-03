<?php

namespace App\Entities\Projects;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Task extends Model
{
    use PresentableTrait;

    protected $presenter = TaskPresenter::class;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'project_id');
    }
}
