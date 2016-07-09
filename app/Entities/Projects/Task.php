<?php

namespace App\Entities\Projects;

use App\Entities\Projects\TaskPresenter;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Task extends Model {

    use PresentableTrait;

    protected $presenter = TaskPresenter::class;
	protected $guarded = ['id','created_at','updated_at'];

    public function feature()
    {
        return $this->belongsTo(Feature::class, 'project_id');
    }

}
