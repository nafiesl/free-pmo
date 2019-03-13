<?php

namespace App\Entities\Projects;

use App\Entities\Users\User;
use App\Entities\Projects\Project;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['project_id', 'title', 'body', 'pic_id', 'creator_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function pic()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => __('issue.no_pic')]);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
